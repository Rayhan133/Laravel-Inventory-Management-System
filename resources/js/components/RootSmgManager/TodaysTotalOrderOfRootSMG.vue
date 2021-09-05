<template>
  <span class="right badge badge-danger">
    {{ requirements }}
  </span>
</template>

<script>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
export default {
  setup() {
    const requirements = ref(0);

    onMounted(() => {
      axios.get("/@my/todays-requirements/total").then((res) => {
        if (res.data.status) {
          requirements.value = res.data.data.todaysOrder;
        }
      });
    });

    return {
      requirements,
    };
  },
};
</script>

<style>
</style>
