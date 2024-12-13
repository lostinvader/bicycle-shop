<script setup>
import { ref } from 'vue';
import Toast from '@/Components/Toast.vue';
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({ parts: Array, variant: Object, errors: Object });

let toast = ref({
  show: false,
  text:'Product Added to Cart',
  color:'green'
});

const priceVariations = [];
props.variant.variants
    .filter((e) => e.pivot.affected_price_amount_increase)
    .forEach((item) => {
        priceVariations[item.pivot.affected_variant_id] =
            item.pivot.affected_price_amount_increase;
    });

const form = useForm({
    name: props.variant.name,
    price: props.variant.default_price_amount,
    stock: props.variant.stock,
    disabled: props.variant.variants
        .filter((e) => !e.pivot.affected_disabled)
        .map((e) => e.pivot.affected_variant_id),
    priceIncrease: priceVariations,
});

function submit() {
  console.log('submit');
  form.patch(`/admin/variants/${props.variant.id}`, {
      preserveScroll: true,
      onSuccess: () => toast = {show:true, text:'Product Updated Succesfully', color:'green'},
      onError: () => toast = {show:true, text:'There are errors in your form', color:'red'},
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submit"
                    class="space-y-10 divide-y divide-gray-900/10"
                >
                    <!-- Detail Data -->
                    <div
                        class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3"
                    >
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base/7 font-semibold text-gray-900">
                                Main Details
                            </h2>
                            <p class="mt-1 text-sm/6 text-gray-600">
                                Variant main details
                            </p>
                        </div>

                        <div
                            class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
                        >
                            <div class="px-4 py-6 sm:p-8">
                                <div
                                    class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                                >
                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >Name</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                id="name"
                                                name="name"
                                                v-model="form.name"
                                                type="text"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div v-if="errors.name" class="text-red-800">{{ errors.name }}</div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >Default Price</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                id="price"
                                                name="price"
                                                v-model="form.price"
                                                type="number"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div v-if="errors.price" class="text-red-800">{{ errors.price }}</div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >Stock</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                id="stock"
                                                name="stock"
                                                v-model="form.stock"
                                                type="number"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div v-if="errors.stock" class="text-red-800">{{ errors.stock }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Disabled Content -->
                    <div
                        class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3"
                    >
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base/7 font-semibold text-gray-900">
                                Disabled Variantions
                            </h2>
                            <p class="mt-1 text-sm/6 text-gray-600">
                                Some combinations between items are not
                                possible. Check the ones that can't be selected
                                with this one
                            </p>
                        </div>

                        <div
                            class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
                        >
                            <div class="px-4 py-6 sm:p-8">
                                <div class="max-w-2xl space-y-10 md:col-span-2">
                                    <fieldset
                                        v-for="part in parts"
                                        :key="part.id"
                                    >
                                        <legend
                                            class="text-sm/6 font-semibold text-gray-900"
                                        >
                                            {{ part.name }}
                                        </legend>
                                        <div
                                            v-if="part.id != variant.part_id"
                                            class="mt-6 space-y-6"
                                        >
                                            <div
                                                v-for="option in part.variants"
                                                :key="option.id"
                                                class="flex gap-3"
                                            >
                                                <div
                                                    class="flex h-6 shrink-0 items-center"
                                                >
                                                    <div
                                                        class="group grid size-4 grid-cols-1"
                                                    >
                                                        <input
                                                            aria-describedby="comments-description"
                                                            :id="`disabled-${option.id}`"
                                                            v-model="
                                                                form.disabled
                                                            "
                                                            :value="option.id"
                                                            type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                                                        />
                                                        <svg
                                                            class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                                            viewBox="0 0 14 14"
                                                            fill="none"
                                                        >
                                                            <path
                                                                class="opacity-0 group-has-[:checked]:opacity-100"
                                                                d="M3 8L6 11L11 3.5"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                class="opacity-0 group-has-[:indeterminate]:opacity-100"
                                                                d="M3 7H11"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="text-sm/6">
                                                    <label
                                                        :for="`disabled-${option.id}`"
                                                        class="font-medium text-gray-900"
                                                        >{{
                                                            option.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <p>
                                                You can't block variants for the
                                                same part
                                            </p>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Increase By Variant -->
                    <div
                        class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3"
                    >
                        <div class="px-4 sm:px-0">
                            <h2 class="text-base/7 font-semibold text-gray-900">
                                Price Increase
                            </h2>
                            <p class="mt-1 text-sm/6 text-gray-600">
                                We'll always let you know about important
                                changes, but you pick what else you want to hear
                                about.
                            </p>
                        </div>

                        <div
                            class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
                        >
                            <div class="px-4 py-6 sm:p-8">
                                <div class="max-w-2xl space-y-10 md:col-span-2">
                                    <fieldset
                                        v-for="part in parts"
                                        :key="part.id"
                                    >
                                        <legend
                                            class="text-sm/6 font-semibold text-gray-900"
                                        >
                                            {{ part.name }}
                                        </legend>
                                        <div
                                            v-if="part.id != variant.part_id"
                                            class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3"
                                        >
                                            <div
                                                v-for="option in part.variants"
                                                :key="option.id"
                                            >
                                                <div class="sm:col-span-3">
                                                    <label
                                                        for="first-name"
                                                        class="block text-sm/6 font-medium text-gray-900"
                                                        >{{ option.name }} price
                                                        increase</label
                                                    >
                                                    <div class="mt-2">
                                                        <input
                                                            v-model="
                                                                form
                                                                    .priceIncrease[
                                                                    option.id
                                                                ]
                                                            "
                                                            type="number"
                                                            id="price-increase"
                                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <p>
                                                You can't increase price of
                                                items in a variation of a part
                                            </p>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <Toast :text="toast.text" :color="toast.color" v-if="toast.show"></Toast>
                      </div>
                    <div
                        class="flex items-center justify-end gap-x-6 px-4 py-4 sm:px-8"
                    >
                        <a
                            :href="route('variants.index')"
                            class="text-sm/6 font-semibold text-gray-900"
                            >Back</a
                        >
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
