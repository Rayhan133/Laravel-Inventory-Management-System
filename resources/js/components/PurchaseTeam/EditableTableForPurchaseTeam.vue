<template>
  <Toast position="top-right" />
  <TableForPurchasesOrders v-if="isReadyToReview" />
  <section class="content" v-else>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info bg-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This page has been enhanced for printing. Click the print button at
            the bottom of the invoice to test.
          </div>

          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  Today's Total-Requirements
                  <small class="float-right">Date: 2/10/2014</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- Table row -->
            <div class="row py-2">
              <div class="col-12 table-responsive">
                <table class="table table-striped table-border border">
                  <thead>
                    <tr class="bg-info">
                      <th>Serial #</th>
                      <th>SKU</th>
                      <th>Product</th>
                      <th>Variant</th>
                      <th>Required Qty</th>
                      <th class="w-10">Supplied Qty</th>
                      <th class="w-10">Needed</th>
                      <th>Price (Total)</th>
                      <th>Image</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(req, i) in total" :key="i">
                      <td>{{ i + 1 }}</td>
                      <td>{{ req.product.sku }}</td>
                      <td>{{ req.product.name }}</td>
                      <td>{{ req.variant }}</td>
                      <td>
                        <span class="text-danger"
                          >{{ req.required_qty }} {{ req.unit.unit }}</span
                        >
                      </td>
                      <td @click="clickedField(i)">
                        <input
                          v-if="isField == i"
                          type="text"
                          v-model="req.supplied_qty"
                          class="form-control myinput"
                        />
                        <span v-else class="text-success"
                          >{{ req.supplied_qty }} {{ req.unit.unit }}</span
                        >
                      </td>
                      <td>
                        <span
                          :class="
                            +req.required_qty > +req.supplied_qty
                              ? 'text-danger'
                              : 'text-success'
                          "
                          >{{ +req.required_qty - +req.supplied_qty }}</span
                        >
                      </td>
                      <td class="d-flex">
                        <input
                          v-if="isField == i"
                          v-model="req.total_price"
                          type="text"
                          class="form-control myinput"
                        />
                        <span
                          class="text-success"
                          v-else
                          @click="clickedField(i)"
                          >{{ req.total_price }} BDT</span
                        >
                      </td>
                      <td>
                        <span @click="clickedField(i)">
                          <span
                            class="mx-3 text-primary btn"
                            @click="pickTheImage(i)"
                            ><i class="fa fa-camera"></i>
                          </span>
                        </span>

                        <span
                          v-if="i != isField"
                          @click="clickedField(i)"
                          class="text-info btn"
                          ><i class="fas fa-pencil-alt"></i
                        ></span>

                        <span
                          v-else
                          @click="pickTheChangedData(i)"
                          class="text-success btn"
                          ><i class="fas fa-check"></i
                        ></span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <button
                  @click="readyToPreview"
                  type="button"
                  class="btn btn-info float-right text-sm"
                >
                  Ready!
                </button>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <input
      ref="imageInput"
      type="file"
      class="d-none"
      @change="imageForForm"
      accept="image/*"
    />
    <!-- /.container-fluid -->
  </section>
</template>
<script>
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import TableForPurchasesOrders from "./TableForPurchasesOrders";
export default {
  components: { Toast, TableForPurchasesOrders },
  data() {
    return {
      total: [],
      isField: -2,
      imageIndex: "",
      totalPrice: 0,
      toast: useToast(),
      isReadyToReview: false,
    };
  },
  mounted() {
    axios.get("/my/todays-requirements/get").then((res) => {
      if (res.data.status) {
        this.total = res.data.data;
      }
    });
  },

  methods: {
    clickedField(index) {
      if (this.isField == -2) {
        this.isField = index;
      } else {
        this.toast.add({
          severity: "info",
          summary: "Information!",
          detail: "You need to finished!",
          life: 3000,
        });
      }
    },

    pickTheChangedData(index) {
      let formdata = new FormData();
      formdata.append("id", this.total[index].id);
      formdata.append("product_id", this.total[index].product_id);
      formdata.append("unit_id", this.total[index].unit_id);
      formdata.append("variant", this.total[index].variant);
      formdata.append("required_qty", this.total[index].required_qty);
      formdata.append("supplied_qty", this.total[index].supplied_qty);
      formdata.append("total_price", this.total[index].total_price);
      formdata.append("image", this.total[index].image);

      if (this.total[index].image != null) {
        axios
          .post("/my/todays-requirements/store", formdata)
          .then((res) => {
            if (res.data.status) {
              this.isField = -2;
              this.toast.add({
                severity: "success",
                summary: "Congratulations!",
                detail: "🙂 Thanks for purchase!",
                life: 3000,
              });
            }
          })
          .catch((err) => {
            if (err) {
              this.toast.add({
                severity: "info",
                summary: "Information",
                detail: "😕 You need to upload an image!",
                life: 3000,
              });
            }
          });
      }
    },

    imageForForm(e) {
      let image = e.target.files[0];
      this.total[this.imageIndex].image = image;
    },

    pickTheImage(index) {
      this.$refs.imageInput.click();
      this.imageIndex = index;
    },

    print() {
      window.print();
    },

    readyToPreview() {
      this.isReadyToReview = true;
    },
  },
};
</script>

<style>
.myinput {
  background: transparent;
  border: none;
  border-bottom: 1px solid #0be763;
  max-width: 70px;
  min-width: 50px;
}
.myinput input:focus {
  outline: 1px solid rgb(221, 223, 228);
}
tr td select:focus {
  outline: 1px solid rgb(221, 223, 228);
}
</style>