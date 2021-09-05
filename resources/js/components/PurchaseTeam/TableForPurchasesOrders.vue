<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This page has been enhanced for printing. Click the print button at
            the bottom of the invoice to test.
          </div>

          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4 class="text-success">
                  <i class="fas fa-globe"></i> Fashol.com LTD.
                  <small class="float-right">Last Update : 1:20 pm</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col"></div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row pt-3">
              <div class="col-12 table-responsive">
                <table class="table table-striped tabale-borderd border">
                  <thead>
                    <tr class="bg-info">
                      <th>#Serial</th>
                      <th>Sku</th>
                      <th>Product</th>
                      <th>Variants</th>
                      <th>Requirements</th>
                      <th>Supplied</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(req, index) in requirements" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ req.product.sku }}</td>
                      <td>{{ req.product.name }}</td>
                      <td>{{ req.variant }}</td>
                      <td class="text-danger">
                        {{ req.required_qty }} {{ req.unit.unit }}.
                      </td>
                      <td class="text-success">
                        {{ req.supplied_qty }} {{ req.unit.unit }}
                      </td>
                      <td>{{ req.total_price }} BDT</td>
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
              <div class="col-6">
                <p class="lead">Amount</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width: 50%">Buying Cost</th>
                        <td>{{ total }} BDT</td>
                      </tr>
                      <tr>
                        <th>Extra Cost</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>0</td>
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
                <button @click="print()" class="btn btn-default float-right">
                  <i class="fas fa-print"></i> Print
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
      total: 0,
    };
  },
  mounted() {
    axios.get("/my/todays-requirements/get").then((res) => {
      if (res.data.status) {
        this.requirements = res.data.data;
        this.total = this.requirements.reduce((accumulator, current) => {
          return +accumulator + +current.total_price;
        }, 0);
      }
    });
  },

  methods: {
    print() {
      window.print();
    },
  },
};
</script>

<style>
</style>
