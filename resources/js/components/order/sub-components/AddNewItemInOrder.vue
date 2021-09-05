<template>
  <tr>
    <td>{{ +totalItem + 1 }}</td>
    <td>{{ selectedData.sku }}</td>
    <td>
      <AutoComplete
        :forceSelection="true"
        :completeOnFocus="true"
        inputClass="custom-class"
        v-model="selectedData"
        :suggestions="filteredProduct"
        @complete="searchProduct($event)"
        @item-select="catchSelectedProduct($event)"
        field="name"
      />
    </td>
    <td>
      <input type="text" list="variant" v-model="data.variant" class="" />
      <datalist id="variant">
        <option v-for="(size, i) in selectedData.sizes" :key="i" :value="size">
          {{ size }}
        </option>
      </datalist>
    </td>
    <td><input type="number" v-model="data.quantity" /></td>
    <td>
      <select v-model="data.unit_id" id="unit_id">
        <option :value="unit.id" v-for="(unit, i) in units" :key="i">
          {{ unit.unit }}
        </option>
      </select>
    </td>
    <td>
      <textarea
        cols="8"
        rows="1"
        v-model="data.note"
        class="form-control"
      ></textarea>
    </td>
    <td>
      <button type="button" class="btn text-info" @click="addNow">
        <i class="fas fa-check"></i>
      </button>
    </td>
  </tr>
</template>

<script>
import { useToast } from "primevue/usetoast";
import AutoComplete from "primevue/autocomplete";
import { computed, onMounted, reactive, ref } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
  components: { AutoComplete },
  props: {
    newadded: Function,
    totalitems: Number,
  },
  setup(props) {
    const toast = useToast();
    const store = useStore();
    const products = ref(computed(() => store.state.product.products));
    const filteredProduct = ref([]);
    const selectedData = ref("");
    const totalItem = ref(props.totalitems);
    const units = ref(computed(() => store.state.unit.units));

    const data = reactive({
      name: "",
      sku: "",
      product_id: "",
      variant: "",
      quantity: "",
      unit_id: "",
      note: "",
    });

    onMounted(() => {
      store.dispatch("GET_PRODUCTS");
    });

    const searchProduct = (event) => {
      filteredProduct.value = products.value.filter((product) => {
        return product.name.toLowerCase().startsWith(event.query.toLowerCase());
      });
    };

    const catchSelectedProduct = (event) => {
      data.product_id = event.value.id;
      data.name = event.value.name;
      data.sku = event.value.sku;
    };

    const addNow = () => {
      if (
        data.name != "" &&
        data.product_id != "" &&
        data.variant != "" &&
        data.quantity != "" &&
        data.unit_id != "" &&
        data.note != ""
      ) {
        props.newadded(data);
        data.name = "";
        data.product_id = "";
        data.variant = "";
        data.quantity = "";
        data.unit_id = "";
        data.note = "";
        toast.add({
          severity: "success",
          summary: "Success Message",
          detail: "Data is successfully inserted!",
          life: 3000,
        });
      } else {
        toast.add({
          severity: "error",
          summary: "Error Message",
          detail: "Please fillup the all fields",
          life: 3000,
        });
      }
    };

    return {
      data,
      catchSelectedProduct,
      filteredProduct,
      searchProduct,
      selectedData,
      addNow,
      totalItem,
      units,
    };
  },
};
</script>

<style>
</style>
