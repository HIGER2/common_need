<template>
  <span 
    class="px-3 py-1 text-sm font-semibold rounded-full"
    :class="statusClass"
  >
    {{ label }}
  </span>
</template>

<script setup>
const props = defineProps({
  status: { type: String, required: true }
})

const map = {
  pending: { label: "Pending", class: "bg-yellow-100 text-yellow-700 border border-yellow-300" },
  approved: { label: "Approved", class: "bg-green-100 text-green-700 border border-green-300" },
  rejected: { label: "Rejected", class: "bg-red-100 text-red-700 border border-red-300" },
  sent: { label: "Sent", class: "bg-blue-100 text-blue-700 border border-blue-300" }
}

const label = map[props.status]?.label ?? props.status
const statusClass = map[props.status]?.class ?? "bg-gray-100 text-gray-700"
</script>
