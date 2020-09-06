<template>
  <div id="subcontractor">
    <div class="row">
      <div class="col-md-12">
        <!-- subcontractor form -->
        <subcontractor-form
          @submit="submit"
          :labelOptions="labels"
          :errors="errors"
        >
        </subcontractor-form>
        <!-- /subcontractor form -->
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import cloneDeep from 'lodash.clonedeep'
  import subcontractorForm from '~/components/subcontractor/Form.vue'

  export default {
    layout: 'default',
    components: {
      subcontractorForm
    },
    head() {
      return {
        title: '外注先情報登録',
      }
    },
    data() {
      return {
        errors: [],
      }
    },
    async fetch ({ store }) {
      await store.dispatch('label/fetch');
    },
    computed: {
      ...mapState('label', ['subcontractorLabels']),
      labels() {
        return cloneDeep(this.subcontractorLabels);
      },
    },
    methods: {
      ...mapActions('subcontractor', ['store']),
      async submit (subcontractor) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.store(subcontractor);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$router.push({ name: 'subcontractors' });
          }
        }
      },
    }
  }
</script>
