<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <jet-form-section @submitted="saveProduct">
            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input
                  id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  autocomplete="name"
                />
              </div>

              <div class="col-span-6 sm:col-span-4">
                <jet-label for="price" value="price" />
                <jet-input
                  id="price"
                  step=".01"
                  type="number"
                  class="mt-1 block w-full"
                  v-model="form.price"
                />
              </div>
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="quantity" value="quantity" />
                <jet-input
                  id="quantity"
                  type="number"
                  class="mt-1 block w-full"
                  v-model="form.quantity"
                />
              </div>
            </template>
            <template #actions>
              <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
              </jet-action-message>

              <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Save
              </jet-button>
            </template>
          </jet-form-section>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
export default {
  components: {
    AppLayout,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },
  beforeMount() {
    this.form.id = route().params.id;
    this.getProductInfo(route().params.id);
  },
  data() {
    return {
      form: {
        id: undefined,
        name: "",
        quantity: 0,
        price: 0,
      },
    };
  },
  methods: {
    async getProductInfo(id) {
      await axios({
        url: "/get-product/" + id,
        method: "get",
      })
        .then((resp) => {
          if (resp.data.result) {
            this.form.name = resp.data.data.name;
            this.form.price = resp.data.data.price / 100;
            this.form.quantity = resp.data.data.quantity;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async saveProduct() {
      await axios({
        url: route("product.save"),
        method: "POST",
        data: this.form,
      })
        .then((resp) => {
          if (resp.data.result) {
            alert("data saved successfully.");
            Inertia.visit("/products/", { method: "get" });
          }
          //console.log(resp);
        })
        .catch((err) => {
          if (err.response && err.response.status == 422) {
            if (err.response.data.errors) {
              Object.keys(err.response.data.errors).forEach((key) => {
                alert(err.response.data.errors[key][0]);
              });
            }
          } else {
            console.log(err);
          }
        });
    },
  },
};
</script>
