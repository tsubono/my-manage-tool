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
  add(state, todo) {
    state.todos.push(todo);
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
  async store({ commit, state }, todo) {
    return await this.$axios.$post('/todos', todo)
      .then((response) => {
        commit('add', response.todo);
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
  async update({ commit, state }, todo) {
    return await this.$axios.$put(`/todos/${todo.id}`, todo)
      .then((response) => {
        const todos = state.todos.map(function(todo, index, array) {
          return (todo.id === response.todo.id) ? response.todo : todo;
        });
        commit('set', todos);
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
    return await this.$axios.$delete(`/todos/${id}`)
      .then((response) => {
        commit('set', state.todos.filter(todo => todo.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
};
