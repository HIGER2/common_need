<template>
  <div id="printArea" class="p-6 bg-white rounded-xl shadow-lg max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold">Purchase Order Summary</h2>

      <StatusBadge :status="data.status" />
    </div>

    <!-- Global Purchase Information -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <p class="text-gray-600">Reference</p>
        <p class="font-semibold">{{ data.reference }}</p>
      </div>

      <div>
        <p class="text-gray-600">Total Amount</p>
        <p class="font-semibold">{{ data.total_amount }} FCFA</p>
      </div>

      <div>
        <p class="text-gray-600">Total Items</p>
        <p class="font-semibold">{{ data.total_item }}</p>
      </div>

      <div>
        <p class="text-gray-600">Date</p>
        <p class="font-semibold">{{ data.date }}</p>
      </div>
    </div>

    <hr class="my-6">

    <!-- Requester Info -->
    <div>
      <h3 class="text-xl font-bold mb-3">Requester Information</h3>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <p class="text-gray-600">Name</p>
          <p class="font-semibold">{{ data.purchase_request.requester.name }}</p>
        </div>

        <div>
          <p class="text-gray-600">Email</p>
          <p class="font-semibold">{{ data.purchase_request.requester.email }}</p>
        </div>

        <div>
          <p class="text-gray-600">Role</p>
          <p class="font-semibold">{{ data.purchase_request.requester.role }}</p>
        </div>

        <StatusBadge :status="data.purchase_request.status" />
      </div>
    </div>

    <hr class="my-6">

    <!-- Requests grouped by supplier -->
    <div>
      <h3 class="text-xl font-bold mb-4">Supplier Requests</h3>

      <div
        v-for="req in data.purchase_request.requests"
        :key="req.id"
        class="border rounded-lg p-4 mb-5 shadow-sm"
      >
        <div class="flex justify-between items-center">
          <h4 class="text-lg font-bold">Supplier: {{ req.supplier.name }}</h4>
          <StatusBadge :status="req.status" />
        </div>

        <p class="text-gray-600 mb-3">
          Reference: <strong>{{ req.reference }}</strong> |
          Total: <strong>{{ req.total_amount }} FCFA</strong>
        </p>

        <table class="w-full text-left border mt-2">
          <thead>
            <tr class="bg-gray-100">
              <th class="p-2">Product</th>
              <th class="p-2">Qty</th>
              <th class="p-2">Unit Price</th>
              <th class="p-2">Subtotal</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="item in req.items"
              :key="item.id"
              class="border-t"
            >
              <td class="p-2">{{ item.name }}</td>
              <td class="p-2">{{ item.quantity }}</td>
              <td class="p-2">{{ item.unit_price }} FCFA</td>
              <td class="p-2">{{ item.subtotal }} FCFA</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4 mt-8 no-print">
      <button
        @click="downloadPDF"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
      >
        Télécharger PDF
      </button>

      <button
        @click="printPage"
        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black"
      >
        Imprimer cette page
      </button>
    </div>

  </div>
</template>

<script setup>
import StatusBadge from "@/pages/components/StatusBadge.vue"

const props = defineProps({
  data: { type: Object, required: true }
})

const printPage = () => {
  window.print()
}

const downloadPDF = () => {
  window.open(`/api/purchase-global/${props.data.id}/pdf`, "_blank")
}
</script>

<style>
/* Masquer les boutons à l’impression */
@media print {
  .no-print {
    display: none !important;
  }
}
</style>
