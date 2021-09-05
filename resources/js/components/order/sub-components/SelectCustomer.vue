<template>
  <div class="form-group">
    <div class="form-row">
      <div class="col-4">
        <label for="name">Customer Name</label>
        <AutoComplete
          required
          ref="customerInput"
          :forceSelection="true"
          :completeOnFocus="true"
          inputClass="form-control"
          v-model="selectedCustomer"
          :suggestions="data.filteredCustomer"
          @complete="searchCustomer($event)"
          field="name"
          @item-select="collectData($event)"
        />
      </div>
      <div class="col-8">
        <label class="ml-3"> Customer Type : </label>
        <div class="form-group d-flex">
          <div
            class="custom-control custom-radio mr-3 ml-5"
            :class="!isNewCustomer ? 'text-mute' : ''"
          >
            <input
              class="custom-control-input"
              type="radio"
              id="customRadio1"
              name="customRadio"
              value="New-customer"
              v-model="customerType"
              :disabled="!isNewCustomer"
              :checked="isNewCustomer"
            />
            <label for="customRadio1" class="custom-control-label"
              >New customer</label
            >
          </div>
          <div class="custom-control custom-radio mr-3">
            <input
              class="custom-control-input"
              type="radio"
              id="customRadio2"
              name="customRadio"
              value="Loyal-customer"
              v-model="customerType"
              :disabled="!isLoyalCustomer"
              :checked="isLoyalCustomer"
            />
            <label
              for="customRadio2"
              class="custom-control-label"
              :class="!isLoyalCustomer ? 'text-mute' : ''"
              >Loyal Customer</label
            >
          </div>
          <div class="custom-control custom-radio">
            <input
              class="custom-control-input"
              type="radio"
              id="normal"
              name="customRadio"
              value="Normal-customer"
              v-model="customerType"
              :disabled="!isNormalCustomer"
              :checked="isNormalCustomerChecked"
            />
            <label
              for="normal"
              :class="!isNormalCustomer ? 'text-mute' : ''"
              class="custom-control-label"
              >Normal</label
            >
          </div>
        </div>
      </div>
    </div>
    <hr />
    <div>
      <div class="border p-5 bg-info" v-if="selectedCustomer">
        <div class="row">
          <div class="col-6">
            <p><strong>Name : </strong>{{ selectedCustomer.name }}</p>
            <p><strong>Phone : </strong>{{ selectedCustomer.phone }}</p>
            <p><strong>Zone : </strong>{{ pickZone(selectedCustomer) }}</p>
            <p>
              <strong>Address : </strong>{{ selectedCustomer.address_line_1 }}
            </p>
          </div>
          <div class="col-6">
            <h3>Customer ID #: {{ selectedCustomer.unique_id }}</h3>
            <h4 class="py-3 text-danger">Customer Type : {{ customerType }}</h4>
          </div>
        </div>
      </div>
      <div class="border p-5 text-center bg-info" v-else>No data found</div>
      <hr />
    </div>
  </div>
</template>

<script>
import AutoComplete from "primevue/autocomplete";
import { reactive, computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import moment from "moment";

export default {
  components: { AutoComplete },
  mounted() {
    this.$refs.customerInput.focus();
  },
  setup() {
    const store = useStore();
    const selectedCustomer = ref(null);
    const customerType = ref("");
    const isNewCustomer = ref(false);
    const isLoyalCustomer = ref(false);
    const isNormalCustomer = ref(false);
    const isNormalCustomerChecked = ref(false);
    const orders = ref(computed(() => store.state.order.orders));
    const data = reactive({
      customers: computed(() => store.state.customer.customers),
      filteredCustomer: null,
      zone: { name: "" },
    });
    onMounted(() => {
      store.dispatch("GET_CUSTOMERS");
      store.dispatch("GET_ORDERS");
    });

    const collectData = (event) => {
      checkCustomerStatus(event.value);
    };

    const searchCustomer = (event) => {
      data.filteredCustomer = data.customers.filter((customer) => {
        if (!+event.query) {
          return customer.name
            .toLowerCase()
            .startsWith(event.query.toLowerCase());
        } else {
          return customer.unique_id.startsWith("F_CU" + event.query);
        }
      });
    };

    const pickZone = (customer) => {
      store.commit("SET_CUSTOMER_INFO", {
        customerID: customer.id,
        customerType: customerType.value,
      });
      const { name } = customer.zone ? customer.zone : data.zone;
      data.zone.name = name;
      return name;
    };

    const checkCustomerStatus = (customer) => {
      let customerOrders = orders.value.filter((order) => {
        return customer.id == order.customer_id;
      });

      let orderDates = customerOrders.map((order) => order.created_at);

      let orderDays = orderDates.map((day) => {
        let orderedDay = new Date(moment(day).format("L"));
        let today = new Date(moment().format("L"));
        return Math.ceil((today - orderedDay) / (1000 * 60 * 60 * 24));
      });

      let totalOrderIn30Days = orderDays.filter((day) => +day <= 30);
      let totalOrderOut30Days = orderDays.filter((day) => +day > 30);

      /* console.log(
        "ak dine koto gulo order korce segulo soho total 30 diner order list [" +
          totalOrderIn30Days +
          "]"
      ); */

      /* console.log(
        totalOrderIn30Days.length +
          " ta order 30 dine korce.akdine akadhik order shoho"
      ); */

      let specificDaysOrder = [...new Set(totalOrderIn30Days)];

      let specificDaysOrderOutOf30 = [...new Set(totalOrderOut30Days)];

      /* console.log(
        "aj theke joto din age order korce segulo holo [" +
          specificDaysOrder +
          "]"
      ); */

      //console.log("total " + specificDaysOrder.length + " din order korce");

      if (
        +specificDaysOrder.length <= 2 &&
        +specificDaysOrderOutOf30.length == 0
      ) {
        isNewCustomer.value = true;
        isLoyalCustomer.value = false;
        isNormalCustomer.value = false;
        customerType.value = "New-Customer";
      } else if (
        +specificDaysOrder.length > 2 &&
        +specificDaysOrder.length <= 10 &&
        +specificDaysOrderOutOf30.length == 0
      ) {
        isNewCustomer.value = false;
        isLoyalCustomer.value = true;
        customerType.value = "Loyal-Customer";
        isNormalCustomer.value = true;
      } else {
        isNewCustomer.value = false;
        isLoyalCustomer.value = false;
        isNormalCustomer.value = true;
        isNormalCustomerChecked.value = true;
        customerType.value = "Normal-Customer";
      }
    };

    return {
      data,
      collectData,
      searchCustomer,
      pickZone,
      selectedCustomer,
      customerType,
      orders,
      isNewCustomer,
      isNormalCustomer,
      isLoyalCustomer,
      isNormalCustomerChecked,
    };
  },
};
</script>

<style>
</style>
