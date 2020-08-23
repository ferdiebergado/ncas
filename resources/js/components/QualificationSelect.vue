<template>
  <div>
    <v-select
      label="Qualification"
      id="qualification_id"
      :options="qualifications"
      option-value="qualification_id"
      option-text="title"
      v-model="qualificationId"
      required="true"
    ></v-select>

    <div
      v-if="qualification.competencies && qualification.competencies.length > 0"
      class="field is-horizontal"
    >
      <div class="field-label is-normal">
        <label class="label"></label>
      </div>

      <div class="field-body">
        <div class="field">
          <div class="control">
            <p class="label">Competenc(y/ies)</p>
            <div v-for="(c, index) in competencies" :key="c.competency_id">
              <input type="hidden" :name="'competencies[' + index + ']'" :value="c.competency_id" />
              <div class="control mt-2">
                COC {{ c.level }} - {{ c.title }}
                <button
                  v-if="index > 0"
                  class="button is-text is-small is-white"
                  @click.prevent="removeCompetency(c)"
                  :disabled="index < (competencies.length - 1)"
                >
                  <span class="delete" title="Remove competency"></span>
                </button>
              </div>
            </div>
            <div v-if="cPool.length > 0" class="field">
              <button
                class="button is-outline mt-3 mb-3"
                @click.prevent="addCompetency()"
              >Add next competency...</button>
              <p>Available competencies:</p>
              <ul>
                <li v-for="c in cPool" :key="c.competency_id">COC-{{ c.level }} {{ c.title }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VSelect from './VSelect.vue';
import { compareValues } from '../compare_values';

export default {
  components: {
    VSelect,
  },
  data() {
    return {
      qualifications: [],
      qualificationId: '',
      qualification: {},
      competencies: [],
      cPool: [],
    };
  },
  watch: {
    qualificationId(id) {
      const qualification = this.qualifications.filter((q) => (q.qualification_id === id));
      const [q] = qualification;
      this.qualification = q;
      this.competencies = [];
      this.cPool = [...q.competencies];
      if (q.competencies.length > 0) {
        this.addCompetency();
      }
    },
  },
  mounted() {
    axios.get('/api/qualifications').then((res) => {
      this.qualifications = res.data;
    }).catch((e) => {
      console.log(e.response);
    });
  },
  methods: {
    addCompetency() {
      this.competencies.push(this.cPool[0]);
      this.cPool.splice(0, 1);
    },
    removeCompetency(competency) {
      this.competencies.splice(this.competencies.indexOf(competency), 1);
      this.cPool.push(competency);
      this.cPool.sort(compareValues('level'));
    },
  },
};
</script>
