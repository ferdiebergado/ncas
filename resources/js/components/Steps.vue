<template>
  <div class="steps" id="stepsDemo">
    <div v-for="step in steps" :key="step" class="step-item" :class="{'is-active': active}">
      <div class="step-marker">{{ step.marker }}</div>
      <div class="step-details">
        <p class="step-title">{{ step.title }}</p>
      </div>
    </div>
    <div class="steps-content">
      <slot></slot>
    </div>
    <div class="steps-actions">
      <div class="steps-action">
        <a class="button is-light">Previous</a>
      </div>
      <div class="steps-action">
        <a class="button is-primary">Next</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    steps: {
      type: String,
      required: true,
    },
  },

};
</script>

<style lang="scss" scoped>
</style>
