<template>
  <div>
    <div class="columns">
      <div class="column">
        <!-- create button -->
        <a :href="createurl" class="button is-small is-success is-rounded" title="Create">CREATE</a>
      </div>
      <div class="column is-clearfix">
        <div class="is-pulled-right">
          <!-- reset button -->
          <button
            class="button is-small is-light mr-1"
            title="Clear all filters"
            @click="resetTable()"
          >Reset</button>

          <!-- refresh button -->
          <button class="button is-small is-light mr-1" title="Refresh" @click="fetchData()">Refresh</button>

          <!-- export menu -->
          <div
            class="dropdown is-right"
            :class="{ 'is-active': showExportMenu }"
            @mouseleave="showExportMenu = false"
          >
            <div class="dropdown-trigger">
              <button
                class="button is-small is-light"
                aria-haspopup="true"
                aria-controls="dropdown-menu"
                title="Export"
                @click="showExportMenu = !showExportMenu"
              >Export</button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu" role="menu">
              <div class="dropdown-content">
                <a class="dropdown-item" @click="exportData('pdf')">PDF</a>
                <a class="dropdown-item" @click="exportData('excel')">Excel</a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item">Print</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="table-container">
          <table class="table is-bordered is-narrow is-fullwidth">
            <!-- table header -->
            <thead>
              <tr>
                <th v-for="col in cols" :key="col.label" class="is-clearfix" :width="col.width">
                  {{ col.label }}
                  <!-- sort button -->
                  <span>
                    <a class="button is-text is-small is-pulled-right" @click="sort(col.name)">#</a>
                  </span>

                  <!-- filter select -->
                  <div v-if="col.values" class="select is-small is-fullwidth">
                    <select v-model="filters[col.name]" @change="filterData()">
                      <option value></option>
                      <option
                        v-for="(value, index) in col.values"
                        :key="value"
                        :value="index"
                      >{{ value }}</option>
                    </select>
                  </div>

                  <!-- search box -->
                  <input
                    v-else
                    class="input is-small is-fullwidth"
                    type="search"
                    v-model.trim="filters[col.name]"
                    placeholder="Search"
                    @keypress.enter="filterData()"
                  />
                </th>
                <th class="has-text-centered">Task(s)</th>
              </tr>
            </thead>
            <!-- table body -->
            <tbody>
              <!-- loading indicator -->
              <div v-show="loading">
                <img class="overlay-text" src="/ajax-loader.gif" alt="ajax-loader" />
              </div>

              <!-- table rows -->
              <template v-if="rows.length > 0">
                <tr v-for="(row, index) in rows" :key="row.id">
                  <td
                    v-for="col in cols"
                    :key="col.name"
                    :width="col.width"
                    :class="{'has-text-centered': !!col.centered}"
                  >{{ col.values ? col.values[row[col.name]] : row[col.name] }}</td>
                  <td class="has-text-centered">
                    <a :href="row.path" class="button is-small is-info">View</a>
                    <a :href="row.path+'/edit'" class="button is-small is-warning">Edit</a>
                    <a
                      class="button is-small is-danger"
                      @click="deleteRecord(row.id, row.path)"
                    >Delete</a>
                    <a :href="row.path+'/export'" class="button is-small is-light">Export</a>
                    <!-- <div
                      :ref="'dropdown'+row.id"
                      class="dropdown is-right"
                      :class="{'is-up': index > 2 }"
                    >
                      <div class="dropdown-trigger">
                        <button
                          class="button is-small is-info is-rounded"
                          aria-haspopup="true"
                          aria-controls="dropdown-menu2"
                          title="Manage"
                          @click="showManageMenu(row.id)"
                        >Manage</button>
                      </div>
                      <div
                        class="dropdown-menu"
                        id="dropdown-menu2"
                        role="menu"
                      >
                        <div class="dropdown-content has-text-left">
                          <a :href="row.path" class="dropdown-item">View</a>
                          <a :href="row.path+'/edit'" class="dropdown-item">Edit</a>
                          <a class="dropdown-item" @click="deleteRecord(row.id, row.path)">Delete</a>
                          <hr class="dropdown-divider" />
                          <a :href="row.path+'/export'" class="dropdown-item">Export</a>
                        </div>
                      </div>
                    </div>-->
                  </td>
                </tr>
              </template>
              <tr v-else>
                <td
                  :colspan="Object.keys(cols).length + 1"
                  class="has-text-centered"
                >No record found.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- pagination bar -->
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
          <!-- previous page -->
          <button
            class="button pagination-previous"
            @click="gotoPreviousPage()"
            :disabled="pagination.current_page === 1"
          >Previous</button>

          <!-- next page -->
          <button
            class="button pagination-next"
            @click="gotoNextPage()"
            :disabled="pagination.current_page === pagination.last_page"
          >Next</button>

          <!-- Per page -->
          <span class="ml-2">Per page:</span>
          <div class="select is-small mr-2">
            <select class="is-narrow" v-model="perPage" @change="updatePerPage()">
              <option v-for="option in perPageOptions" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <span
            class="mr-2"
          >Rows {{ pagination.from }} to {{ pagination.to }} of {{pagination.total }}</span>

          <!-- Goto page -->
          <span class="ml-5 mr-2">Page</span>
          <div class="control mr-2">
            <input
              type="number"
              class="input is-small is-narrow"
              min="1"
              :max="pagination.last_page"
              v-model.number="page"
              @keypress.enter="fetchData()"
            />
          </div>
          <span class="mr-2">of {{ pagination.last_page }}</span>

          <!-- first/last page -->
          <div class="pagination-list mr-2 ml-2">
            <!-- first page -->
            <a
              class="pagination-link"
              :class="{ 'is-current': pagination.current_page === 1}"
              aria-label="Goto page 1"
              @click="gotoFirstPage()"
            >1</a>

            <!-- last page -->
            <div v-if="pagination.last_page > 1">
              <span class="pagination-ellipsis">&hellip;</span>
              <a
                class="pagination-link"
                :class="{ 'is-current': pagination.current_page === pagination.last_page}"
                aria-label="Goto last page"
                @click="gotoLastPage()"
              >{{ pagination.last_page }}</a>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['createurl', 'route', 'columns'],
  data() {
    return {
      cols: JSON.parse(this.columns),
      rows: [],
      pagination: {},
      orderBy: '',
      asc: false,
      filters: {},
      page: 1,
      perPageOptions: [10, 25, 50, 100],
      perPage: 10,
      filter: false,
      loading: false,
      showExportMenu: false,
      byBatch: true,
    };
  },
  computed: {
    dir() {
      return this.asc ? 'asc' : 'desc';
    },
    orderUri() {
      let uri = `&order_by=${this.orderBy}`;
      if (this.orderBy !== '') {
        uri += `&dir=${this.dir}`;
      }
      return uri;
    },
    filterUri() {
      let uri = `&filter=${this.filter}`;
      const keys = Object.keys(this.filters);
      keys.forEach((key) => {
        uri += `&${key}=${this.filters[key]}`;
      });
      return uri;
    },
    url() {
      return `${this.route}?page=${this.page}&per_page=${this.perPage}&from=${this.pagination.from || 1}&to=${this.pagination.to || 1}${this.filterUri}${this.orderUri}`;
    },
    exportUrl() {
      return `${this.route}/export?batch=${this.byBatch}${this.filterUri}${this.orderUri}&export=`;
    },
  },
  mounted() {
    // this.initializeFilters();
    this.fetchData();
  },
  methods: {
    initializeFilters() {
      this.cols.forEach((col) => {
        if (col.values) {
          this.filters[col.name] = '';
        }
      });
    },
    fetchData() {
      this.loading = true;
      axios.get(this.url).then((res) => {
        this.rows = res.data.data;
        delete res.data.data;
        this.pagination = res.data;
        this.loading = false;
      }).catch((e) => {
        console.log(e.response);
      });
    },
    // showManageMenu(id) {
    //   this.$refs[`dropdown${id}`][0].classList.toggle('is-active');
    // },
    gotoFirstPage() {
      this.page = 1;
      this.fetchData();
    },
    gotoNextPage() {
      this.page += 1;
      this.fetchData();
    },
    gotoPreviousPage() {
      this.page -= 1;
      this.fetchData();
    },
    gotoLastPage() {
      this.page = this.pagination.last_page;
      this.fetchData();
    },
    updatePerPage() {
      const lastPage = Math.ceil(this.pagination.total / this.perPage);
      if (this.pagination.current_page > lastPage) {
        this.page = lastPage;
      }
      this.fetchData();
    },
    filterData() {
      this.filter = true;
      this.page = 1;
      this.fetchData();
    },
    sort(field) {
      this.orderBy = field;
      this.asc = !this.asc;
      this.fetchData();
    },
    resetTable() {
      this.filters = {};
      this.orderBy = '';
      this.page = 1;
      this.fetchData();
    },
    exportData(type) {
      axios
        .get(`${this.exportUrl}${type}`)
        .then((res) => {
          console.log(res.data);
          this.showExportMenu = false;
          const message = {
            type: 'is-info',
            message: "Export started. You'll be notified when it's ready for download.",
            fade: true,
          };
          this.$root.messages.push(message);
        })
        .catch((e) => {
          console.log(res.response);
        });
    },
    deleteRecord(id, path) {
      if (confirm(`Are you sure you want to delete the record with id ${id}?`)) {
        axios
          .delete(`/api${path}`)
          .then((res) => {
            this.fetchData();
          })
          .catch((e) => {
            console.log(e.response);
          });
      }
    },
  },
};
</script>
