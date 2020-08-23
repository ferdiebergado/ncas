<template>
  <div>
    <div class="columns" v-if="success">
      <div class="column">
        <div class="notification is-success is-light">
          <button class="delete"></button>
          Operation successful.
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column is-one-fifth">
        <a :href="createUrl" class="button is-small is-success is-rounded">NEW</a>
      </div>
      <div class="column is-four-fifths is-clearfix">
        <div class="is-pulled-right">
          <div class="field has-addons">
            <div class="control is-fullwidth">
              <input
                class="input is-small"
                type="search"
                placeholder="Search competencies"
                ref="search"
                v-model="search"
                @keypress.enter="fetchData(url)"
              />
            </div>
            <div class="control mr-1">
              <button
                class="button is-small is-light"
                @click="doSearch()"
                :disabled="search_disabled"
              >Search</button>
            </div>
            <div class="control mr-1">
              <button class="button is-small is-light" @click="reset()">Reset</button>
            </div>
            <div class="control">
              <div class="select is-small is-narrow">
                <select v-model="order_by">
                  <option value>Sort By</option>
                  <option value="id">ID</option>
                  <option value="title">Title</option>
                  <option value="level_id">Level</option>
                  <option value="category_id">Category</option>
                </select>
              </div>
              <div class="select is-small is-narrow">
                <select v-model="dir">
                  <option value>Sort Order</option>
                  <option value="asc">Ascending</option>
                  <option value="desc">Descending</option>
                </select>
              </div>
            </div>
            <div class="control">
              <button
                class="button is-small is-light"
                @click="fetchData(url)"
                :disabled="sort_disabled"
              >Sort</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="table-container">
          <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="30%">Title</th>
                <th width="5%">Level</th>
                <th width="30%">Category</th>
                <th class="is-centered" colspan="3" width="25%">Task(s)</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="items">
                <tr v-for="item in items" :key="item.id" height="5%">
                  <td>{{ item.id }}</td>
                  <td></td>
                  <td>{{ getType(item.type_id) }}</td>
                  <td>{{ getCategory(item.category_id) }}</td>
                  <td>
                    <a class="button is-light is-link is-small mb-2" :href="item.path">View</a>
                    <a class="button is-link is-small mb-2" :href="item.path + '/edit'">Edit</a>
                    <a
                      class="button is-danger is-link is-small mb-2"
                      @click="deleteItem(item.path)"
                    >Delete</a>
                  </td>
                </tr>
              </template>
              <tr v-else>
                <td>No data</td>
              </tr>
            </tbody>
          </table>
        </div>
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
          <button
            class="button pagination-previous"
            @click="fetchData(appendQueriesToUrl(prev_page_url))"
            :disabled="current_page == 1"
          >Prev</button>
          <button
            class="button pagination-next"
            @click="fetchData(appendQueriesToUrl(next_page_url))"
            :disabled="current_page == last_page"
          >Next</button>
          <ul class="pagination-list">
            <a
              class="pagination-link"
              :class="{ 'is-current': current_page == 1 }"
              @click="fetchData(appendQueriesToUrl(first_page_url))"
            >1</a>
            <template v-if="last_page > 1">
              <span class="pagination-ellipsis">&hellip;</span>
              <a
                class="pagination-link"
                :class="{ 'is-current': current_page == last_page }"
                @click="fetchData(appendQueriesToUrl(last_page_url))"
              >{{ last_page }}</a>
            </template>
          </ul>
          <span class="mr-5">Page {{ current_page }} of {{ last_page }} page(s)</span>
          <span class="mr-5">Rows {{ from }} to {{ to }}</span>
          <span>Per page:</span>
          <div class="control">
            <div class="select is-small is-narrow ml-2 mr-2">
              <select v-model="per_page" @change="changePageSize()">
                <option v-for="page in page_options" :key="page" :value="page">{{ page }}</option>
              </select>
            </div>
          </div>
          <span class="ml-2">Go to page:</span>
          <div class="control is-narrow ml-2 mr-2">
            <input
              type="number"
              class="input is-small is-narrow"
              v-model.lazy="current_page"
              min="1"
              :max="last_page"
            />
          </div>
          <button class="button is-small is-light" @click="fetchData(url)">Go</button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    new: {
      type: String,
      required: true
    },
    rows: {
      type: String,
      required: true
    },
    route: {
      type: String,
      required: true
    },
    enums: {
      type: String
    },
    pages: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      items: [],
      initialRows: JSON.parse(this.rows),
      types: JSON.parse(this.enums).types,
      success: false,
      current_page: 1,
      first_page_url: "",
      from: 1,
      last_page: 1,
      last_page_url: "",
      next_page_url: "",
      per_page: 10,
      prev_page_url: "",
      to: 1,
      total: 0,
      page_options: JSON.parse(this.pages),
      search: "",
      searching: false,
      path: this.route,
      createUrl: this.new,
      order_by: "",
      dir: ""
    };
  },
  computed: {
    url() {
      return `${this.path}?page=${this.current_page}${this.urlTail}`;
    },
    urlTail() {
      return `&perPage=${this.per_page}&from=${this.from}&to=${this.to}&search=${this.search}&order_by=${this.order_by}&dir=${this.dir}`;
    },
    search_disabled() {
      return this.search == "";
    },
    sort_disabled() {
      return this.order_by == "" || this.dir == "";
    }
  },
  watch: {
    order_by: function() {
      if (this.dir == "") {
        this.dir = "asc";
      }
    }
  },
  mounted() {
    this.setData(this.initialRows);
    this.$refs.search.focus();
  },
  methods: {
    setData(data) {
      this.items = data.data;
      const keys = Object.keys(data);
      keys.forEach(key => {
        if (key !== "data") {
          this[key] = data[key];
        }
      });
    },
    fetchData(url) {
      axios
        .get(url)
        .then(res => {
          this.setData(res.data);
        })
        .catch(e => {
          console.log(e.response);
        });
    },
    getLevel(level) {
      return this.levels[level];
    },
    getCategory(category) {
      return this.categories[category];
    },
    deleteItem(path) {
      if (confirm("Delete this item?")) {
        axios
          .delete(path)
          .then(res => {
            this.success = true;
            this.fetchData(this.url);
          })
          .catch(e => {
            console.log(e.response);
          });
      }
    },
    changePageSize() {
      this.current_page = 1;
      this.fetchData(this.url);
    },
    appendQueriesToUrl(url) {
      return url + this.urlTail;
    },
    doSearch() {
      this.searching = true;
      this.fetchData(this.url);
    },
    highlight(str) {
      if (!this.search || !this.searching) {
        return str;
      }
      return str.replace(this.search, `<mark>${this.search}</mark>`);
    },
    resetData() {
      this.current_page = 1;
      this.first_page_url = "";
      this.from = 1;
      this.last_page = 1;
      this.last_page_url = "";
      this.next_page_url = "";
      this.per_page = 10;
      this.prev_page_url = "";
      this.to = 1;
      this.total = 0;
      this.search = "";
      this.searching = false;
      this.order_by = "";
      this.dir = "";
    },
    reset() {
      this.resetData();
      this.fetchData(this.url);
    }
  }
};
</script>
