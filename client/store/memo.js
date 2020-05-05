export const state = () => ({
  memos: [],
});

export const getters = {
  memos: state => state.memos,
};

export const mutations = {
  set(state, memos) {
    state.memos = memos;
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/memos')
      .then((response) => {
        commit('set', response.memos);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
