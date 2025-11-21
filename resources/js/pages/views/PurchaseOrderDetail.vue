
<script setup>
import StatusBadge from "@/pages/components/StatusBadge.vue"
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3'
import { inject } from "vue";

const props = defineProps({
  data: { type: Object, required: true }
})

const printPage = () => {
  window.print()
}

const downloadPDF = () => {
  window.open(`/api/purchase-global/${props.data.id}/pdf`, "_blank")
}


const updateStatus = (status) => {
  const uuid = props.data.uuid
  router.get(`/api/admin/purchase-requests/approve/${uuid}/${status}`, {
    onSuccess: () => {
      console.log('Status updated');
      router.reload({ only: ['data'] })
    },
    onError: (errors) => {
      console.error(errors)
    }
  })
}

// const user = inject('user');
</script>



<template>
 <AdminLayout #default="{ user }">
    <div class="print:max-w-full  max-w-5xl mx-auto">
      <!-- <pre>{{ data?.status }}</pre> -->
    <header class="bg-white no-print  border-gray-200 flex justify-between items-center  my-5">
        <!-- Titre -->
        <h1 class="flex items-center gap-1.5 text-xl font-semibold text-gray-800 truncate">
            Order details
        </h1>

        <!-- Boutons d'action -->
        <div class="flex gap-3">
          <template v-if="data?.status==='approved'">
               <a  :href="`/deliveries/order/${data.uuid}`"
                    class="px-4 py-2 bg-white border border-gray-200 text-primarys cursor-pointer rounded-lg hover:bg-gray-50"
                  >
                  <i class="uil uil-truck-loading"></i>
                    Delivery
            </a>
          </template>
           
            <button
                  @click="printPage"
                  class="px-4 py-2 bg-white border border-gray-200 text-primarys cursor-pointer rounded-lg hover:bg-gray-50"
                >
                <i class="uil uil-print"></i>
                  Print
          </button>
        </div>
    </header>
    <div id="printArea" class="p-6 border print:p-0 print:border-0 border-gray-200 bg-white  print:shadow-none print:max-w-full print:overflow-visible rounded-xl ">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold">Order Summary</h2>
      <StatusBadge :status="data.status" />
    </div>

    <!-- Global Purchase Information -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <p class="text-gray-600">Reference</p>
        <p class="font-semibold">{{ data.reference }}</p>
      </div>
      <div>
        <p class="text-gray-600">Total Items</p>
        <p class="font-semibold">{{ data.total_item }}</p>
      </div>
       <div>
        <p class="text-gray-600">Qty</p>
        <p class="font-semibold">{{ data.total_quantity }}</p>
      </div>
     
      <div>
        <p class="text-gray-600">Total Amount</p>
        <p class="font-semibold">{{ data.total_amount }} FCFA</p>
      </div>

      

      <div>
        <p class="text-gray-600">Date</p>
        <p class="font-semibold">{{ data.date }}</p>
      </div>
    </div>

    <hr class="my-6 border-gray-200">

    <!-- Requester Info -->
    <!-- Purchase Request (Demande Globale) -->
    <div class="mt-6">
      <h3 class="text-xl font-bold mb-3">Global Purchase Request</h3>

      <div class="grid grid-cols-2 gap-4 mb-4">

        <div>
          <p class="text-gray-600">Reference</p>
          <p class="font-semibold">{{ data.purchase_request.reference }}</p>
        </div>

        <div>
          <p class="text-gray-600">Status</p>
          <StatusBadge :status="data.purchase_request.status" />
        </div>

        <div>
          <p class="text-gray-600">Total Amount</p>
          <p class="font-semibold">{{ data.purchase_request.total_amount }} FCFA</p>
        </div>

        <div>
          <p class="text-gray-600">Total Items</p>
          <p class="font-semibold">{{ data.purchase_request.total_item }}</p>
        </div>

        <div>
          <p class="text-gray-600">Total Quantity</p>
          <p class="font-semibold">{{ data.purchase_request.total_quantity }}</p>
        </div>

        <div>
          <p class="text-gray-600">Date</p>
          <p class="font-semibold">{{ data.purchase_request.date }}</p>
        </div>
      </div>

      <h4 class="text-lg font-bold mt-4 mb-2">Requester</h4>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <p class="text-gray-600">Full Name</p>
          <p class="font-semibold">{{ data.purchase_request.requester.name }} {{ data.purchase_request.requester.last_name }}</p>
        </div>

        <div>
          <p class="text-gray-600">Email</p>
          <p class="font-semibold">{{ data.purchase_request.requester.email }}</p>
        </div>

        <!-- <div>
          <p class="text-gray-600">Role</p>
          <p class="font-semibold">{{ data.purchase_request.requester.role }}</p>
        </div>

        <div>
          <p class="text-gray-600">Phone</p>
          <p class="font-semibold">{{ data.purchase_request.requester.phone ?? 'N/A' }}</p>
        </div> -->
      </div>
        <h4 class="text-lg font-bold mt-4 mb-2">Budget Officer</h4>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <p class="text-gray-600">Full Name</p>
          <p class="font-semibold">{{ data.purchase_request?.budget_officer?.name }} {{ data.purchase_request?.budget_officer?.last_name }}</p>
        </div>
        <div>
          <p class="text-gray-600">Email</p>
          <p class="font-semibold">{{ data.purchase_request?.budget_officer?.email }}</p>
        </div>
      </div>
    </div>
    <!-- <div>
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
    </div> -->

    <hr class="my-6 border-gray-200">

    <!-- Requests grouped by supplier -->
    <div>
      <h3 class="text-xl font-bold mb-4">Supplier Requests</h3>

      <div
        v-for="req in data.purchase_request.requests"
        :key="req.id"
        class="border border-gray-200 rounded-lg p-4 mb-5 "
      >
        <div class="flex justify-between items-center">
          <h4 class="text-lg font-bold">Supplier: {{ req.supplier.name }}</h4>
          <!-- <StatusBadge :status="req.status" /> -->
        </div>

        <p class="text-gray-600 mb-3 flex items-center gap-2">
          Reference: <strong>{{ req.reference }}</strong> |
          Item: <strong>{{ req.total_item }}</strong>|
          Qty: <strong>{{ req.total_quantity }}</strong>|
          Total: <strong>{{ req.total_amount }} </strong>
        </p>

        <table class="w-full text-left  mt-2">
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
              class="border-t border-gray-200"
            >
              <td class="p-2">{{ item.name }}</td>
              <td class="p-2">{{ item.quantity }}</td>
              <td class="p-2">{{ item.unit_price }} </td>
              <td class="p-2">{{ item.subtotal }} </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

     <!-- Actions -->
    <!-- <div class="flex justify-end space-x-4 mt-8 no-print">
      <button
        @click="downloadPDF"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
      >
        Télécharger PDF
      </button>

      <button
        @click="printPage"
        class="px-4 py-2 bg-primarys text-white rounded-lg hover:bg-black"
      >
      <i class="uil uil-print"></i>
        Print
      </button>
    </div> -->

  </div>
    </div>
 </AdminLayout>
</template>

<style>
/* Masquer les boutons à l’impression */
@media print {
  
}
</style>
