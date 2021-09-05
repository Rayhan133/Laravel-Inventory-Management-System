<template>
  <section class="content">
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
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(req, i) in requirements" :key="i">
                      <td>{{ i + 1 }}</td>
                      <td>{{ req.product.sku }}</td>
                      <td>{{ req.product.name }}</td>
                      <td>{{ req.variant }}</td>
                      <td>
                        <span class="text-danger"
                          >{{ req.required_qty }} {{ req.unit.unit }}</span
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6"></div>
              <!-- /.col -->
              <div class="col-6" v-if="isShowAmountList">
                <p class="lead">Amount</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width: 50%">Buying Cost</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Extra Cost</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a
                  v-if="printButton"
                  href="invoice-print.html"
                  rel="noopener"
                  target="_blank"
                  class="btn btn-default"
                  ><i class="fas fa-print"></i> Print</a
                >
                <button
                  v-if="sendToButton"
                  :disable="isDisableSendButton"
                  type="button"
                  @click="sendToPurchase"
                  class="btn btn-success float-right text-sm"
                >
                  Send To (Purchase Team)
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
    <!-- /.container-fluid -->
  </section>
</template>

<script>
export default {
  data() {
    return {
      requirements: [],
      totalReq: [],
      isShowAmountList: false,
      sendToButton: true,
      printButton: false,
      isDisableSendButton: false,
    };
  },
  mounted() {
    axios.get("/@my/todays-requirements/fetch").then((res) => {
      if (res.data.status) {
        this.proccessData(res.data.data);
      }
    });
  },

  methods: {
    proccessData(result) {
      result.forEach((element) => {
        let req = {
          product_id: element.product_id,
          unit_id: element.unit_id,
          variant: element.variant,
          required_qty: element.required_qty,
          status: "proccessing",
        };
        this.totalReq.push(req);
      });
      this.requirements = result;
    },

    sendToPurchase() {
      axios
        .post("/@my/todays-requirements/store", this.totalReq)
        .then((res) => {
          if (res.data.status) {
            this.isDisableSendButton = true;
          }
        });
    },
  },
};
</script>

<style>
</style>