<template>
  <transition name="fade">
    <div class="notification is-light mb-5" :class="type">
      <button class="delete" @click="deleteMessage"></button>
      {{ message }}
      <span v-if="file">
        <a :href="'/download?file=' + file">{{ file }}</a>
      </span>
    </div>
  </transition>
</template>

<script>
export default {
  props: ['type', 'message', 'file', 'fade', 'id'],
  mounted() {
    if (this.fade) {
      setTimeout(() => {
        this.deleteMessage();
      }, 5000);
    }
  },
  methods: {
    deleteMessage() {
      const { messages } = this.$root;
      messages.splice(messages.findIndex((message) => message.id === this.id), 1);
    },
  },
};
</script>
