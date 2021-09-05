export default {
 SET_REQUIREMENTS(state, payload) {
  console.log(payload);
   return state.requirements = payload;
 }
}