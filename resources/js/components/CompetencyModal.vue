<template>
  <modal
    :show="show"
    :mode="mode"
    :title="title + ' Competency'"
    :critical="critical"
    @closed="show = false; competency = {}"
  >
    <template v-slot:body>
      <competency-form
        :competency="competency"
        :enums="constants"
        :title="title"
        :route="route"
        @form:closed="show_form = false; competency= {}; title = ''"
        @competency:saved="show_form = false; competency = {}; title = ''; fetchData(url)"
      ></competency-form>
    </template>
  </modal>
</template>

<script>
export default {
  props: ['show', 'mode', 'title', 'critical', 'competency'],
};
</script>
