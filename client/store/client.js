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
        return { isError: true };
      });
  },
  async store({ commit }, client) {
    return await this.$axios.$post('/clients', client)
      .then((response) => {
        return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response !== undefined && error.response.status === 422) {
          response.errors = error.response.data;
          response.errorMessage = '入力項目をご確認ください';
        }
        return response;
      });
  },
  async update({ commit }, client) {
    return await this.$axios.$put(`/clients/${client.id}`, client)
      .then((response) => {
        return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response !== undefined && error.response.status === 422) {
          response.errors = error.response.data;
          response.errorMessage = '入力項目をご確認ください';
        }
        return response;
      });
  },
  async destroy({ commit, state }, id) {
    return await this.$axios.$delete(`/clients/${id}`)
      .then((response) => {
        commit('set', state.clients.filter(client => client.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
};
