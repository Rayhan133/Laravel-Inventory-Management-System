<template>
  <div class="form-row mt-4 justify-content-between">
    <div class="form-group col-3">
      <label for="name">Product Name</label>
      <div>
        <AutoComplete
          :forceSelection="true"
          :completeOnFocus="true"
          inputClass="form-control"
          v-model="data.selectedProduct"
          :suggestions="data.filteredProduct"
          @complete="searchProduct($event)"
          field="name"
          @item-select="catchSelectedProduct($event)"
        />
      </div>
    </div>
    <div class="form-group col-3">
      <label for="name">Product Variants</label>
      <input
        class="form-control"
        v-model="data.orderedProducts.variant"
        :required="data.hasVariant"
        list="variantList"
      />
      <datalist id="variantList">
        <option
          v-for="(size, i) in data.selectedProduct.sizes"
          :key="i"
          :value="size"
        >
          {{ size }}
        </option>
      </datalist>
    </div>
    <div class="form-group col-3">
      <label for="name">Product Quantity</label>
      <div class="d-flex">
        <div class="p-inputgroup">
          <input
            required
            class="form-control"
            placeholder="product quantity"
            type="number"
            v-model.number="data.orderedProducts.quantity"
          />
        </div>
      </div>
    </div>
    <div class="col-2">
      <label for="unit_id">Select Unit</label>
      <select
        required
        id="unit_id"
        v-model="data.orderedProducts.unit_id"
        class="form-control"
      >
        <option
          :value="unit.id"
          v-for="(unit, index) in data.units"
          :key="index"
        >
          {{ unit.unit }}
        </option>
      </select>
    </div>
    <div class="col-1">
      <div class="mt-4">
        <button type="submit" class="text-success btn">
          <i class="fa fa-plus"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import AutoComplete from "primevue/autocomplete";
import { useToast } from "primevue/usetoast";
import { computed, onMounted, reactive } from "vue";
import { useStore } from "vuex";
export default {
  props: {
    selectedproduct: Function,
    formcaller: Function,
    allorder: Function,
  },
  components: { AutoComplete },
  setup(props) {
    const toast = useToast();
    const store = useStore();
    const data = reactive({
      products: computed(() => store.state.product.products),
      hasVariant: false,
      filteredProduct: null,
      addedProducts: [],
      units: computed(() => store.state.unit.units),
      selectedProduct: "",
      orderedProducts: {
        product_id: "",
        variant: "",
        quantity: "",
        unit_id: "",
      },
    });

    onMounted(() => {
      store.dispatch("GET_PRODUCTS");
      store.dispatch("GET_UNITS");
      props.formcaller(pickFormData);
    });

    const catchSelectedProduct = (event) => {
      data.orderedProducts.unit_id = event.value.unit_id;
      props.selectedproduct(event.value, data.orderedList);
    };

    const pickFormData = () => {
      let hasVariant = data.selectedProduct.sizes.length;
      data.addedProducts.map((product) => {
        if (!hasVariant) {
          if (product.product_id == data.selectedProduct.id) {
            data.orderedProducts.quantity = "";
            data.orderedProducts.variant = "";
            data.orderedProducts.unit_id = "";
            data.selectedProduct = "";
            toast.add({
              severity: "warn",
              summary: "Error Message",
              detail: "Already added this product",
              life: 3000,
            });
          }
        } else if (
          product.product_id == data.selectedProduct.id &&
          product.variant == data.orderedProducts.variant
        ) {
          data.orderedProducts.quantity = "";
          data.orderedProducts.variant = "";
          data.orderedProducts.unit_id = "";
          data.selectedProduct = "";
          toast.add({
            severity: "warn",
            summary: "Error Message",
            detail: "Already added this product",
            life: 3000,
          });
        }

        if (!hasVariant) {
          data.hasVariant = true;
        }
      });
      orderedProduct();
    };

    const orderedProduct = () => {
      if (data.orderedProducts.quantity != "") {
        data.addedProducts.push({
          product_id: data.selectedProduct.id,
          name: data.selectedProduct.name,
          variant: data.orderedProducts.variant,
          quantity: data.orderedProducts.quantity,
          unit_id: data.orderedProducts.unit_id,
        });
        data.selectedProduct = "";
        data.orderedProducts.quantity = "";
        data.orderedProducts.variant = "";
        data.orderedProducts.unit_id = "";
        toast.add({
          severity: "success",
          summary: "Success Message",
          detail: "New product is added",
          life: 3000,
        });
      }
      props.allorder(data.addedProducts);
    };

    const searchProduct = (event) => {
      data.filteredProduct = data.products.filter((product) => {
        return product.name.toLowerCase().startsWith(event.query.toLowerCase());
      });
    };

    return { data, searchProduct, catchSelectedProduct, pickFormData };
  },
};
</script>

<style>
</style>
