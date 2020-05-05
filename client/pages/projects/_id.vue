<template>
  <div id="project">
    <div class="row">
      <div class="col-md-12">
        <!-- project form -->
        <project-form
          :clientOptions="$utility.getClientOptions(clients)"
          :statusOptions="$utility.getStatusOptions(statuses)"
          :project="project"
          :labelOptions="labels"
          @submit="submit"
        >
        </project-form>
        <!-- /project form -->
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
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
      submit (data) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 更新APIに飛ばす！
        }
      },
    }
  }
</script>
