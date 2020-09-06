<template>
  <div id="subcontractor">
    <div class="row">
      <div class="col-md-12">
        <!-- subcontractor form -->
        <subcontractor-form
          @submit="submit"
          :subcontractor="subcontractor"
          :labelOptions="labels"
          :errors="errors"
          :errorMessage="errorMessage"
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
      subcontractorForm,
    },
    head() {
      return {
        title: '外注先情報',
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
        store.dispatch('subcontractor/fetch'),
        store.dispatch('label/fetch'),
      ]);
    },
    computed: {
      ...mapState('subcontractor', ['subcontractors']),
      ...mapState('label', ['subcontractorLabels']),
      subcontractor() {
        return cloneDeep(this.subcontractors.find(data => data.id == this.$route.params.id));
      },
      labels() {
        return cloneDeep(this.subcontractorLabels);
      },
    },
    methods: {
      ...mapActions('subcontractor', ['update']),
      async submit (subcontractor) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.update(subcontractor);
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
