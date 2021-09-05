import axios from "axios";

export default {
    GET_ORDERS({commit}) {
        axios.get('/api/order/fetch').then(res => {
            if (res.data.status) {
                return commit("SET_ORDERS", res.data.data);
            }
        })
    }
}
