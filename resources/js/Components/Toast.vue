<script setup>
defineProps({
    text: {
        type: String,
        default: '',
    },
    color: {
        type: String,
        default: 'green',
    },
});
</script>

<template>
    <div :class="`rounded-md bg-${color}-50 mt-5 p-4 lg:col-span-5`">
        <div class="flex">
            <div class="ml-3">
                <p :class="`text-sm font-medium text-${color}-800`">
                    {{ text }}
                </p>
            </div>
        </div>
    </div>
</template>
