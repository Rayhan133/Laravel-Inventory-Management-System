<template>
  <Toast position="top-right" />
  <div class="container mx-auto" style="width: 90%">
    <div class="card card-primary">
      <div class="pt-3">
        <h4 class="text-center">
          Order No.<span class="text-info"> &nbsp;{{ data.orderNo }}</span>
        </h4>
        <p class="text-sm text-danger text-center">
          NB. কাস্টমারের নাম অথবা আইডি ব্যবহার করে সার্চ করতে পারবেন । আইডির
          ক্ষেত্রে শুধুমাত্র সংখ্যা (digits) লিখলেই হবে , F_CU লেখার প্রয়োজন
          নেই।
        </p>
      </div>
      <!-- form start -->
      <form @submit.prevent="data.submitForm()" enctype="multipart/form-data">
        <div class="card-body">
          <!-- Selection field will be here -->
          <select-customer></select-customer>
          <!-- End Selection field will be here -->

          <!-- Selected Product will show here -->
          <div v-if="data.addedProducts.length != 0">
            <selected-orders :orders="data.addedProducts"></selected-orders>
          </div>
          <!-- End Selected Product will show here -->

          <!-- Select Product for order -->
          <add-product
            :selectedproduct="SelectedProduct"
            :formcaller="picker"
            :allorder="allOrderedProducts"
          >
          </add-product>
          <!-- End Select Product for order -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex row">
          <div class="d-flex justify-content-start col-md-6">
            <button type="button" class="btn btn-primary" @click="submitData">
              অর্ডার প্রেরন করুন
            </button>
          </div>

          <div class="d-flex justify-content-end col-md-6">
            <a href="#">
              <button type="button" class="btn btn-primary">Cancel</button>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import SelectedOrders from "./sub-components/SelectedOrders";
import SelectCustomer from "./sub-components/SelectCustomer";
import AddProduct from "./sub-components/AddProduct";
import { useStore } from "vuex";
import { computed, reactive } from "vue";
export default {
  components: { SelectCustomer, SelectedOrders, AddProduct, Toast },
  props: {
    orderno: String,
  },
  setup(props) {
    const toast = useToast();
    const store = useStore();
    const data = reactive({
      orderNo: props.orderno,
      addedProducts: [],
      selectedProduct: null,
      customer_id: computed(() => store.state.customer.customerInfo.customerID),
      customerType: computed(
        () => store.state.customer.customerInfo.customerType
      ),
      submitForm: null,
    });

    const submitData = () => {
      if (data.customer_id != "" && data.addedProducts.length != 0) {
        axios
          .post("/api/order/store", {
            customer_id: data.customer_id,
            customer_type: data.customerType,
            order_no: data.orderNo,
            orders: data.addedProducts,
          })
          .then((res) => {
            if (!res.data.status) {
              toast.add({
                severity: "error",
                summary: "Backend Error",
                detail: "Something wents wrong!",
                life: 3000,
              });
              return (data.errors = res.data.data);
            } else {
              toast.add({
                severity: "success",
                summary: "Order Success",
                detail: "Order is successfully created",
                life: 3000,
              });

              return (window.location.href = "/sales");
            }
          });
      }
    };

    const SelectedProduct = (product) => {
      data.selectedProduct = product;
    };

    const allOrderedProducts = (products) => {
      data.addedProducts = products;
    };

    const picker = (childFucntion) => {
      return (data.submitForm = childFucntion);
    };

    return {
      data,
      submitData,
      SelectedProduct,
      picker,
      allOrderedProducts,
    };
  },
};
</script>

<style></style>
