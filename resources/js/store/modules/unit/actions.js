export default{
    GET_UNITS({commit}){
        axios.get('/units').then(res => {
            if (res.data.status) {
                commit('SET_UNITS', res.data.data);
            }
        })
    }
}
