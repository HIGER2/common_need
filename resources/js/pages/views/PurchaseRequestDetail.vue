
<script setup>
import { computed } from 'vue';
import StatusRequestBadge from '@/pages/components/StatusRequestBadge.vue';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
  requests: {
    type: Object,
    required: true
  }
});

const requestGlobal = computed(() => props.requests);
const requester = computed(() => props.requests.requester);

// Actions
function printPage() {
  window.print();
}

function downloadPDF() {
  const uuid = props.requests.uuid;
  window.open(`/api/admin/purchase-requests/${uuid}/pdf`, '_blank');
}

function updateStatus(status) {
  const uuid = props.requests.uuid;
  router.get(`/api/admin/purchase-requests/approve/${uuid}/${status}`,{
      onSuccess: () => {
        console.log('Status updated');
        // Inertia.reload()
      },
      onError: (errors) => {
        console.error(errors)
      }
  })
}

function formatDate(dateString) {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString();
}
</script>

<template>
    <AdminLayout>
          <div class="max-w-5xl mx-auto p-10 print:border-0 bg-white rounded-xl border border-gray-200 space-y-6 print-area">
            <!-- Header actions -->
            <div class="flex justify-between items-center border-b pb-4">
              <h1 class="text-2xl font-semibold">Purchase Request Details</h1>
              <div class="flex gap-3">
                <button @click="printPage" class="px-4 cursor-pointer py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Print</button>
                <!-- <button @click="downloadPDF" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">Download PDF</button>
                <button @click="updateStatus('approved')" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200">Approve</button>
                <button @click="updateStatus('rejected')" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">Reject</button> -->
              </div>
            </div>

            <!-- Global Request Info -->
            <div class="border-b py-2 border-gray-100 ">
              <h2 class="text-xl font-semibold mb-4">Request Info</h2>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div><strong>Reference:</strong> {{ requestGlobal.reference }}</div>
                <div><strong>Status:</strong> <StatusRequestBadge :status="requestGlobal.status" /></div>
                <div><strong>Date:</strong> {{ requestGlobal.date }}</div>
                <div><strong>Total Items:</strong> {{ requestGlobal.total_item }}</div>
                <div><strong>Total Quantity:</strong> {{ requestGlobal.total_quantity }}</div>
                <div><strong>Total Amount:</strong> {{ requestGlobal.total_amount }}</div>
              </div>
            </div>
            <!-- <pre>{{ requests?.liaison_officer }}</pre> -->
            <!-- Requester Info -->
            <div class="border-b py-2 border-gray-100 ">
              <h2 class="text-xl font-semibold mb-4">Requester </h2>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div><strong>Full Name:</strong> {{ requester.name }} {{ requester.last_name }}</div>
                <div><strong>Email:</strong> {{ requester.email }}</div>
                <!-- <div><strong>Phone:</strong> {{ requester.phone ?? 'N/A' }}</div> -->
                <!-- <div><strong>Role:</strong> {{ requester.role }}</div> -->
                <!-- <div><strong>Status:</strong> {{ requester.status }}</div> -->
                <!-- <div><strong>Account Created:</strong> {{ formatDate(requester.created_at) }}</div> -->
              </div>
            </div>
            <!-- Requester Info -->
            <div class="border-b py-2 border-gray-100 ">
              <h2 class="text-xl font-semibold mb-4">Budget Officer </h2>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div><strong>Full Name:</strong> {{ requests?.budget_officer?.name }} {{ requests?.budget_officer?.last_name }}</div>
                <div><strong>Email:</strong> {{ requests?.budget_officer?.email }}</div>
                <!-- <div><strong>Phone:</strong> {{ liaisonOfficer.phone ?? 'N/A' }}</div> -->
                <!-- <div><strong>Role:</strong> {{ liaisonOfficer.role }}</div> -->
                <!-- <div><strong>Status:</strong> {{ requester.status }}</div> -->
                <!-- <div><strong>Account Created:</strong> {{ formatDate(requester.created_at) }}</div> -->
              </div>
            </div>
            <!-- Supplier Requests -->
            <div class="space-y-6 ">
              <h2 class="text-xl font-semibold">
                Requests items by Supplier
              </h2>
              <div v-for="req in requestGlobal.requests" :key="req.id" class="bg-white p-6 rounded-xl border-gray-100 border">
                <div class="flex justify-between items-center mb-4">
                  <div>
                    <h3 class="text-lg font-medium">{{ req.supplier.name }} {{ req.supplier.last_name }}</h3>
                    <div class="text-sm text-gray-500">Reference: {{ req.reference }}</div>
                  </div>
                  <!-- <StatusRequestBadge :status="req.status" /> -->
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                  <div><strong>Items:</strong> {{ req.total_item }}</div>
                  <div><strong>Quantity:</strong> {{ req.total_quantity }}</div>
                  <div><strong>Amount:</strong> {{ req.total_amount }}</div>
                  <div><strong>Date:</strong> {{ req.date }}</div>
                </div>
                <div class="space-y-2">
                  <h4 class="font-medium">Products</h4>
                  <div v-for="item in req.items" :key="item.id" class="flex justify-between bg-gray-50 p-3 rounded text-sm">
                    <div>{{ item.name }}</div>
                    <div>Qty: {{ item.quantity }}</div>
                    <div>Unit: {{ item.unit_price }}</div>
                    <div>Total: {{ item.subtotal }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full border-t text-2xl pt-4 mt-4 flex ">
              <div><strong>Total Amount:</strong> {{ requestGlobal.total_amount }}</div>
              <!-- <div class="text-right">
                <p class="text-gray-600">Prepared by:</p>
                <p class="font-semibold">{{ requester.name }}</p>
              </div> -->

            </div>
          </div>
    </AdminLayout>
</template>


<style scoped>
@media print {
  button {
    display: none !important;
  }
  .print-area {
    width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }
}
</style>
