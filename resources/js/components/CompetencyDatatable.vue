/* eslint-disable quotes */
<template>
  <div>
    <filter-bar
      :route="route"
      :sort_fields="sort_fields"
      :level_id="level_id"
      :category_id="category_id"
      :order_by="order_by"
      :dir="dir"
      :batch="batch"
      @search:clicked="doSearch($event)"
      @sort:clicked="sortData($event)"
      @reset:clicked="reset()"
    ></filter-bar>
    <div class="columns">
      <div class="column">
        <div class="table-container">
          <table id="datatable" class="table is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="30%">Title</th>
                <th width="5%">
                  Level
                  <p class="select is-small is-narrow mt-2">
                    <select
                      id="level"
                      name="level"
                      v-model="level_id"
                      @change="resetPageAndFetch()"
                    >
                      <option value>Filter</option>
                      <option
                        v-for="(level, index) in constants.levels"
                        :key="index"
                        :value="index"
                      >{{ level }}</option>
                    </select>
                  </p>
                </th>
                <th width="30%">
                  Category
                  <p class="select is-small is-narrow mt-2">
                    <select
                      id="category"
                      name="category"
                      v-model="category_id"
                      @change="resetPageAndFetch()"
                    >
                      <option value>Filter</option>
                      <option
                        v-for="(category, index) in constants.categories"
                        :key="index"
                        :value="index"
                      >{{ category }}</option>
                    </select>
                  </p>
                </th>
                <th class="is-centered" colspan="3" width="25%">Task(s)</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td class="has-text-centered" colspan="5">Loading...</td>
              </tr>
              <template v-else>
                <template v-if="data.data && data.data.length > 0">
                  <tr v-for="(item, index) in data.data" :key="item.id" height="50px">
                    <td width="5%" :id="'id'+index">{{ item.id }}</td>
                    <td width="30%" :id="'title'+index" v-html="highlight(item.title)"></td>
                    <td width="5%">{{ getLevel(item.level_id) }}</td>
                    <td width="30%">{{ getCategory(item.category_id) }}</td>
                    <td width="25%">
                      <a :href="item.path" class="button is-info is-link is-small mb-2">View</a>
                      <a :href="item.path + '/edit'" class="button is-warning is-small mb-2">Edit</a>
                      <a
                        class="button is-danger is-link is-small mb-2"
                        @click="confirmDelete(item)"
                      >Delete</a>
                    </td>
                  </tr>
                </template>
                <tr v-else>
                  <td colspan="2">No data</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <pagination-bar
          :current_page="data.current_page"
          :last_page="data.last_page"
          :per_page="data.per_page"
          :from="data.from"
          :to="data.to"
          :total="data.total"
          :page_options="page_options"
          @page:changed="changePage($event)"
          @perpage:changed="changePerPage($event)"
          @lastpage:clicked="gotoLastPage()"
          @firstpage:clicked="gotoFirstPage()"
          @nextpage:clicked="gotoNextPage()"
          @previouspage:clicked="gotoPreviousPage()"
        ></pagination-bar>
      </div>
    </div>
    <modal :show="showModal" title="Confirmation" :critical="true" @closed="showModal = false">
      <template v-slot:body>
        <p>Are you sure you want to delete the competency "{{ competency.title }}"?</p>
      </template>
      <template v-slot:footer>
        <button class="button is-danger" @click="deleteItem(competency.path)">Yes, delete it.</button>
        <button class="button" @click="showModal = false">Cancel</button>
      </template>
    </modal>
  </div>
</template>

<script>
import Modal from './Modal';
import PaginationBar from './PaginationBar';
import FilterBar from './FilterBar';

export default {
  components: {
    FilterBar,
    PaginationBar,
    Modal,
  },
  props: {
    route: {
      type: String,
      required: true,
    },
    enums: {
      type: String,
    },
    pages: {
      type: String,
      required: true,
    },
    sortfields: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      data: {},
      constants: JSON.parse(this.enums),
      page_options: JSON.parse(this.pages),
      search: '',
      searching: false,
      order_by: '',
      dir: '',
      category_id: '',
      level_id: '',
      loading: false,
      showModal: false,
      competency: '',
      sort_fields: this.sortfields,
      filter: false,
      batch: true,
    };
  },
  computed: {
    url() {
      return `${this.route}?page=${this.data.current_page || 1}${this.urlTail}`;
    },
    urlTail() {
      return `&per_page=${this.data.per_page || 10}&from=${this.data.from
        || 1}&to=${this.data.to || 1}&search=${this.search}&category_id=${
        this.category_id
      }&level_id=${this.level_id}&order_by=${this.order_by}&dir=${
        this.dir
      }&filter=${this.filter}&batch=${this.batch}`;
    },
  },
  mounted() {
    this.fetchData(this.url);
    this.filter = true;
  },
  methods: {
    fetchData(url) {
      this.loading = true;
      axios
        .get(url)
        .then((res) => {
          this.data = res.data;
          this.loading = false;
        })
        .catch((e) => {
          console.log(e.response);
          this.$root.type = 'is-danger';
          this.$root.message = e.response.data.message;
          this.$root.fade = false;
          this.$root.file = '';
        });
    },
    getLevel(level) {
      return this.constants.levels[level];
    },
    getCategory(category) {
      return this.constants.categories[category];
    },
    confirmDelete(item) {
      this.competency = item;
      this.showModal = true;
    },
    deleteItem(path) {
      axios
        .delete(`/api${path}`)
        .then((res) => {
          this.competency = '';
          this.$root.type = 'is-success';
          this.$root.message = 'Operation successful.';
          this.$root.fade = true;
          this.fetchData(this.url);
        })
        .catch((e) => {
          this.$root.type = 'is-danger';
          this.$root.message = e.response.data.message;
          this.$root.fade = false;
          console.log(e.response);
        })
        .finally(() => {
          this.showModal = false;
          this.item = '';
          this.$root.file = '';
        });
    },
    resetPageAndFetch() {
      this.data.current_page = 1;
      this.fetchData(this.url);
    },
    appendQueriesToUrl(url) {
      return url + this.urlTail;
    },
    doSearch(search) {
      this.searching = true;
      this.search = search;
      this.resetPageAndFetch();
    },
    highlight(str) {
      if (!this.search || !this.searching) {
        return str;
      }
      return str.replace(this.search, `<mark>${this.search}</mark>`);
    },
    changePage(page) {
      this.data.current_page = page;
      this.fetchData(this.url);
    },
    changePerPage(perPage) {
      this.data.per_page = perPage;
      this.resetPageAndFetch();
    },
    gotoLastPage() {
      this.fetchData(this.appendQueriesToUrl(this.data.last_page_url));
    },
    gotoFirstPage() {
      this.fetchData(this.appendQueriesToUrl(this.data.first_page_url));
    },
    gotoNextPage() {
      this.fetchData(this.appendQueriesToUrl(this.data.next_page_url));
    },
    gotoPreviousPage() {
      this.fetchData(this.appendQueriesToUrl(this.data.prev_page_url));
    },
    sortData(arg) {
      const [orderBy, dir] = arg;
      this.order_by = orderBy;
      this.dir = dir;
      this.fetchData(this.url);
    },
    resetData() {
      this.data = {};
      this.search = '';
      this.searching = false;
      this.order_by = '';
      this.dir = '';
      this.category_id = '';
      this.level_id = '';
    },
    reset() {
      this.resetData();
      this.fetchData(this.url);
    },
  },
};
</script>
