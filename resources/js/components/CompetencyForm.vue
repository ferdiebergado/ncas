<template>
  <form @submit.prevent="save" novalidate>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Title*</label>
      </div>
      <div class="field-body">
        <div class="field is-fullwidth">
          <p class="control">
            <input
              type="text"
              class="input"
              :class="{ 'is-danger': errors.title }"
              id="title"
              name="title"
              min="3"
              max="200"
              placeholder="Title"
              v-model="form.title"
              required
              autofocus
            />
          </p>
          <p v-if="errors.title" class="help is-danger" id="help-title">{{ errors.title }}</p>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Level*</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">
          <div class="control">
            <div
              id="select-level"
              class="select is-fullwidth"
              :class="{ 'is-danger': errors.level_id }"
            >
              <select id="level_id" name="level_id" v-model="form.level_id" required>
                <option value>Select...</option>
                <option
                  v-for="(level, index) in constants.levels"
                  :key="level"
                  :value="index"
                >{{ level }}</option>
              </select>
            </div>
          </div>
          <p v-if="errors.level_id" class="help is-danger" id="help-level">{{ errors.level_id }}</p>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Category*</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">
          <div class="control">
            <div
              id="select-category"
              class="select is-fullwidth"
              :class="{'is-danger': errors.category_id }"
            >
              <select id="category_id" name="category_id" v-model="form.category_id" required>
                <option value>Select...</option>
                <option
                  v-for="(category, index) in constants.categories"
                  :key="category"
                  :value="index"
                >{{ category }}</option>
              </select>
            </div>
          </div>
          <p
            v-if="errors.category_id"
            class="help is-danger"
            id="help-category"
          >{{ errors.category_id }}</p>
        </div>
      </div>
    </div>
    <div class="field is-horizontal mb-3">
      <div class="field-label"></div>
      <div class="field-body">
        <p class="control">
          <button id="btn-submit" class="button is-success is-rounded" type="submit">Save</button>
          <button class="button is-text ml-2" @click="close">Close</button>
        </p>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: ["enums", "route"],
  data() {
    return {
      form: this.competency,
      constants: this.enums,
      errors: {},
      mode: this.title
    };
  },
  watch: {
    competency(competency) {
      this.form = competency;
    },
    title(mode) {
      this.mode = mode;
    }
  },
  methods: {
    validateInput() {
      if (this.form.title === undefined || this.form.title === "") {
        this.errors.title = "Title is required.";
      } else {
        this.errors.title = "";
      }
    },
    save() {
      this.validateInput();
      //   console.log("errors.length: " + Object.keys(this.errors).length);
      if (!this.errors) {
        if (this.mode === "Create") {
          axios
            .post(this.route, this.form)
            .then(res => {
              this.handleSuccess(res.data);
            })
            .catch(e => {
              this.handleError(e);
            });
          return;
        }
        axios
          .put(`/api${this.competency.path}`, this.form)
          .then(res => {
            this.handleSuccess(res.data);
          })
          .catch(e => {
            this.handleError(e);
          });
      }
    },
    close() {
      this.$emit("form:closed");
    },
    handleSuccess(data) {
      console.log(data);
      this.$emit("competency:saved");
      this.$root.type = "is-success";
      this.$root.message = "Operation successful.";
      this.$root.fade = true;
      this.$root.file = "";
    },
    handleError(e) {
      console.log(e.response);
      this.$root.type = "is-danger";
      this.$root.message = e.response.message;
      this.$root.fade = false;
      this.$root.file = "";
    }
  }
};
</script>
