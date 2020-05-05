export const state = () => ({
  projectLabels: [],
  clientLabels: [],
});

export const getters = {
  clients: state => state.clients,
};

export const mutations = {
  set(state, data) {
    state.projectLabels = data.projectLabels;
    state.clientLabels = data.clientLabels;
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
