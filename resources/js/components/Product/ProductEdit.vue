<template>
  <div class="row">
    <div class="w-100 col-8">
      <div class="card card-primary">
        <div class="card-header">
          <h4 class="text-center">Add new Product</h4>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="card-body">
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors" :key="error">
                  {{ error }}
                </li>
              </ul>
            </div>
            <div class="form-row">
              <div class="form-group col-8">
                <label for="name">Product Name</label>
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  id="name"
                  placeholder="Name"
                  v-model="name"
                />
              </div>
              <div class="form-group col-4">
                <label for="category">Product Category</label>
                <select
                  class="form-control"
                  id="category"
                  placeholder="category"
                  v-model="category"
                >
                  <option value="">Select A Category</option>
                  <option
                    :value="category.id"
                    v-for="(category, index) in categories"
                    :key="index"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <!-- <div class="form-group col-4">
                <label for="image">Image upload</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input
                      ref="imageInput"
                      type="file"
                      class="custom-file-input"
                      id="image"
                      @change="imageForForm"
                      accept="image/*"
                    />
                    <label class="custom-file-label" for="image"
                      >Choose file</label
                    >
                  </div>
                </div>
              </div> -->
              <div class="form-group col-6">
                <label for="sku">Select Unit </label>
                <select required v-model="unit_id" class="form-control">
                  <option value="">Select unit</option>
                  <option v-for="(unit, i) in units" :key="i" :value="unit.id">
                    {{ unit.unit }}
                  </option>
                </select>
              </div>
              <div class="form-group col-6">
                <label for="sku">Product SKU</label>
                <input disabled type="text" class="form-control" :value="sku" />
              </div>
              <div class="col-1">
                <div class="btn btn-sm"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-12">
                <div class="form-row">
                  <div class="col-12">
                    <label for="unit_id">Product Size</label>
                    <div class="form-group clearfix">
                      <div
                        v-if="sizes.length == 0"
                        class="text-center text-danger"
                      >
                        Not available
                      </div>
                      <div
                        class="icheck-primary d-inline mx-2"
                        v-for="(item, index) in sizes"
                        :key="index"
                      >
                        <input
                          :value="item"
                          v-model="sizes"
                          type="checkbox"
                          :id="`checkboxPrimary${index}`"
                        />
                        <label :for="`checkboxPrimary${index}`">
                          {{ item }}
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea
                id="description"
                cols="60"
                rows="5"
                class="form-control"
                v-model="description"
              ></textarea>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-4">
      <div class="card card-success">
        <div class="card-header">
          <h4 class="text-center">Product Variant</h4>
        </div>
        <form @submit.prevent="variantPicker()">
          <div class="card-body">
            <div class="form-group">
              <label for="color">Size :</label>
              <div class="form-row">
                <div class="col-9">
                  <input
                    type="text"
                    id="color"
                    class="form-control"
                    v-model="size"
                  />
                </div>
                <div class="col-3">
                  <button
                    type="button"
                    class="btn btn-sm btn-danger"
                    @click="sizes.pop()"
                  >
                    clear
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Add Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  props: { product: Object },
  computed: {
    ...mapState({
      categories: (state) => state.category.categories,
      units: (state) => state.unit.units,
    }),
  },
  data() {
    return {
      errors: null,
      sizes: this.product.sizes,
      imageView: null,
      name: this.product.name,
      image: "",
      category: this.product.category_id,
      sku: this.product.sku,
      description: this.product.description,
      unit_id: this.product.unit_id,
      size: "",
    };
  },

  mounted() {
    this.$store.dispatch("GET_CATEGORIES");
    this.$store.dispatch("GET_UNITS");
  },

  methods: {
    submit() {
      let formdata = new FormData();
      formdata.append("name", this.name);
      formdata.append("image", this.image);
      formdata.append("category", this.category);
      formdata.append("sku", this.sku);
      formdata.append("sizes", this.sizes);
      formdata.append("unit_id", this.unit_id);
      formdata.append("description", this.description);

      axios
        .post(`/api/product/${this.product.id}/update`, formdata)
        .then((res) => {
          if (!res.data.status) {
            this.errors = res.data.data;
          } else {
            window.location.href = "/product";
          }
        });
    },

    imageForForm(e) {
      this.pickImage(e);
      this.image = e.target.files[0];
    },

    pickImage(e) {
      let image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.imageView = e.target.result;
      };
    },

    variantPicker() {
      if (this.size != "") this.sizes.push(this.size.toUpperCase());
      if (this.size != "") this.size = "";
    },
  },
};
</script>

<style>
</style>
