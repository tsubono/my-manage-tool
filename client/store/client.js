export const state = () => ({
  clients: [],
});

export const getters = {
  clients: state => state.clients,
};

export const mutations = {
  set(state, clients) {
    state.clients = clients;
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/clients')
      .then((response) => {
        commit('set', response.clients);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
