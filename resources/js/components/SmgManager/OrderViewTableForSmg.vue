<template>
  <Toast position="top-right" />
  <div class="card">
    <div class="card-header border-transparent bg-info">
      <h4 class="text-center">Todays Incomming orders</h4>
    </div>
    <!-- /.card-header -->
    <div class="card-body py-3">
      <div class="table-responsive">
        <table class="table m-0 mt-5 table-border" id="myexample">
          <thead>
            <tr class="bg-secondary">
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>Total Product</th>
              <th>Proccessed By</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(order, i) in orders" :key="i">
              <td>
                <a :href="`/order/${order.id}`">{{ order.order_no }}</a>
              </td>
              <td>
                {{ order.customer.name }}
              </td>
              <td>{{ order.order_list.length }}</td>
              <td>
                {{ order.sales_executive.name }}
              </td>
              <td>
                <span
                  :class="
                    order.status == 'pending'
                      ? `badge badge-danger`
                      : order.status == 'edit-request'
                      ? `badge badge-warning`
                      : order.status == 'editable'
                      ? `badge badge-danger`
                      : order.status == 'request-denied'
                      ? `badge badge-warning`
                      : order.status == 'edited'
                      ? `badge badge-info`
                      : `badge badge-success`
                  "
                >
                  {{ order.status == "editable" ? "editing..." : order.status }}
                </span>
              </td>
              <td>
                <!-- eye icon for view details -->
                <a :href="`/order/${order.id}`" class="btn text-info">
                  <i class="fas fa-eye"></i>
                </a>
                <!-- warning icon -->
                <span
                  v-if="order.status == 'edit-request'"
                  @click="orderEditPermission(order.id, i)"
                  class="btn text-warning btn-sm"
                >
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
                <!-- Ban Icon -->
                <span
                  class="text-danger"
                  v-if="order.status == 'editable'"
                  :title="`${order.sales_executive.name} is now editing...`"
                >
                  <i class="fas fa-ban"></i>
                  <!--  Ban Icon  -->
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
  </div>
</template>

<script>
import Toast from "primevue/toast";
import { onMounted, ref } from "@vue/runtime-core";
import { useToast } from "primevue/usetoast";
export default {
  components: { Toast },
  setup() {
    const orders = ref([]);
    const toast = useToast();
    onMounted(() => {
      axios.get("/my/incomming-order/fetch").then((res) => {
        if (res.data.status) {
          orders.value = res.data.data;
        }
      });
    });

    const orderEditPermission = (id, index) => {
      axios
        .post(`/my/incomming-order/${id}/status-update`, {
          status: "editable",
        })
        .then((res) => {
          if (res.data.status) {
            orders.value[index].status = res.data.data;
            toast.add({
              severity: "success",
              summary: "Edited Permission!",
              detail: "Thanks For the Permission!",
              life: 3000,
            });
          }
        });
    };
    return {
      orders,
      orderEditPermission,
    };
  },
};
</script>

<style>
</style>
