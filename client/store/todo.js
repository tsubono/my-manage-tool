export const state = () => ({
  todos: [],
});

export const getters = {
  todos: state => state.todos,
};

export const mutations = {
  set(state, todos) {
    state.todos = todos;
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/todos')
      .then((response) => {
        commit('set', response.todos);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
