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
              <div class="col-sm-4 invoice-col text-center">
                <h3 class="text-danger mb-3">Zone : {{ zone.name }}</h3>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
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
                      <td>{{ req.sypplied_qty }}</td>
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
                <button type="button" class="btn btn-success float-right">
                  Send To <span class="text-light">({{ zone.name }})</span>
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
  props: {
    requiredzone: Object,
  },
  data() {
    return {
      zone: this.requiredzone,
      requirements: [],
    };
  },
  mounted() {
    this.requirements = this.requiredzone.requirements;
    this.zone = this.requiredzone;
  },
};
</script>

<style>
</style>
