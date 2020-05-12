<template>
  <div id="project">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <!-- project form -->
          <project-form
            :clientOptions="$utility.getClientOptions(clients)"
            :statuses="statuses"
            :labelOptions="labels"
            @submit="submit"
            :errors="errors"
          >
          </project-form>
          <!-- /project form -->
        </div>
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
      projectForm
    },
    head() {
      return {
        title: '案件情報登録',
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
      ]);
    },
    computed: {
      ...mapState('project', ['projects', 'statuses']),
      ...mapState('client', ['clients']),
      ...mapState('label', ['projectLabels']),
      labels() {
        return cloneDeep(this.projectLabels);
      },
    },
    methods: {
      ...mapActions('project', ['store']),
      async submit (project) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.store(project);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$router.push({name: 'projects'});
          }
        }
      }
    },
  }
</script>
