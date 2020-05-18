export const state = () => ({
  sales: [],
  salesByClient: [],
  statuses: [],
});

export const getters = {
  sales: state => state.sales,
  salesByClient: state => state.salesByClient,
  statuses: state => state.statuses,
};

export const mutations = {
  setSale(state, sales) {
    state.sales = sales;
  },
  setSaleByClient(state, salesByClient) {
    state.salesByClient = salesByClient;
  },
  setStatus(state, statuses) {
    state.statuses = statuses;
  },
  add(state, sale) {
    state.sales.push(sale);
  },
};

export const actions = {
  async fetchByClient({ commit }, { year }) {
    await this.$axios.$get('/sales/client/' + year)
      .then((response) => {
        commit('setSaleByClient', response.sales);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async fetchByYear({ commit }, { year }) {
    await this.$axios.$get('/sales/year/' + year)
      .then((response) => {
        commit('setSale', response.sales);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async fetchByMonth({ commit }, { year, month }) {
    await this.$axios.$get('/sales/month/' + year + '/' + month)
      .then((response) => {
        commit('setSale', response.sales);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async fetchStatus({ commit }) {
    await this.$axios.$get('/sales/statuses')
      .then((response) => {
        commit('setStatus', response.statuses);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async store({ commit }, sale) {
    return await this.$axios.$post('/sales', sale)
      .then((response) => {
        commit('add', response.sale);
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
  async update({ commit, state }, sale) {
    return await this.$axios.$put(`/sales/${sale.id}`, sale)
      .then((response) => {
        const sales = state.sales.map(function(sale, index, array) {
          return (sale.id === response.sale.id) ? response.sale : sale;
        });
        commit('setSale', sales);
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
    return await this.$axios.$delete(`/sales/${id}`)
      .then((response) => {
        commit('setSale', state.sales.filter(sale => sale.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
  async updateStatuses({ commit }, { statuses, deletedStatusIds } ) {
    return await this.$axios.$post('/sales/statuses', {
      statuses: statuses,
      deleted_ids: deletedStatusIds,
    }).then((response) => {
      commit('setStatus', response.statuses);
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
};
