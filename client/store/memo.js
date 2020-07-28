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
  add(state, memo) {
    state.memos.push(memo);
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/memos')
      .then((response) => {
        commit('set', response.memos);
        console.log('fetched memos');
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async store({ commit }, memo) {
    return await this.$axios.$post('/memos', memo)
      .then((response) => {
        commit('add', response.memo);
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
  async update({ commit, state }, memo) {
    return await this.$axios.$put(`/memos/${memo.id}`, memo)
      .then((response) => {
        const memos = state.memos.map(function(memo, index, array) {
          return (memo.id === response.memo.id) ? response.memo : memo;
        });
        commit('set', memos);
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
    return await this.$axios.$delete(`/memos/${id}`)
      .then((response) => {
        commit('set', state.memos.filter(memo => memo.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
};
