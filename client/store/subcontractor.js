export const state = () => ({
  subcontractors: [],
});

export const getters = {
  subcontractors: state => state.subcontractors,
};

export const mutations = {
  set(state, subcontractors) {
    state.subcontractors = subcontractors;
  },
};

export const actions = {
  async fetch({ commit }, searchForm = {}) {
    await this.$axios.$get('/subcontractors', {
      params: {
        searchForm
      }
    })
      .then((response) => {
        commit('set', response.subcontractors);
      })
      .catch((error) => {
        return { isError: true };
      });
  },
  async store({ commit }, subcontractor) {
    return await this.$axios.$post('/subcontractors', subcontractor)
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
  async update({ commit }, subcontractor) {
    return await this.$axios.$put(`/subcontractors/${subcontractor.id}`, subcontractor)
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
    return await this.$axios.$delete(`/subcontractors/${id}`)
      .then((response) => {
        commit('set', state.subcontractors.filter(subcontractor => subcontractor.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
};
