<template>
  <div>
    <p class="help">All fields with * are required.</p>
    <div class="field is-horizontal mt-5">
      <div class="field-label is-normal">
        <label class="label">Competency*</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">
          <div class="control">
            <div
              id="select-competency"
              class="select is-fullwidth"
              :class="{ 'is-danger': server_errors.competency_uuid }"
            >
              <select
                id="competency_id"
                name="competency_uuid"
                ref="competency_id"
                v-model="competency_id"
                required
              >
                <option value>Select...</option>
                <option v-for="c in comps" :key="c.id" :value="c.uuid">{{ c.title }}</option>
              </select>
            </div>
          </div>
          <div v-if="server_errors.competency_uuid && competency_id == ''">
            <p
              v-for="err in server_errors.competency_uuid"
              :key="err"
              class="help is-danger"
              id="competency-help"
              v-text="err"
            ></p>
          </div>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Type*</label>
      </div>
      <div class="field-body">
        <div class="field is-narrow">
          <div class="control">
            <div
              id="select-type"
              class="select is-fullwidth"
              :class="{ 'is-danger': server_errors.type }"
            >
              <select id="type" name="type" v-model="type" required>
                <option value>Select...</option>
                <option value="M">Multiple Choice</option>
                <option value="T">True or False</option>
                <option value="I">Identification</option>
              </select>
            </div>
          </div>
          <div v-if="server_errors.type && type == ''">
            <p
              v-for="err in server_errors.type"
              :key="err"
              class="help is-danger"
              id="type-help"
              v-text="err"
            ></p>
          </div>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Question*</label>
      </div>
      <div class="field-body">
        <div class="field is-fullwidth">
          <div class="control">
            <textarea
              class="textarea"
              :class="{ 'is-danger': server_errors.question }"
              id="question"
              name="question"
              maxlength="250"
              rows="4"
              v-model="question"
              placeholder="Question"
              required
            ></textarea>
          </div>
          <div v-if="server_errors.question && question == ''">
            <p
              v-for="err in server_errors.question"
              :key="err"
              class="help is-danger"
              id="question-help"
              v-text="err"
            ></p>
          </div>
        </div>
      </div>
    </div>
    <div v-if="type == 'M'">
      <div class="field is-horizontal">
        <div class="field-label"></div>
        <div class="field-body">
          <div class="field is-fullwidth">
            <label class="label">Options*</label>
          </div>
        </div>
      </div>
      <div v-if="options">
        <div v-for="(opt, i) in options" :key="i">
          <div class="field is-horizontal mt-3">
            <div class="field-label"></div>
            <div class="field-body">
              <div class="field has-addons">
                <div class="control is-expanded">
                  <input
                    :id="'opts' + i"
                    class="input"
                    type="text"
                    placeholder="Option"
                    name="options[]"
                    :ref="'opts' + i"
                    v-model="options[i]"
                    :required="type == 'M'"
                  />
                </div>
                <div class="control">
                  <button
                    :id="'btn-del' + i"
                    class="button is-light"
                    @click="del(opt)"
                    title="Remove"
                  >
                    <span class="delete"></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="field is-horizontal mt-3 mb-3">
        <div class="field-label"></div>
        <div class="field-body">
          <div class="field is-grouped">
            <div class="control is-expanded">
              <input
                id="option"
                name="option"
                ref="option"
                class="input"
                :class="{ 'is-danger': server_errors.options }"
                type="text"
                placeholder="Option"
                @keypress.enter.self.stop.prevent="add"
                v-model="option"
              />
            </div>
            <div class="control">
              <button
                id="btn-add"
                class="button is-info"
                @click="add"
                :disabled="disabled"
              >Add option</button>
            </div>
            <div v-if="server_errors.options && options == ''">
              <p
                v-for="err in server_errors.options"
                :key="err"
                class="help is-danger"
                id="option-help"
                v-text="err"
              ></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="field is-horizontal mt-3 mb-3">
      <div class="field-label is-normal">
        <label class="label">Answer*</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <div v-if="type == 'I'">
              <input
                type="text"
                class="input"
                id="answer"
                name="answer"
                :class="{ 'is-danger': server_errors.answer }"
                v-model="answer"
                required
              />
            </div>
            <div
              v-else
              id="select-answer"
              class="select is-fullwidth"
              :class="{ 'is-danger': server_errors.answer }"
            >
              <select id="answer" name="answer" v-model="answer" required>
                <option value>Select...</option>
                <template v-if="options && type == 'M'">
                  <option v-for="(opt, i) in options" :key="i" :value="opt" v-text="opt"></option>
                </template>
                <template v-if="type == 'T'">
                  <option value="T">True</option>
                  <option value="F">False</option>
                </template>
              </select>
            </div>
          </div>
          <div v-if="server_errors.answer && answer == ''">
            <p
              v-for="err in server_errors.answer"
              :key="err"
              class="help is-danger"
              id="answer-help"
              v-text="err"
            ></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    errors: {
      type: String,
      required: true
    },
    request: {
      type: String
    },
    model: {
      type: String,
      required: true
    },
    competencies: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      competency_id: "",
      type: "",
      question: "",
      options: [],
      option: "",
      answer: "",
      disabled: true,
      server_errors: JSON.parse(this.errors),
      old: JSON.parse(this.request),
      comps: JSON.parse(this.competencies)
    };
  },
  mounted() {
    this.initializeInputs();
  },
  methods: {
    initializeInputs() {
      let keys;
      if (this.server_errors.length === 0) {
        const model = JSON.parse(this.model);
        keys = Object.keys(model);
        keys.forEach(key => {
          if (model[key] == null) {
            this[key] = "";
            return;
          }
          this[key] = model[key];
        });
        this.$refs.competency_id.focus();
        return;
      }
      keys = Object.keys(this.old);
      keys.forEach(key => {
        if (this.old[key] == null) {
          return (this[key] = "");
        }
        this[key] = this.old[key];
      });
    },
    reset() {
      this.option = "";
      this.$refs.option.focus();
    },
    add() {
      if (this.option !== "") {
        this.options.push(this.option);
        this.reset();
      }
    },
    del(opt) {
      const index = this.options.indexOf(opt);
      this.options.splice(index, 1);
      this.$refs.option.focus();
    }
  },
  watch: {
    option: function() {
      this.disabled = this.option == "";
    }
  }
};
</script>
