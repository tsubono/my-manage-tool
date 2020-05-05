<template>
  <div id="client">
    <div class="row">
      <div class="col-md-12">
        <!-- client form -->
        <client-form
          @submit="submit"
          @editIcon="editIcon"
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
      clientForm
    },
    head() {
      return {
        title: '取引先情報登録',
      }
    },
    async fetch ({ store }) {
      await store.dispatch('label/fetch');
    },
    computed: {
      ...mapState('label', ['clientLabels']),
      labels() {
        return cloneDeep(this.clientLabels);
      },
    },
    methods: {
      submit (data) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 登録APIに飛ばす！
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
