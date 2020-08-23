<template>
  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label">{{ label }}</label>
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <div class="select is-fullwidth" :class="classList">
            <select
              :id="id"
              :name="id"
              v-model="inputVal"
              :required="Boolean(required)"
              :autofocus="Boolean(autofocus)"
            >
              <option value>Select...</option>
              <option
                v-for="option in options"
                :key="option[optionValue]"
                :value="option[optionValue]"
              >{{ option[optionText] }}</option>
            </select>
          </div>
        </div>
        <p v-if="errors[id]" class="help is-danger" :id="$id + '-help'">{{ errors[id] }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    id: {
      type: String,
      default: null,
    },
    classList: {
      type: String,
      default: null,
    },
    options: {
      type: Array,
      required: true,
    },
    optionValue: {
      type: String,
      required: true,
    },
    optionText: {
      type: String,
      required: true,
    },
    value: {
      type: String,
      default: null,
    },
    required: {
      type: String,
      default: null,
    },
    autofocus: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      errors: {},
    };
  },
  computed: {
    inputVal: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      },
    },
  },
};
</script>
