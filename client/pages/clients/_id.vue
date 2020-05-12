<template>
  <div id="client">
    <div class="row">
      <div class="col-md-12">
        <!-- client form -->
        <client-form
          @submit="submit"
          :client="client"
          :labelOptions="labels"
          :errors="errors"
          :errorMessage="errorMessage"
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
      clientForm,
    },
    head() {
      return {
        title: '取引先情報',
      }
    },
    data() {
      return {
        errors: [],
        errorMessage: null,
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
      ...mapActions('client', ['update']),
      async submit (client) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.update(client);
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
