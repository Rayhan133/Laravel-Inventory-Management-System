<template>
    <div class="form-group">
        <label for="name">Customer Name</label>
        <div class="col-12">
            <AutoComplete
                required
                ref="customerInput"
                :forceSelection="true"
                :completeOnFocus="true"
                inputClass="form-control"
                inputStyle="width:auto;min-width:750px"
                v-model="data.selectedCustomer"
                :suggestions="data.filteredCustomer"
                @complete="searchCustomer($event)"
                field="name"
            />
            <hr />
            <div class="border p-2 bg-info" v-if="data.selectedCustomer">
                <div class="row">
                    <div class="col-6">
                        <p>
                            <strong>Name : </strong
                            >{{ data.selectedCustomer.name }}
                        </p>
                        <p>
                            <strong>Phone : </strong
                            >{{ data.selectedCustomer.phone }}
                        </p>
                        <p>
                            <strong>Zone : </strong
                            >{{ pickZone(data.selectedCustomer) }}
                        </p>
                        <p>
                            <strong>Address : </strong
                            >{{ data.selectedCustomer.address_line_1 }}
                        </p>
                    </div>
                    <div class="col-6">
                        <h3>
                            Customer ID #: {{ data.selectedCustomer.unique_id }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AutoComplete from "primevue/autocomplete";
import { reactive, computed, onMounted } from "vue";
import { useStore } from "vuex";
export default {
    components: { AutoComplete },
    mounted() {
        this.$refs.customerInput.focus();
    },
    setup(props) {
        const store = useStore();
        const data = reactive({
            customers: computed(() => store.state.customer.customers),
            filteredCustomer: null,
            selectedCustomer: "",
            zone: { name: "" },
        });
        onMounted(() => {
            store.dispatch("GET_CUSTOMERS");
        });

        const searchCustomer = (event) => {
            data.filteredCustomer = data.customers.filter((customer) => {
                if (!+event.query) {
                    return customer.name
                        .toLowerCase()
                        .startsWith(event.query.toLowerCase());
                } else {
                    return customer.unique_id.startsWith("CU" + event.query);
                }
            });
        };

        const pickZone = (customer) => {
            store.commit("SET_CUSTOMER_ID", customer.id);
            const { name } = customer.zone ? customer.zone : data.zone;
            data.zone.name = name;
            return name;
        };

        return { data, searchCustomer, pickZone };
    },
};
</script>

<style></style>
