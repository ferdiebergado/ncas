<template>
  <div></div>
</template>

<script>
export default {
  props: ['id'],
  mounted() {
    Echo.private(`App.User.${this.id}`).notification((notification) => {
      console.log(notification);
      const { id, message, file } = notification;
      const { messages } = this.$root;
      const msg = {
        id,
        type: 'is-info',
        message,
        file,
        fade: false,
      };
      messages.push(msg);
    });
  },
};
</script>
