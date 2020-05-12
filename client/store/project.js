export const state = () => ({
  projects: [],
  statuses: [],
});

export const getters = {
  projects: state => state.projects,
  statuses: state => state.statuses,
};

export const mutations = {
  setProject(state, projects) {
    state.projects = projects;
  },
  setStatus(state, statuses) {
    state.statuses = statuses;
  },
};

export const actions = {
  async fetch({ commit }) {
    await this.$axios.$get('/projects')
      .then((response) => {
        commit('setProject', response.projects);
      })
      .catch((error) => {
        console.error(error);
        return { isError: true };
      });
    await this.$axios.$get('/projects/statuses')
      .then((response) => {
        commit('setStatus', response);
      })
      .catch((error) => {
        console.error(error);
        return { isError: true };
      });
  },
  async store({ commit }, project) {
    return await this.$axios.$post('/projects', project)
      .then((response) => {
        return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response.status === 422) {
          response.errors = error.response.data;
          response.errorMessage = '入力項目をご確認ください';
        }
        return response;
      });
  },
  async update({ commit }, project) {
    return await this.$axios.$put(`/projects/${project.id}`, project)
      .then((response) => {
        return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response.status === 422) {
          response.errors = error.response.data;
          response.errorMessage = '入力項目をご確認ください';
        }
        return response;
      });
  },
  async destroy({ commit, state }, id) {
    return await this.$axios.$delete(`/projects/${id}`)
      .then((response) => {
        commit('set', state.projects.filter(project => project.id !== id));
        return true;
      })
      .catch((error) => {
        return { isError: true };
      });
  },
  async updateStatuses({ commit }, { statuses, deletedStatusIds } ) {
    return await this.$axios.$post('/projects/statuses', {
      statuses: statuses,
      deleted_ids: deletedStatusIds,
    }).then((response) => {
      commit('setStatus', response.statuses);
      return true;
      })
      .catch((error) => {
        const response = { isError: true };
        if (error.response.status === 422) {
          response.errors = error.response.data;
          response.errorMessage = '入力項目をご確認ください';
        }
        return response;
      });
  },
};
