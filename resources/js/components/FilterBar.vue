/* eslint-disable quotes */
<template>
  <div class="columns">
    <div class="column is-clearfix">
      <a
        :href="route.replace('/api','') + '/create'"
        class="button is-small is-success is-rounded"
      >NEW</a>
      <div class="is-pulled-right">
        <div class="field has-addons">
          <div class="control">
            <input
              id="search"
              name="search"
              class="input is-small is-fullwidth"
              type="search"
              placeholder="Search competencies"
              ref="search"
              v-model="search"
              @keypress.enter="doSearch()"
            />
          </div>
          <div class="control mr-1">
            <button
              id="btn-search"
              class="button is-small is-light"
              @click="doSearch()"
              :disabled="search_disabled"
            >Search</button>
          </div>
          <div class="control mr-1">
            <button id="btn-reset" class="button is-small is-light" @click="doReset()">Reset</button>
          </div>
          <div class="control">
            <div class="select is-small is-narrow">
              <select id="order" name="order" v-model="order">
                <option value>Sort By</option>
                <option
                  v-for="field in fields_to_sort"
                  :key="field.value"
                  :value="field.value"
                >{{ field.label }}</option>
              </select>
            </div>
            <div class="select is-small is-narrow">
              <select id="direction" name="direction" v-model="direction">
                <option value>Sort Order</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
              </select>
            </div>
          </div>
          <div class="control">
            <button
              id="btn-sort"
              class="button is-small is-light"
              @click="doSort()"
              :disabled="sort_disabled"
            >Sort</button>
          </div>

          <div
            class="dropdown is-right ml-2"
            :class="{ 'is-active': active}"
            @mouseleave="active = false"
          >
            <div class="dropdown-trigger">
              <button
                id="btn-export"
                class="button is-small is-light"
                aria-haspopup="true"
                aria-controls="dropdown-menu3"
                @click="active = !active"
              >Export</button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu3" role="menu">
              <div class="dropdown-content">
                <a id="link-pdf" class="dropdown-item" @click="exportData('pdf')">PDF</a>
                <a id="link-excel" class="dropdown-item" @click="exportData('excel')">Excel</a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item">Print</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['route', 'sort_fields', 'level_id', 'category_id', 'order_by', 'dir', 'batch'],
  data() {
    return {
      search: '',
      fields_to_sort: JSON.parse(this.sort_fields),
      order: this.order_by,
      direction: this.dir,
      active: false,
      by_batch: this.batch,
    };
  },
  computed: {
    search_disabled() {
      return this.search === '';
    },
    sort_disabled() {
      return this.order === '' || this.direction === '';
    },
    export_url() {
      return `${this.route}/export?search=${this.search}&category_id=${this.category_id}&level_id=${this.level_id}&order_by=${this.order}&dir=${this.direction}&filter=1&batch=${this.batch}&export=`;
    },
  },
  watch: {
    order_by(order) {
      this.order = order;
      if (this.order_by !== '' && this.dir === '') {
        this.direction = 'asc';
      }
    },
    dir(dir) {
      this.direction = dir;
    },
    batch(byBatch) {
      this.by_batch = byBatch;
    },
  },
  mounted() {
    this.$refs.search.focus();
  },
  methods: {
    doSort() {
      this.$emit('sort:clicked', [this.order, this.direction]);
    },
    doReset() {
      this.search = '';
      this.order = '';
      this.direction = '';
      this.$emit('reset:clicked');
    },
    doSearch() {
      this.$emit('search:clicked', this.search);
    },
    exportData(type) {
      this.$root.fade = false;
      this.$root.file = '';
      axios
        .get(this.export_url + type)
        .then((res) => {
          console.log(res.data);
          this.$root.message = "Export started. You'll be notified when it's ready for download.";
          this.$root.type = 'is-info';
          this.active = false;
        })
        .catch((e) => {
          console.log(res.response);
        });
    },
  },
};
</script>
