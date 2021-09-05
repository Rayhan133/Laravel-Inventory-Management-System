import axios from "axios";

export default {
    GET_CUSTOMERS({commit}) {
        axios.get('/api/customer/fetch').then(res => {
            if (res.data.status) {
                commit('SET_CUSTOMERS', res.data.data);
            }
        })
    }
}
