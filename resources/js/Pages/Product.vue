<script setup>
import { RadioGroup, RadioGroupOption } from '@headlessui/vue';
import { ShoppingBagIcon, UserIcon } from '@heroicons/vue/24/outline';
import Toast from '@/Components/Toast.vue';
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ product: Object, errors: Object });

let disabledVariants = ref([]);
let priceVariants = ref([]);
let cartPrice = ref(0);

let toast = ref({
    show: false,
    text: 'Product Added to Cart',
    color: 'green',
});

const form = useForm({
    id: props.product.id,
    selected: [],
    price: 0,
});

function calculate() {
    form.price = 0;
    disabledVariants.value = [];
    priceVariants.value = [];
    let extraItems = 0;

    form.selected.forEach((id) => {
        const selectedVariant = props.product.parts
            .flatMap((obj) => obj.variants)
            .find((x) => x.id == id);
        const disabled = selectedVariant.variants.filter(
            (x) => x.pivot.affected_disabled == 1,
        );
        const priceIncreaseVariants = selectedVariant.variants.filter(
            (x) => x.pivot.affected_price_amount_increase !== null,
        );

        disabledVariants.value = [...disabledVariants, ...disabled];
        priceVariants.value = [...priceVariants, ...priceIncreaseVariants];

        form.price += Number(selectedVariant.default_price_amount);
    });

    disabledVariants.value = disabledVariants.value.map((obj) => obj.id);

    form.selected.forEach((id) => {
        extraItems += Number(
            priceVariants.value.find((x) => x.id == id)?.pivot
                .affected_price_amount_increase ?? 0,
        );
    });

    form.price += extraItems;
}

function submit() {
    //TODO: Add more front validation checks, for example to check if all variants have been picked.
    form.post('/carts', {
        preserveScroll: true,
        onSuccess: () => {
            toast.value = {
                show: true,
                text: 'Product Added to Cart',
                color: 'green',
            };
            cartPrice.value = form.price;
        },
        onError: () =>
            (toast.value = {
                show: true,
                text: form.errors.selected,
                color: 'red',
            }),
    });
}
</script>

<template>
    <div class="bg-white">
        <header class="relative bg-white">
            <nav
                aria-label="Top"
                class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
            >
                <div class="border-b border-gray-200">
                    <div class="flex h-16 items-center justify-between">
                        <!-- Logo -->
                        <a href="#" class="flex">
                            <span class="sr-only">Gergonzalez</span>
                            <img
                                class="h-8 w-auto"
                                src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                                alt=""
                            />
                        </a>

                        <div class="flex flex-1 items-center justify-end">
                            <!-- Account -->
                            <Link
                                :href="route('login')"
                                class="p-2 text-gray-400 hover:text-gray-500 lg:ml-4"
                            >
                                <span class="sr-only">Account</span>
                                <UserIcon class="size-6" aria-hidden="true" />
                            </Link>

                            <!-- Cart -->
                            <div class="ml-4 flow-root lg:ml-6">
                                <a
                                    href="#"
                                    class="group -m-2 flex items-center p-2"
                                >
                                    <ShoppingBagIcon
                                        class="size-6 shrink-0 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true"
                                    />
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"
                                        >{{ cartPrice }}</span
                                    >
                                    <span class="sr-only"
                                        >items in cart, view bag</span
                                    >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main
            class="mx-auto mt-8 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8"
        >
            <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                <div class="lg:col-span-5 lg:col-start-8">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium text-gray-900">
                            {{ product.name }}
                        </h1>
                        <p class="text-xl font-medium text-gray-900">
                            {{ `€${form.price}` }}
                        </p>
                    </div>
                </div>

                <!-- Image -->
                <div
                    class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0"
                >
                    <h2 class="sr-only">Images</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-8">
                        <img
                            src="https://img.gergonzalez.es/bike.jpg"
                            alt="Bike Image"
                            class="lg:col-span-2 lg:row-span-2"
                        />
                    </div>
                </div>

                <div class="mt-8 lg:col-span-5">
                    <form @submit.prevent="submit">
                        <!-- Filters -->
                        <div
                            class="mt-8"
                            v-for="part in product.parts"
                            :key="part.id"
                        >
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-medium text-gray-900">
                                    {{ part.name }}
                                </h2>
                            </div>

                            <fieldset
                                aria-label="Choose a {{ part.name }}"
                                class="mt-2"
                            >
                                <RadioGroup
                                    v-model="form.selected[part.id]"
                                    class="grid grid-cols-3 gap-3 sm:grid-cols-3"
                                >
                                    <RadioGroupOption
                                        as="template"
                                        v-for="variant in part.variants"
                                        :key="variant.id"
                                        :value="variant.id"
                                        @click="calculate"
                                        :disabled="
                                            disabledVariants.includes(
                                                variant.id,
                                            )
                                        "
                                        v-slot="{ active, checked }"
                                    >
                                        <div
                                            :class="[
                                                !disabledVariants.includes(
                                                    variant.id,
                                                )
                                                    ? 'cursor-pointer focus:outline-none'
                                                    : 'cursor-not-allowed opacity-25',
                                                active
                                                    ? 'ring-2 ring-indigo-500 ring-offset-2'
                                                    : '',
                                                checked
                                                    ? 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700'
                                                    : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50',
                                                'rounded-md border px-3 py-3 text-sm font-medium uppercase',
                                            ]"
                                        >
                                            <p class="font-bold">
                                                {{ variant.name }}
                                            </p>
                                            <p class="text-xs">
                                                {{
                                                    `€${variant.default_price_amount}`
                                                }}
                                            </p>
                                            <span
                                                class="text-xs"
                                                v-if="
                                                    priceVariants?.find(
                                                        (x) =>
                                                            x.id == variant.id,
                                                    )
                                                "
                                                >Extra:
                                                {{
                                                    `€${priceVariants?.find((x) => x.id == variant.id)?.pivot.affected_price_amount_increase}`
                                                }}</span
                                            >
                                        </div>
                                    </RadioGroupOption>
                                </RadioGroup>
                            </fieldset>
                        </div>
                        <Toast
                            :text="toast.text"
                            :color="toast.color"
                            v-if="toast.show"
                        ></Toast>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </main>

        <footer aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="border-t border-gray-100 py-10 text-center">
                    <p class="text-sm text-gray-500">
                        &copy; 2024 German Gonzalez. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
