<template>
  <div class="w-50 mx-auto">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Add New Category</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="POST" @submit.prevent="submit()">
        <div class="card-body">
          <div class="alert alert-danger" v-if="hasError">
            <ul class="nav" v-for="(error, i) in errors" :key="i">
              <li>{{ error[0] }}</li>
            </ul>
          </div>
          <div class="form-group">
            <label for="name">Category Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Name"
              v-model="name"
            />
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      errors: [],
      hasError: false,
    };
  },
  methods: {
    submit() {
      axios.post("/api/category/store", { name: this.name }).then((res) => {
        if (res.data.status) {
          this.name = "";
          return (window.location.href = "/category");
        } else {
          this.hasError = true;
          return (this.errors = res.data.data);
        }
      });
    },
  },
};
</script>

<style>
</style>
