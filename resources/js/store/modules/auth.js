const state = {
    authUser: {},
    users : null,
}

const getters = {
    findRoleOfUser(state) {
        let { roles } = state.authUser;
        return roles;
    }
}

const mutations = {
    SET_AUTH_USER(state,payload) {
        state.authUser = payload;
    },

    SET_ALL_USER(state,payload) {
        state.users = payload;
    }
}

const actions = {
    GET_AUTH_USER({commit}) {
        axios.get('/authenticated-user').then((res) => {
            commit('SET_AUTH_USER',res.data);
        });
    },

    GET_ALL_USER({commit}) {
        axios.get('/all-user').then((res) => {
            commit('SET_ALL_USER',res.data);
        });
    }
}

export { state, mutations, actions, getters };

