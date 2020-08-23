<template>
  <div class="modal" :class="{'is-active': isActive}">
    <div v-if="isCritical" class="modal-background" @click="close()"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ title }}</p>
        <button class="delete" aria-label="close" @click="close()"></button>
      </header>
      <section class="modal-card-body">
        <slot name="body"></slot>
      </section>
      <footer class="modal-card-foot">
        <slot name="footer"></slot>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  props: ["title", "show", "critical"],
  data() {
    return {
      isCritical: this.critical,
      isActive: this.show
    };
  },
  watch: {
    active(newState) {
      this.isActive = newState;
    }
  },
  methods: {
    close() {
      this.isActive = false;
      this.$emit("closed");
    }
  }
};
</script>
