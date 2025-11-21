<script setup>
import { computed } from "vue";

const props = defineProps({
    status: {
        type: String,
        required: true
    }
});

const label = computed(() => {
    switch (props.status) {
        case "approved":
            return "Approved";
        case "pending":
            return "Pending";
        case "rejected":
            return "Rejected";
        default:
            return props.status;
    }
});

const classes = computed(() => {
    switch (props.status) {
        case "approved":
            return "bg-green-100 text-green-700 border-green-300";
        case "pending":
            return "bg-yellow-100 text-yellow-700 border-yellow-300";
        case "rejected":
            return "bg-red-100 text-red-700 border-red-300";
        default:
            return "bg-gray-100 text-gray-700 border-gray-300";
    }
});
</script>

<template>
    <span
        class="px-3 py-1 rounded-full text-sm border font-medium"
        :class="classes"
    >
        {{ label }}
    </span>
</template>
