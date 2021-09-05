import axios from "axios";

export default {
    GET_PRODUCTS({commit}) {
        axios.get('/api/product/fetch').then(res => {
            if (res.data.status) {
                commit('SET_PRODUCTS', res.data.data);
            }
        })
    }
}
