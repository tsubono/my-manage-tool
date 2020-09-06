export const state = () => ({
  projectLabels: [],
  clientLabels: [],
  subcontractorLabels: [],
});

export const mutations = {
  set(state, data) {
    state.projectLabels = data.projectLabels;
    state.clientLabels = data.clientLabels;
    state.subcontractorLabels = data.subcontractorLabels;
  },

};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/labels')
      .then((response) => {
        commit('set', response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
