<template>
  <div class="row">
    <div class="col-12">
      <div class="callout callout-info bg-info">
        <h5><i class="fas fa-info"></i> Note:</h5>
        This page has been enhanced for printing. Click the print button at the
        bottom of the invoice to test.
      </div>
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4 class="text-success">
              <i class="fas fa-globe"></i> Fashol.com Ltd
              <small class="float-right">Date: 1 agust , 2021</small>
            </h4>
          </div>
          <!-- /.col -->
        </div>
        <hr />
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <div class="text-info">Order By ,</div>
            <address>
              <strong>Smg-manager-1</strong><br />
              Zone : Mirpur-2
              <br />
              Kaoran bajar , dhanmondi,mirpur-2<br />
              Phone: 3234242344<br />
              Email: reazwan@gmail.com
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <div class="text-info">Ordered By ,</div>
            <address>
              <strong>Rezwan <span class="text-success">(New)</span></strong
              ><br />
              Zone : Payra chattar <br />
              Dimla,Nilphamary,Rangpur<br />
              Phone: 2143245345<br />
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Order NO. <span class="text-danger">OR21232</span></b
            ><br />
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr />
        <!-- Data editable table -->
        <!-- End Data editable table -->
        <!--Data showing Table row -->
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
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>PR_1234</td>
                  <td>Alu</td>
                  <td>choto</td>
                  <td>12</td>
                  <td>kg</td>
                </tr>
              </tbody>
            </table>
            <hr />
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <button
              type="button"
              class="btn btn-info float-right"
              style="margin-right: 5px"
            >
              Send Now
              <span class="fa fa-arrow-right"></span>
            </button>
            <button
              type="button"
              class="btn btn-info float-right"
              style="margin-right: 5px"
            >
              Edit Request
              <span class="fa fa-arrow-right"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div>
    <!-- /.col -->
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
