<template>
  <span class="right badge badge-danger">
    {{ orders.length }}
  </span>
</template>

<script>
import { ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { computed, onMounted } from "@vue/runtime-core";
export default {
  setup() {
    const store = useStore();
    const orders = ref(computed(() => store.state.smgmanager.pendingOrders));

    onMounted(() => {
      store.dispatch("GET_PENDING_ORDER_NOTIFICATIONS");
    });

    return {
      orders,
    };
  },
};
</script>

<style>
</style>
