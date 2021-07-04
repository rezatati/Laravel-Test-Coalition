
<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Products
      </h2>

      <jet-button @click="goToAddProductPage"> Add Product </jet-button>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table>
            <thead>
              <tr>
                <th>name</th>
                <th>price</th>
                <th>quantity</th>
                <th>Total value number</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>
                  {{ product.name }}
                </td>
                <td>
                  {{ product.price / 100 }}
                </td>
                <td>
                  {{ product.quantity }}
                </td>
                <td>
                  {{ (product.quantity * (product.price / 100)).toFixed(2) }}
                </td>
                <td>
                  {{ product.created_at }}
                </td>
                <td>
                  <a
                    @click="GoEditForm(product.id)"
                    style="color: green; cursor: pointer"
                    >Edit</a
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import axios from "axios";
import JetButton from "@/Jetstream/Button";
import { Inertia } from "@inertiajs/inertia";
export default {
  components: {
    AppLayout,
    JetButton,
  },
  data() {
    return {
      products: null,
    };
  },
  methods: {
    goToAddProductPage() {
      console.log(this);
      Inertia.visit("/add-product/", { method: "get" });
    },
    GoEditForm(id) {
      Inertia.visit("/add-product/" + id, { method: "get" });
      console.log(this.$root);
    },
  },
  async beforeMount() {
    await axios({
      url: "/products/",
      method: "POST",
    })
      .then((resp) => {
        if (resp.data.result) {
          this.products = resp.data.data;
        }
        //console.log(resp);
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
<style scoped>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>