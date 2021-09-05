<template>
  <table class="table">
    <thead class="text-center bg-dark">
      <th>#SL</th>
      <th>Products</th>
      <th>Variants</th>
      <th>Quantity</th>
      <th>Unit</th>
      <th style="width: 30%">Action</th>
    </thead>
    <tbody class="text-center">
      <tr v-for="(product, i) in selectedProducts" :key="i">
        <td>{{ i + 1 }}</td>
        <td>{{ product.name }}</td>
        <td>
          {{ product.variant }}
        </td>
        <td>
          <div v-if="+editField == i" class="inputDesign">
            <input
              type="text"
              class="form-control"
              :id="`click-cell-id-${i}`"
              v-model="product.quantity"
              @blur="updateValue"
            />
          </div>
          <div v-else @click="editItem(i)">
            {{ product.quantity }}
          </div>
        </td>
        <td>
          <div v-if="+editField == i" class="inputDesign">
            <select
              class="form-control"
              :id="`click-cell-id-${i}`"
              v-model="product.unit_id"
              @blur="updateValue"
            >
              <option
                :value="unit.id"
                v-for="(unit, index) in units"
                :key="index"
              >
                {{ unit.unit }}
              </option>
            </select>
          </div>
          <div v-else @click="editItem(i)">
            <span v-for="(unit, i) in units" :key="i">
              {{ product.unit_id == unit.id ? unit.unit : "" }}
            </span>
          </div>
        </td>
        <td>
          <span class="btn text-success" v-if="+savedData == i"
            ><i class="fas fa-check" @click="updateValue()"></i
          ></span>

          <span class="btn text-info" v-else
            ><i class="fas fa-pencil-alt" @click="editItem(i)"></i
          ></span>

          <span class="btn text-danger"
            ><i class="fa fa-times" @click="removeItem(i)"></i
          ></span>
        </td>
      </tr>
    </tbody>
  </table>
  <hr />
</template>

<script>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import { computed, onMounted, reactive, ref } from "vue";
import { useStore } from "vuex";
export default {
  components: { DataTable, Column, InputText },
  props: {
    orders: Array,
  },
  setup(props) {
    const store = useStore();
    const editField = ref(-2);
    const selectedProducts = ref([]);
    const clearTime = ref("");
    const savedData = ref(-2);
    const units = ref(computed(() => store.state.unit.units));
    const data = reactive({
      name: "",
      quantity: "",
      variant: "",
      unit_id: "",
    });
    onMounted(() => {
      selectedProducts.value = props.orders;
      store.dispatch("GET_UNITS");
    });

    const propsValue = computed(() => {
      selectedProducts.value = props.orders;
    });

    const removeItem = (i) => {
      props.orders.splice(i, 1);
    };

    const editItem = (i) => {
      savedData.value = i;
      editField.value = i;
      clearTime.value = setInterval(() => {
        document.getElementById(`click-cell-id-${i}`).focus();
      }, 100);
      clearInterval(clearTime.value);
    };

    const updateValue = () => {
      savedData.value = -2;
      editField.value = -2;
    };

    /* This is for returning data part */
    return {
      data,
      removeItem,
      editItem,
      selectedProducts,
      propsValue,
      editField,
      updateValue,
      savedData,
      units,
    };
  },
};
</script>

<style>
.inputDesign .form-control {
  border: 0;
  border-bottom: 2px solid aqua;
  display: block;
  font-size: 18px;
  font-family: "Muli", sans-serif;
  transition: 0.1s ease-in;
  width: 100px;
}
</style>
