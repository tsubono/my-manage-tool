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
};
