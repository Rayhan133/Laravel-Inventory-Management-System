<template>
  <div class="">
    <div class="">
      <a href="/category/create" class="btn btn-success float-right mb-2 mr-5">
        Add New <i class="fa fa-plus"></i>
      </a>
    </div>
    <table id="dataTable" class="table table-bordered table-hover">
      <thead>
        <tr class="bg-info">
          <th>#SL</th>
          <th>Category</th>
          <th>Added By</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, index) in categories" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ category.name }}</td>
          <td>{{ category.smg_menager.name.toUpperCase() }}</td>
          <td>
            <div>
              <a
                :href="`/category/${category.id}/edit`"
                class="btn btn-sm btn-success mx-1"
                ><i class="fa fa-edit"></i
              ></a>

              <button
                @click="deleteButton(`${category.id}`)"
                type="button"
                class="btn btn-sm btn-danger"
              >
                <i class="fa fa-trash-alt"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { reactive } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useStore, mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      categories: (state) => state.category.categories,
    }),
  },
  setup() {
    const store = useStore();
    const state = reactive({});

    onMounted(() => {
      store.dispatch("GET_CATEGORIES");
    });

    const deleteButton = (id) => {
      alert("Are You Sure!");
      axios.delete(`/category/${id}`).then((res) => {
        if (res.data.status) {
          return (window.location.href = "/category");
        }
      });
    };
    return { state, deleteButton };
  },
};
</script>

<style>
</style>
