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
        console.log(error);
      });
    await this.$axios.$get('/projects/statuses')
      .then((response) => {
        commit('setStatus', response);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
