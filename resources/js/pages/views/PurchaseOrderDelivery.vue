
<script setup>
import StatusBadge from "@/pages/components/StatusBadge.vue"
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import ManageDeliveyrQuantity from "../components/ManageDeliveyrQuantity.vue";
import { onBeforeUpdate, onUpdated } from "vue";

const props = defineProps({
  data: { type: Object, required: true }
})

const printPage = () => {
  window.print()
}

const downloadPDF = () => {
  window.open(`/api/purchase-global/${props.data.id}/pdf`, "_blank")
}


const confirmDelivery = (status) => {
  const uuid = props.data.uuid
  router.get(`/api/admin/deliveries/order/confirm/${uuid}`)

}

</script>



<template>
 <AdminLayout #default="{ user }">
    <div class="print:max-w-full  max-w-5xl mx-auto text-sm">
      <header class="bg-white no-print  border-gray-200 flex justify-between items-center  my-5">
          <!-- Titre -->
          <h1 class="flex items-center gap-1.5 text-xl font-semibold text-gray-800 truncate">
              Order delivery
          </h1>

          <!-- Boutons d'action -->
          <div class="flex gap-3">
              <!-- <button
              @click="updateStatus('approved')"
              class="px-4 py-2 bg-green-100 text-green-700 cursor-pointer rounded-xl hover:bg-green-200 transition"
              >
              Approved
              </button>

              <button
              @click="updateStatus('rejected')"
              class="px-4 py-2 bg-red-100 text-red-700 cursor-pointer rounded-xl hover:bg-red-200 transition"
              >
              Rejected
              </button>

            <a :href="`/purchase-orders/delivery/${data.uuid}`"
                    class="px-4 py-2 bg-white border border-gray-200 text-primarys cursor-pointer rounded-lg hover:bg-gray-50"
                  >
                  <i class="uil uil-truck-loading"></i>
                    Delivery
            </a> -->
            <button
                    @click="printPage"
                    class="px-4 py-2 bg-white border border-gray-200 text-primarys cursor-pointer rounded-lg hover:bg-gray-50"
                  >
                  <i class="uil uil-print"></i>
                    Print
            </button>
          </div>
      </header>
      <!-- <pre>{{ data?.deliveries || 'llll' }}</pre> -->
    <div id="printArea" class="p-6 border print:p-0 print:border-0 border-gray-200 bg-white  print:shadow-none print:max-w-full print:overflow-visible rounded-xl ">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-xl font-bold">Order Summary</h3>
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
        <p class="font-semibold">{{ data.total_amount }} </p>
      </div>
     

      <div>
        <p class="text-gray-600">Date</p>
        <p class="font-semibold">{{ data.date }}</p>
      </div>
    </div>


    <!-- Requester Info -->
    <!-- Purchase Request (Demande Globale) -->
    <!-- <div class="mt-6">
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
          <p class="text-gray-600">Name</p>
          <p class="font-semibold">{{ data.purchase_request.requester.name }}</p>
        </div>

        <div>
          <p class="text-gray-600">Email</p>
          <p class="font-semibold">{{ data.purchase_request.requester.email }}</p>
        </div>
      </div>
    </div> -->
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
      <div class="w-full flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Delivery Details</h3>
        <button>
          
        </button>

      </div>
      

        <template v-if="data?.deliveries">
          <div class="grid grid-cols-2 gap-4 mb-6">
              <div>
                <p class="text-gray-600">Reference</p>
                <p class="font-semibold">{{ data?.deliveries?.reference }}</p>
              </div>
              <div>
                <p class="text-gray-600">Qty Ordered</p>
                <p class="font-semibold">{{ data?.deliveries?.quantity_ordered }}</p>
              </div>
              <div>
                <p class="text-gray-600">Qty Received</p>
                <p class="font-semibold">{{ data?.deliveries?.quantity_received }}</p>
              </div>
              <div>
                <p class="text-gray-600">Total Amount Ordered</p>
                <p class="font-semibold">{{ data?.deliveries?.total_ordered }}</p>
              </div>
              <div>
                <p class="text-gray-600">Total Amount Received</p>
                <p class="font-semibold">{{ data?.deliveries?.total_received  }} </p>
              </div>
            

              <div>
                <p class="text-gray-600">Date</p>
                <p class="font-semibold">{{ data?.deliveries?.date }}</p>
              </div>
            </div>
            <div
              v-for="req in data?.deliveries?.delivery_request"
              :key="req.id"
              class="border border-gray-200 rounded-lg p-4 mb-5 "
            >
              <div class="flex justify-between items-center">
                  <h4 class="text-lg font-bold">Supplier: {{ req.supplier.name }}</h4>
                   <button 
                    onclick="my_modal_3.showModal()"
                      class="px-4 no-print py-1 btn btn-soft  shrink-0 flex items-center justify-between border-b border-default  sm:px-6 gap-1.5  text-[15px] font-medium  cursor-pointer "
                  >
                    Manage Qty
                  </button>
              </div>
               <ManageDeliveyrQuantity
                 :data="data?.deliveries"
                :deliveries="req"
                />

              <p class="text-gray-600 mb-3 flex items-center gap-2 my-3">
                <!-- Item: <strong>{{ req.total_item }}</strong>| -->
                Qty ordered: <strong>{{ req.quantity_ordered }}</strong>|
                Qty received: <strong>{{ req.quantity_received }}</strong>|
                Total ordered: <strong>{{ req.total_ordered }} </strong>|
                Total received: <strong>{{ req.total_received }} </strong>
              </p>

              <table class="w-full text-left  mt-2">
                <thead>
                  <tr class="bg-gray-100 text-sm">
                    <th class="p-2">Product</th>
                    <th class="p-2">Unit Price</th>
                    <th class="p-2">Qty ordered</th>
                    <th class="p-2">Qty received</th>
                    <th class="p-2">Subtotal ordered</th>
                    <th class="p-2">Subtotal received</th>
                  </tr>
                </thead>

                <tbody>
                  <tr
                    v-for="item in req.items"
                    :key="item.id"
                    class="border-t border-gray-200"
                  >
                    <td class="p-2">{{ item.name }}</td>
                    <td class="p-2">{{ item.unit_price }}</td>
                    <td class="p-2">{{ item.quantity_ordered }}</td>
                    <td class="p-2">{{ item.quantity_received }} </td>
                    <td class="p-2">{{ item.subtotal_ordered }} </td>
                    <td class="p-2">{{ item.subtotal_received }} </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </template>
        <template  v-else-if="user.role =='Requester'">
            <button @click="confirmDelivery" class="px-4 mx-auto active:scale-95 transition-all flex gap-1 py-2 bg-white border border-gray-200 text-primarys cursor-pointer rounded-lg hover:bg-gray-50">
                    <i class="uil uil-truck-loading"></i>
                      Confirm delivery
            </button>
        </template>
        <Template v-else>
          <!-- <div>empy </div> -->
        </Template>
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
