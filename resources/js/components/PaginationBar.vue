/* eslint-disable quotes */
<template>
  <nav class="pagination is-small" role="navigation" aria-label="pagination">
    <button
      class="button pagination-previous"
      @click="previousPageClicked()"
      :disabled="current === 1"
    >Prev</button>
    <button
      class="button pagination-next"
      @click="nextPageClicked()"
      :disabled="current === last_page"
    >Next</button>
    <ul class="pagination-list">
      <a
        class="pagination-link"
        :class="{ 'is-current': current === 1 }"
        @click="firstPageClicked()"
      >1</a>
      <template v-if="last_page > 1">
        <span class="pagination-ellipsis">&hellip;</span>
        <a
          class="pagination-link"
          :class="{ 'is-current': current === last_page }"
          @click="lastPageClicked()"
        >{{ last_page }}</a>
      </template>
    </ul>
    <span class="mr-5">Page {{ current }} of {{ last_page }} page(s)</span>
    <span class="mr-5">Rows {{ from }} to {{ to }} of {{ total }}</span>
    <span>Per page:</span>
    <div class="control">
      <div class="select is-small is-narrow ml-2 mr-2">
        <select v-model="perpage" @change="changePerPage()">
          <option v-for="page in page_options" :key="page" :value="page">{{ page }}</option>
        </select>
      </div>
    </div>
    <span class="ml-2">Go to page:</span>
    <div class="control is-narrow ml-2 mr-2">
      <input
        type="number"
        class="input is-small is-narrow"
        v-model.lazy="current"
        min="1"
        :max="last_page"
      />
    </div>
    <button class="button is-small is-light" @click="changePage()">Go</button>
  </nav>
</template>

<script>
export default {
  props: [
    "current_page",
    "last_page",
    "per_page",
    "page_options",
    "from",
    "to",
    "total"
  ],
  data() {
    return {
      current: this.current_page,
      perpage: this.per_page
    };
  },
  watch: {
    current_page(current) {
      this.current = current;
    },
    per_page(i) {
      this.perpage = i;
    }
  },
  methods: {
    changePage() {
      this.$emit("page:changed", this.current);
    },
    changePerPage() {
      this.$emit("perpage:changed", this.perpage);
    },
    lastPageClicked() {
      this.$emit("lastpage:clicked");
    },
    firstPageClicked() {
      this.$emit("firstpage:clicked");
    },
    nextPageClicked() {
      this.$emit("nextpage:clicked");
    },
    previousPageClicked() {
      this.$emit("previouspage:clicked");
    }
  }
};
</script>
