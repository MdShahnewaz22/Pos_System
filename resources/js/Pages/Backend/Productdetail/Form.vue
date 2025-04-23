<script setup>
import { ref, onMounted } from "vue";
import BackendLayout from "@/Layouts/BackendLayout.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AlertMessage from "@/Components/AlertMessage.vue";
import { displayResponse, displayWarning } from "@/responseMessage.js";

const props = defineProps(["productdetail", "products", "units", "colors", "sizes", "id"]);

const form = useForm({

  product_id: props.productdetail?.product_id ?? "",
  unit_id: props.productdetail?.unit_id ?? "",
  unit_value: props.productdetail?.unit_value ?? "",
  color_id: props.productdetail?.color_id ?? "",
  size_id: props.productdetail?.size_id ?? "",
  selling_price: props.productdetail?.selling_price ?? "",
  purchase_price: props.productdetail?.purchase_price ?? "",
  tax: props.productdetail?.tax ?? 0,
  discount: props.productdetail?.discount ?? 0,
  total_price: props.productdetail?.total_price ?? "",

  image: props.productdetail?.image ?? "",

  imagePreview: props.productdetail?.image ?? "",
  filePreview: props.productdetail?.file ?? "",
  _method: props.productdetail?.id ? "put" : "post",
  massage: props.productdetail?.massage ?? "",
});

const handleimage = (event) => {
  const file = event.target.files[0];
  form.image = file;

  // Display image preview
  const reader = new FileReader();
  reader.onload = (e) => {
    form.imagePreview = e.target.result;
  };
  reader.readAsDataURL(file);
};

const submit = () => {
  const routeName = props.id
    ? route("backend.productdetail.update", props.id)
    : route("backend.productdetail.store");
  form
    .transform((data) => ({
      ...data,
      remember: "",
      isDirty: false,
    }))
    .post(routeName, {
      onSuccess: (response) => {
        if (!props.id) form.reset();
        displayResponse(response);
      },
      onError: (errorObject) => {
        displayWarning(errorObject);
      },
    });
};


import { watch } from "vue";

// Watch for changes in selling_price, tax, and discount
watch(
  () => [form.selling_price, form.tax, form.discount],
  ([newSellingPrice, newTax, newDiscount]) => {
    const price = parseFloat(newSellingPrice) || 0;
    const taxPercent = parseFloat(newTax) || 0;
    const discountPercent = parseFloat(newDiscount) || 0;

    // Step 1: Apply tax
    let total = price + (price * taxPercent / 100);

    // Step 2: Apply discount
    total = total - (total * discountPercent / 100);

    form.total_price = total.toFixed(2); // Keep it to 2 decimal places
  }
);


// import { computed } from "vue";

// const selectedProduct = computed(() => {
//   return props.products.find((product) => product.id === form.product_id);
// });


</script>

<template>
  <BackendLayout>
    <div
      class="w-full mt-3 transition duration-1000 ease-in-out transform bg-white border border-gray-700 rounded-md shadow-lg shadow-gray-800/50 dark:bg-slate-900">
      <div
        class="flex items-center justify-between w-full text-gray-700 bg-gray-100 rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200 shadow-gray-800/50">
        <div>
          <h1 class="p-4 text-xl font-bold dark:text-white">
            {{ $page.props.pageTitle }}
          </h1>
        </div>
        <div class="p-4 py-2"></div>
      </div>

      <form @submit.prevent="submit" class="p-4">
        <AlertMessage />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

          <div class="col-span-2 md:col-span-2">
            <InputLabel for="product_id" value="product Name" />
            <select id="product_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.product_id">
              <option value="">--Select Product--</option>
              <template v-for="(product, Index) in products" :key="Index">
                <option :value="product.id">
                  {{ product.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.product_id" />
          </div>

          <div class="col-span-2 md:col-span-2">
            <InputLabel for="unit_id" value="Unit Name" />
            <select id="unit_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.unit_id">
              <option value="">--Select Product--</option>
              <template v-for="(unit, Index) in units" :key="Index">
                <option :value="unit.id">
                  {{ unit.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.unit_id" />
          </div>
          <div class="col-span-1 md:col-span-2">
            <InputLabel for="unit_value" value="Unit value" />
            <input id="unit_value"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.unit_value" type="text" placeholder="Unit Value" />
            <InputError class="mt-2" :message="form.errors.unit_value" />
          </div>
          <div class="col-span-2 md:col-span-2">
            <InputLabel for="color_id" value="Color Name" />
            <select id="color_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.color_id">
              <option value="">--Select Color--</option>
              <template v-for="(color, Index) in colors" :key="Index">
                <option :value="color.id">
                  {{ color.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.color_id" />
          </div>
          <!-- <div class="col-span-2 md:col-span-2" v-if="selectedProduct?.name !== 'Sugar'">
            <InputLabel for="color_id" value="Color Name" />
            <select id="color_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.color_id">
              <option value="">--Select Color--</option>
              <template v-for="(color, Index) in colors" :key="Index">
                <option :value="color.id">
                  {{ color.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.color_id" />
          </div> -->

          <div class="col-span-2 md:col-span-2">
            <InputLabel for="size_id" value="Size Name" />
            <select id="size_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.size_id">
              <option value="">--Select Size--</option>
              <template v-for="(size, Index) in sizes" :key="Index">
                <option :value="size.id">
                  {{ size.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.size_id" />
          </div>

          <!-- <div class="col-span-2 md:col-span-2" v-if="selectedProduct?.name !== 'Sugar'">
            <InputLabel for="size_id" value="Size Name" />
            <select id="size_id"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.size_id">
              <option value="">--Select Size--</option>
              <template v-for="(size, Index) in sizes" :key="Index">
                <option :value="size.id">
                  {{ size.name }}
                </option>
              </template>
            </select>
            <InputError class="mt-2" :message="form.errors.size_id" />
          </div> -->



          <div class="col-span-1 md:col-span-2">
            <InputLabel for="purchase_price" value="Purchase Price" />
            <input id="purchase_price"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.purchase_price" type="text" placeholder="Purchase Price" />
            <InputError class="mt-2" :message="form.errors.purchase_price" />
          </div>
          <div class="col-span-1 md:col-span-2">
            <InputLabel for="selling_price" value="Selling Price" />
            <input id="selling_price"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.selling_price" type="number" placeholder="Selling Price" />
            <InputError class="mt-2" :message="form.errors.selling_price" />
          </div>
          <div class="col-span-1 md:col-span-2">
            <InputLabel for="tax" value="Tax %" />
            <input id="tax"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.tax" type="number" placeholder="Tax %" />
            <InputError class="mt-2" :message="form.errors.tax" />
          </div>
          <div class="col-span-1 md:col-span-2">
            <InputLabel for="discount" value="Discount %" />
            <input id="discount"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.discount" type="number" placeholder="Discount %" />
            <InputError class="mt-2" :message="form.errors.discount" />
          </div>
          <div class="col-span-1 md:col-span-2">
            <InputLabel for="total_price" value="Total Price" />
            <input id="total_price"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              v-model="form.total_price" type="number" placeholder="Total Price" readonly />

            <InputError class="mt-2" :message="form.errors.total_price" />
          </div>

          <div class="col-span-1 md:col-span-2">
            <InputLabel for="image" value="Image" />
            <div v-if="form.imagePreview">
              <img :src="form.imagePreview" alt="Photo Preview" class="max-w-xs mt-2" height="60" width="60" />
            </div>
            <input id="image" type="file" accept="image/*"
              class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
              @change="handleimage" />
            <InputError class="mt-2" :message="form.errors.image" />
          </div>


          <!-- add filde  -->
        </div>

        <div class="flex items-center justify-end mt-4">
          <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing">
            {{ props.id ?? false ? "Update" : "Create" }}
          </PrimaryButton>
        </div>
      </form>
    </div>
  </BackendLayout>
</template>
