<template>
  <div id="client">
    <div class="row">
      <div class="col-md-12">
        <!-- client form -->
        <client-form
          @submit="submit"
          @editIcon="editIcon"
          :client="client"
          :labelOptions="labels"
        >
        </client-form>
        <!-- /client form -->
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import cloneDeep from 'lodash.clonedeep'
  import clientForm from '~/components/client/Form.vue'

  export default {
    layout: 'default',
    components: {
      clientForm,
    },
    head() {
      return {
        title: '取引先情報',
      }
    },
    async fetch ({ store }) {
      await Promise.all([
        store.dispatch('client/fetch'),
        store.dispatch('label/fetch'),
      ]);
    },
    computed: {
      ...mapState('client', ['clients']),
      ...mapState('label', ['clientLabels']),
      client() {
        return cloneDeep(this.clients.find(data => data.id == this.$route.params.id));
      },
      labels() {
        return cloneDeep(this.clientLabels);
      },
    },
    methods: {
      submit (data) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 更新APIに飛ばす！
        }
      },
      editIcon () {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: ファイル選択表示
        }
      },
    }
  }
</script>
