import { createStore } from "vuex";
import { actions, getters, mutations, state } from './modules/auth';
import category from './modules/category';
import customer from './modules/customer';
import order from './modules/order';
import product from './modules/product';
import purchaseTeam from './modules/purchaseTeam';
import rootSmgManager from "./modules/rootSmgManager";
import smgmanager from './modules/smgmanager';
import unit from './modules/unit';


const store = createStore({
    state,
    getters,
    mutations,
    actions,
    modules: {
        category,
        product,
        customer,
        order,
        smgmanager,
        purchaseTeam,
        unit,
        rootSmgManager
    }
});

export default store;
