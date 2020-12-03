const state = {
    data: [{message: 'Storage 100%', status: 'OK'}],
};

const getters = {
    data: state => state.data
};

const actions = {
    fetchData({ commit },someValue) {
        //axios calls
        commit('setData',someValue)
    },

};

const mutations = {
    setData(state, value) {
        state.data = value;
    },

};

export default {
    state,
    getters,
    actions,
    mutations
};
