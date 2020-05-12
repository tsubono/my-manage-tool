<template>
  <div id="client">
    <div class="row">
      <div class="col-md-12">
        <!-- client form -->
        <client-form
          @submit="submit"
          :labelOptions="labels"
          :errors="errors"
        >
        </client-form>
        <!-- /client form -->
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
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
    data() {
      return {
        errors: {},
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
      ...mapActions('client', ['store']),
      async submit (client) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.store(client);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$router.push({ name: 'clients' });
          }
        }
      },
    }
  }
</script>
