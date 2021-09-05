<template>
  <Toast position="top-right" />
  <div class="row">
    <div class="col-12">
      <div class="callout callout-info bg-info">
        <h5><i class="fas fa-info"></i> Note:</h5>
        This page has been enhanced for printing. Click the print button at the
        bottom of the invoice to test.
      </div>
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4 class="text-success">
              <i class="fas fa-globe"></i> Fashol.com Ltd
              <small class="float-right"
                >Date: {{ timeShower(order.created_at) }}</small
              >
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <hr />
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <div class="text-info">Collected By ,</div>
            <address>
              <strong>{{ order.sales_executive.name }}.</strong><br />
              Zone : {{ order.sales_executive.zone.name }} <br />
              {{ order.sales_executive.address_line_1 }}<br />
              Phone: {{ order.sales_executive.phone }}<br />
              Email: {{ order.sales_executive.email }}
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <div class="text-info">Ordered By ,</div>
            <address>
              <strong
                >{{ order.customer.name }}
                <span class="text-success"
                  >({{ order.customer_type }})</span
                ></strong
              ><br />
              Zone : {{ order.customer.zone.name }} <br />
              {{ order.customer.address_line_1 }}<br />
              Phone: {{ order.customer.phone }}<br />
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b
              >Order NO.
              <span class="text-danger">{{ order.order_no }}</span></b
            ><br />
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr />
        <!-- Data editable table -->
        <EditableTableForSaler
          v-if="isEditableTableShow"
          :singleorder="order"
          :takeUpdatedList="catchUpdateList"
          :isenablesendbutton="isDataRemoved"
        />
        <!-- End Data editable table -->
        <!--Data showing Table row -->
        <div class="row" v-else>
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr class="bg-info">
                  <th>#Sl</th>
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Variant</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(order, i) in order.order_list" :key="i">
                  <td>{{ i + 1 }}</td>
                  <td>{{ order.product.sku }}</td>
                  <td>{{ order.product.name }}</td>
                  <td>{{ order.variant ? order.variant : "any/যেকোনো" }}</td>
                  <td>{{ order.quantity }}</td>
                  <td>{{ order.unit.unit }}</td>
                </tr>
              </tbody>
            </table>
            <hr />
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <button
              v-if="isSendNowButtonActive"
              @click="sendToSmgManager"
              type="button"
              class="btn btn-info float-right"
              style="margin-right: 5px"
              :disabled="!isSendNowButtonActive"
            >
              জমা দিন
              <span class="fa fa-arrow-right"></span>
            </button>
            <button
              v-if="isEditRequestButtonActive"
              @click="sendEditRequest"
              type="button"
              class="btn btn-info float-right"
              style="margin-right: 5px"
              :disabled="isEditRequestButtonDisabled"
            >
              Edit Now
              <span class="fa fa-arrow-right"></span>
            </button>
            <button
              v-if="isOrderConfirmedButtonActive"
              @click="confirmTheOrder"
              type="button"
              class="btn btn-success float-right text-sm"
              style="margin-right: 5px"
              :disabled="isConfirmedButtonDisabled"
            >
              Confirmed & Send
              <i class="fa fa-arrow-right"></i>
            </button>
            <button
              v-if="acceptEditRequestButton"
              @click="editRequestAccept(order.id)"
              type="button"
              class="btn btn-success float-right"
              style="margin-right: 5px"
            >
              Request Accepted
            </button>
            <button
              v-if="acceptEditRequestButton"
              @click="editRequestDenied(order.id)"
              type="button"
              class="btn btn-danger float-right"
              style="margin-right: 5px"
            >
              Request Denied
            </button>
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div>
    <!-- /.col -->
  </div>
</template>

<script>
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import EditableTableForSaler from "./sub-components/EditableTableForSaler";
import { computed, onMounted, onUpdated, ref } from "@vue/runtime-core";
import moment from "moment";
export default {
  components: { EditableTableForSaler, Toast },
  props: {
    singleorder: Object,
  },
  setup(props) {
    const toast = useToast();
    const order = ref(computed(() => props.singleorder));
    const auth = ref({});
    const role = ref(null);
    const updatedOrderList = ref([]);
    const isEditRequestButtonActive = ref(false);
    const isSendNowButtonActive = ref(false);
    const isOrderConfirmedButtonActive = ref(false);
    const isEditableTableShow = ref(false);
    const isConfirmedButtonDisabled = ref(false);
    const isEditRequestButtonDisabled = ref(false);
    const acceptEditRequestButton = ref(false);

    onMounted(() => {
      if (updatedOrderList.value.length != 0) {
        isSendNowButtonActive.value = true;
      }
      authenticatedUser();
    });

    onUpdated(() => {
      if (updatedOrderList.value.length != 0)
        isSendNowButtonActive.value = true;
    });

    const authenticatedUser = () => {
      axios
        .get("/authenticated-user")
        .then((res) => {
          if (res.data.status) {
            auth.value = res.data.data;
            let { roles } = auth.value;
            role.value = roles[0];
            buttonShowOrHide();
          }
        })
        .catch((err) => {
          console.log("You are not logged In");
        });
    };

    const timeShower = (time) => {
      return moment(time).format("L");
    };

    const catchUpdateList = (list) => {
      updatedOrderList.value = list;
    };

    const buttonShowOrHide = () => {
      switch (role.value.name) {
        case "smg_manager":
          isEditableTableShow.value = false;
          isEditRequestButtonActive.value = false;
          isSendNowButtonActive.value = false;
          smgManagerButtonActivity();
          break;
        case "admin":
          isOrderConfirmedButtonActive.value = true;
          isEditRequestButtonActive.value = false;
          isSendNowButtonActive.value = false;
          break;
        case "super_admin":
          isOrderConfirmedButtonActive.value = true;
          isEditRequestButtonActive.value = false;
          isSendNowButtonActive.value = false;
          break;
        case "purchases_team":
          isOrderConfirmedButtonActive.value = true;
          isEditRequestButtonActive.value = false;
          isSendNowButtonActive.value = false;
          break;
        case "sales_executive":
          isOrderConfirmedButtonActive.value = false;
          salesExecutiveButton();
      }
    };

    const smgManagerButtonActivity = () => {
      switch (order.value.status) {
        case "pending":
          isOrderConfirmedButtonActive.value = true;
          isConfirmedButtonDisabled.value = false;
          break;
        case "confirmed":
          isOrderConfirmedButtonActive.value = true;
          isConfirmedButtonDisabled.value = true;
          break;
        case "edit-request":
          isOrderConfirmedButtonActive.value = false;
          isConfirmedButtonDisabled.value = false;
          acceptEditRequestButton.value = true;
          break;
        case "editable":
          isOrderConfirmedButtonActive.value = true;
          isConfirmedButtonDisabled.value = true;
          break;
        case "edited":
          isOrderConfirmedButtonActive.value = true;
          isConfirmedButtonDisabled.value = false;
          break;
        case "request-denied":
          isOrderConfirmedButtonActive.value = true;
          isConfirmedButtonDisabled.value = false;
          break;
      }
    };

    const salesExecutiveButton = () => {
      switch (order.value.status) {
        case "pending":
          isEditRequestButtonActive.value = true;
          isSendNowButtonActive.value = false;
          isEditableTableShow.value = false;
          break;
        case "confirmed":
          isEditRequestButtonActive.value = true;
          isSendNowButtonActive.value = false;
          isEditableTableShow.value = false;
          break;
        case "edit-request":
          isSendNowButtonActive.value = false;
          isEditableTableShow.value = false;
          isEditRequestButtonActive.value = true;
          isEditRequestButtonDisabled.value = true;
          break;
        case "editable":
          isEditRequestButtonActive.value = false;
          isSendNowButtonActive.value = true;
          isEditableTableShow.value = true;
          break;
        case "edited":
          isEditRequestButtonActive.value = true;
          isSendNowButtonActive.value = false;
          isEditableTableShow.value = false;
          break;
        case "request-denied":
          isEditRequestButtonActive.value = true;
          isEditRequestButtonDisabled.value = true;
          isSendNowButtonActive.value = false;
          isEditableTableShow.value = false;
          break;
      }
    };

    const sendEditRequest = () => {
      axios
        .post(`/order/${order.value.id}/status/update`, {
          status: "editable",
        })
        .then((res) => {
          if (res.data.status) {
            isEditRequestButtonDisabled.value = true;
            toast.add({
              severity: "success",
              summary: "Success Message",
              detail: "You have successfully send the edit request!",
              life: 3000,
            });
            window.location.href = "/sales";
          }
        });
    };

    const sendToSmgManager = () => {
      axios
        .post(`/api/order/${order.value.id}/update`, {
          orders: updatedOrderList.value,
        })
        .then((res) => {
          if (res.data.status) {
            toast.add({
              severity: "success",
              summary: "Success Message",
              detail: "Your information is successfully updated!",
              life: 3000,
            });
            window.location.href = `/order/${order.value.id}`;
            isEditRequestButtonActive.value = true;
            isSendNowButtonActive.value = false;
            isEditableTableShow.value = false;
          }
        });
    };

    const isDataRemoved = (trueOrFalse) => {
      isSendNowButtonActive.value = trueOrFalse;
    };

    const confirmTheOrder = () => {
      axios
        .post(`/my/incomming-order/${order.value.id}/status-update`, {
          status: "confirmed",
        })
        .then((res) => {
          if (res.data.status) {
            axios
              .post(`/my/orders/send-to-root-smg-manager`, {
                id: [order.value.id],
              })
              .then((res) => {
                if (res.data.status) {
                  window.location.href = "/my/incomming-order";
                }
              });
          }
        });
    };

    const editRequestAccept = (id) => {
      axios
        .post(`/my/incomming-order/${id}/status-update`, {
          status: "editable",
        })
        .then((res) => {
          if (res.data.status) {
            toast.add({
              severity: "success",
              summary: "Request Accepted",
              detail: "You are accept the request!",
              life: 3000,
            });
            window.location.href = `/my/incomming-order`;
          }
        });
    };

    const editRequestDenied = (id) => {
      axios
        .post(`/my/incomming-order/${id}/status-update`, {
          status: "request-denied",
        })
        .then((res) => {
          if (res.data.status) {
            toast.add({
              severity: "error",
              summary: "Request Denied",
              detail: "Sorry! You have denied Edit Request",
              life: 3000,
            });
            window.location.href = `/my/incomming-order`;
          }
        });
    };

    return {
      order,
      timeShower,
      catchUpdateList,
      isEditRequestButtonActive,
      sendEditRequest,
      sendToSmgManager,
      updatedOrderList,
      isDataRemoved,
      isSendNowButtonActive,
      isOrderConfirmedButtonActive,
      confirmTheOrder,
      isEditableTableShow,
      isConfirmedButtonDisabled,
      isEditRequestButtonDisabled,
      acceptEditRequestButton,
      editRequestAccept,
      editRequestDenied,
    };
  },
};
</script>

<style>
</style>
