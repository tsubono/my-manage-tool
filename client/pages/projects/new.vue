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
            >
          </project-form>
          <!-- /project form -->
        </div>
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
      projectForm
    },
    head() {
      return {
        title: '案件情報登録',
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
      submit (data) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 登録APIに飛ばす！
        }
      },
    }
  }
</script>
