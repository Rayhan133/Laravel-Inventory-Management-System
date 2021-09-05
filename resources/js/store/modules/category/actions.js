export default {
     GET_CATEGORIES({commit}){
        axios.get('/api/category/fetch').then(res => {
            if (res.data.status) {
                commit('SET_CATEGORIES', res.data.data);
            }
        })
    }
}
