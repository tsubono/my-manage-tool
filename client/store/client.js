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
    const config = {
      headers: {
        'content-type': 'multipart/form-data'
      }
    };
    const formData = new FormData();
    Object.keys(client).forEach(key => formData.append(key, client[key]));

    return await this.$axios.$post('/clients', formData, config)
      .then((response) => {
        return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response.status === 422) {
          response.errors = error.response.data;
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
        if (error.response.status === 422) {
          response.errors = error.response.data;
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
