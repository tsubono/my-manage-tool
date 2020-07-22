export const state = () => ({
  projectRecords: [],
});

export const getters = {
  projectRecords: state => state.projectRecords,
};

export const mutations = {
  set(state, projectRecords) {
    state.projectRecords = projectRecords;
  },
  add(state, projectRecord) {
    state.projectRecords.push(projectRecord);
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/project-records')
      .then((response) => {
        commit('set', response.projectRecords);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  async store({ commit }, projectRecord) {
    return await this.$axios.$post('/project-records', projectRecord)
      .then((response) => {
        commit('add', response.projectRecord);
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
  async update({ commit, state }, projectRecord) {
    return await this.$axios.$put(`/project-records/${projectRecord.id}`, projectRecord)
      .then((response) => {
        const projectRecords = state.projectRecords.map(function(projectRecord, index, array) {
          return (projectRecord.id === response.projectRecord.id) ? response.projectRecord : projectRecord;
        });
        commit('set', projectRecords);
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
    return await this.$axios.$delete(`/project-records/${id}`)
      .then((response) => {
        commit('set', state.projectRecords.filter(projectRecord => projectRecord.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
};
