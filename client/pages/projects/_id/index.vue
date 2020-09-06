<template>
  <div id="project">
    <div class="row">
      <div class="col-md-12">
        <!-- project form -->
        <project-form
          :clientOptions="$utility.getClientOptions(clients)"
          :statuses="statuses"
          :project="project"
          :labelOptions="labels"
          :subcontractorOptions="subcontractors"
          @submit="submit"
          :errors="errors"
        >
        </project-form>
        <!-- /project form -->
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import cloneDeep from 'lodash.clonedeep'
  import projectForm from '~/components/project/Form.vue'

  export default {
    layout: 'default',
    components: {
      projectForm,
    },
    head() {
      return {
        title: '案件情報',
      }
    },
    data() {
      return {
        errors: {},
      }
    },
    async fetch ({ store }) {
      await Promise.all([
        store.dispatch('project/fetch'),
        store.dispatch('client/fetch'),
        store.dispatch('label/fetch'),
        store.dispatch('subcontractor/fetch'),
      ]);
    },
    computed: {
      ...mapState('project', ['projects', 'statuses']),
      ...mapState('client', ['clients']),
      ...mapState('label', ['projectLabels']),
      ...mapState('subcontractor', ['subcontractors']),
      /**
       * IDにひもづく案件を取得
       *
       * @returns {[]}
       */
      project() {
        return cloneDeep(this.projects.find(data => data.id == this.$route.params.id));
      },
      labels() {
        return cloneDeep(this.projectLabels);
      },
    },
    methods: {
      ...mapActions('project', ['update']),
      async submit (project) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.update(project);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$router.push({ name: 'projects' });
          }
        }
      },
    }
  }
</script>
