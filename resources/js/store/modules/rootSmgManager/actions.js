import axios from "axios";

export default {
 GET_REQUIREMENTS({commit} ) {
  axios.get("/@my/todays-requirements/fetch").then((res) => {
      if (res.data.status) {
          commit("SET_REQUIREMENTS", res.data.data);
      }
  });
 }
}