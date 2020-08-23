<template>
  <div>
    <div class="field is-horizontal">
      <div class="field-label">
        <label class="label">ID</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">{{ item.id }}</div>
      </div>
    </div>

    <div class="field is-horizontal">
      <div class="field-label">
        <label class="label">Title</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">{{ item.title }}</div>
      </div>
    </div>

    <div class="field is-horizontal">
      <div class="field-label">
        <label class="label">Level</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">{{ constants.levels[item.level_id] }}</div>
      </div>
    </div>

    <div class="field is-horizontal">
      <div class="field-label">
        <label class="label">Category</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">{{ constants.categories[item.category_id] }}</div>
      </div>
    </div>

    <p class="help is-right">
      Created at:
      {{ item.created_at }}
    </p>

    <div class="is-clearfix">
      <div class="column is-pulled-right">
        <a class="button is-info" @click="edit">Edit</a>
        <button class="button is-text ml-2" @click="close">Close</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["competency", "enums"],
  data() {
    return {
      item: this.competency,
      constants: this.enums
    };
  },
  watch: {
    competency(comp) {
      this.item = comp;
    }
  },
  methods: {
    edit() {
      this.$emit("edit:competency");
    },
    close() {
      this.$emit("form:closed");
    }
  }
};
</script>

