<template>
  <div class="row">
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
            <th>Note</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, i) in orderList" :key="i">
            <td>{{ i + 1 }}</td>
            <td>{{ order.product.sku }}</td>
            <td>
              <div>{{ order.product.name }}</div>
            </td>
            <td>
              <div v-if="+editedRow == i">
                <input type="text" v-model="order.variant" />
              </div>
              <div v-else>
                {{ order.variant ? order.variant : "any/যেকোনো" }}
              </div>
            </td>
            <td>
              <div v-if="+editedRow == i">
                <input type="number" v-model="order.quantity" />
              </div>
              <div v-else>{{ order.quantity }}</div>
            </td>
            <td>
              <div v-if="+editedRow == i">
                <select v-model="order.unit_id">
                  <option v-for="(unit, i) in units" :key="i" :value="unit.id">
                    {{ unit.unit }}
                  </option>
                </select>
              </div>
              <div v-else>
                <span v-for="(unit, i) in units" :key="i">
                  {{
                    order.unit_id
                      ? order.unit_id == unit.id
                        ? unit.unit
                        : ""
                      : order.unit.unit
                  }}
                </span>
              </div>
            </td>
            <td>
              <textarea
                :disabled="+editedRow != i"
                cols="8"
                rows="1"
                class="form-control"
                v-model="order.note"
              ></textarea>
            </td>
            <td>
              <span class="btn text-success" v-if="+editedRow == i"
                ><i class="fas fa-check" @click="updateNow(i)"></i
              ></span>

              <span class="btn text-info" v-else
                ><i class="fas fa-pencil-alt" @click="editNow(i)"></i
              ></span>

              <span class="btn text-danger"
                ><i class="fa fa-times" @click="removeRow(i, order.id)"></i
              ></span>
            </td>
          </tr>
          <AddNewItemInOrder
            v-if="isAddNewData"
            :newadded="newAddedData"
            :totalitems="totalItem == null ? orderList.length : totalItem"
          />
        </tbody>
      </table>
      <hr />
      <div class="row justify-content-center">
        <span
          class="text-danger text-center btn"
          @click="removeNewRow"
          v-if="isAddNewData"
        >
          <i class="fa fa-times"></i>
        </span>
        <span class="text-success text-center btn" @click="addNewRow" v-else>
          <i class="fa fa-plus"></i>
        </span>
      </div>
    </div>
    <!-- /.col -->
  </div>
</template>

<script>
import AddNewItemInOrder from "./AddNewItemInOrder";
import AutoComplete from "primevue/autocomplete";
import { computed, onMounted, reactive, ref } from "@vue/runtime-core";
import moment from "moment";
import { useToast } from "primevue/usetoast";
import { useStore } from "vuex";
export default {
  components: { AutoComplete, AddNewItemInOrder },
  props: {
    singleorder: Object,
    takeUpdatedList: Function,
    isenablesendbutton: Function,
  },
  setup(props) {
    const store = useStore();
    const toast = useToast();
    const order = ref(computed(() => props.singleorder));
    const orderList = ref([]);
    const editedRow = ref(-2);
    const addedNameRow = ref(-2);
    const updatedList = ref([]);
    const totalItem = ref(null);
    const isDataUpdate = ref(false);
    const units = ref(computed(() => store.state.unit.units));

    const isAddNewData = ref(false);
    const data = reactive({
      name: "",
      product_id: "",
      sku: "",
    });

    onMounted(() => {
      orderList.value = order.value.order_list.map((list) => list);
      store.dispatch("GET_UNITS");
    });

    const timeShower = (time) => {
      return moment(time).format("L");
    };

    const editNow = (i) => {
      if (addedNameRow.value == i) addedNameRow.value = i;
      if (addedNameRow.value != -2) addedNameRow.value = -2;
      editedRow.value = i;
    };

    const updateNow = (i) => {
      if (orderList.value[i].note != null && orderList.value[i].note != "") {
        updatedList.value = orderList.value.map((order) => {
          return {
            id: order.id,
            product_id: order.product_id,
            variant: order.variant,
            quantity: order.quantity,
            unit_id: order.unit_id,
            note: order.note,
          };
        });
        editedRow.value = -2;
        props.takeUpdatedList(updatedList.value);
        isDataUpdate.value = true;
        isSendButtonWillActive();
      } else {
        toast.add({
          severity: "info",
          summary: "Warning Message",
          detail: `Please Fillup the Note Field`,
          life: 3000,
        });
      }
    };

    const removeRow = (i, id) => {
      orderList.value.splice(i, 1);
      if (id != null) {
        axios.delete(`/order/${id}`).then((res) => {
          if (res.data.status) {
            toast.add({
              severity: "success",
              summary: "Success Message",
              detail: `${res.data.message}`,
              life: 3000,
            });
            isDataUpdate.value = true;
            isSendButtonWillActive();
          }
        });
      }
    };

    const isSendButtonWillActive = () => {
      props.isenablesendbutton(isDataUpdate.value);
    };

    const addNewRow = () => {
      isAddNewData.value = true;
    };

    const removeNewRow = () => {
      isAddNewData.value = false;
    };

    const newAddedData = (newData) => {
      orderList.value.push({
        id: null,
        product: { name: newData.name, sku: newData.sku },
        product_id: newData.product_id,
        variant: newData.variant,
        quantity: newData.quantity,
        unit_id: newData.unit_id,
        note: newData.note,
      });

      updateNow(orderList.value.length - 1);
      totalItem.value = updatedList.lenght;
    };

    return {
      data,
      order,
      orderList,
      timeShower,
      editedRow,
      addNewRow,
      editNow,
      removeRow,
      updateNow,
      isAddNewData,
      removeNewRow,
      newAddedData,
      updatedList,
      totalItem,
      units,
    };
  },
};
</script>

<style>
.custom-class {
  background: transparent;
  border: none;
  border-bottom: 1px solid #0be763;
  max-width: 70px;
  min-width: 50px;
}
.custom-class .form-control input:focus {
  outline: 1px solid rgb(221, 223, 228) !important;
}
tr td input {
  background: transparent;
  border: none;
  border-bottom: 1px solid #0be763;
  max-width: 70px;
  min-width: 50px;
}
tr td select {
  background: transparent;
  border: none;
  border-bottom: 1px solid #0be763;
  max-width: 70px;
  min-width: 50px;
}
tr td input:focus {
  outline: 1px solid rgb(221, 223, 228);
}
tr td select:focus {
  outline: 1px solid rgb(221, 223, 228);
}
</style>
