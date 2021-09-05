require("./bootstrap");

import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import { createApp } from "vue";
import CategoryCreate from "./components/Category/CategoryCreate";
import CategoryIndex from "./components/Category/CategoryIndex";
import OrderCreate from "./components/order/OrderCreate";
import OrderDetails from "./components/order/OrderDetails";
import ProductCreate from "./components/Product/ProductCreate";
import ProductEdit from "./components/Product/ProductEdit";
import EditableTableForPurchaseTeam from "./components/PurchaseTeam/EditableTableForPurchaseTeam";
import PurchaseTeamPendingOrder from "./components/PurchaseTeam/PurchaseTeamPendingOrder";
import RequirementForZoneBaseTable from "./components/RootSmgManager/RequirementForZoneBaseTable";
import RequirementListForPurchaseTeam from "./components/RootSmgManager/RequirementListForPurchaseTeam";
import TodaysTotalOrderOfRootSMG from "./components/RootSmgManager/TodaysTotalOrderOfRootSMG";
import IncommingOrder from "./components/SmgManager/IncommingOrder";
import OrderViewTableForSmg from "./components/SmgManager/OrderViewTableForSmg";
//import { createRouter, createWebHistory } from 'vue-router';
//import routes from './routes';
import store from "./store/index";

/* const router = createRouter({
    history: createWebHistory(),
    routes
}) */

const app = createApp({});
app.component("categoryindex", CategoryIndex);
app.component("categorycreate", CategoryCreate);
app.component("productcreate", ProductCreate);
app.component("productedit", ProductEdit);
app.component("ordercreate", OrderCreate);
app.component("orderdetails", OrderDetails);
app.component("incommingorder", IncommingOrder);
app.component("smg-manager-order-view-table", OrderViewTableForSmg);
app.component("purchase-team-pending-order", PurchaseTeamPendingOrder);
app.component("requirement-for-zone-base-table", RequirementForZoneBaseTable);
app.component("root-smg-todays-order", TodaysTotalOrderOfRootSMG);
app.component(
    "requirements-list-for-purchase-team",
    RequirementListForPurchaseTeam
);
app.component(
    "purchase-team-orders-requirements",
    EditableTableForPurchaseTeam
);
app.use(store);
app.use(PrimeVue);
app.use(ToastService);
app.mount(".app");
