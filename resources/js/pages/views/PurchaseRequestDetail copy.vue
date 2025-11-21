<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Inertia } from '@inertiajs/inertia'
import StatusRequestBadge from '../components/StatusRequestBadge.vue';

const props =defineProps({
  requests: Object, // objet global reçu du serveur
});

// Grouper les requests par supplier
const requestsBySupplier = computed(() => {
  const groups = {};
  (props.requests.requests || []).forEach(req => {
    const supplierId = req.supplier.id;
    if (!groups[supplierId]) {
      groups[supplierId] = {
        supplier: req.supplier,
        requests: [],
      };
    }
    groups[supplierId].requests.push(req);
  });
  return Object.values(groups);
});

// Contrôle ouverture / fermeture des suppliers
const openSupplier = ref({});
const toggleSupplier = (id) => {
  openSupplier.value[id] = !openSupplier.value[id];
};

const updateStatus = (status) => {
  const uuid = props.requests.uuid

  Inertia.get(`/api/admin/purchase-requests/approve/${uuid}/${status}`, {
    onSuccess: (data) => {
      console.log('Status updated');
    },
    onError: (errors) => {
      console.error(errors)
    }
  })

}
</script>

<template>
    <AdminLayout>
        <div class="p-6 space-y-6 max-w-5xl mx-auto"> 
          <pre>{{ requests }}</pre>
            <header class="bg-white border-b border-gray-200 flex justify-between items-center px-4 h-16">
            <!-- Titre -->
            <h1 class="flex items-center gap-1.5 text-xl font-semibold text-gray-800 truncate">
                Request details
            </h1>

            <!-- Boutons d'action -->
            <div class="flex gap-3">
                <!-- Approved soft green background -->
                <button
                @click="updateStatus('approved')"
                class="px-4 py-2 bg-green-100 text-green-700 cursor-pointer rounded-xl hover:bg-green-200 transition"
                >
                Approved
                </button>

                <!-- Rejected soft red background -->
                <button
                @click="updateStatus('rejected')"
                class="px-4 py-2 bg-red-100 text-red-700 cursor-pointer rounded-xl hover:bg-red-200 transition"
                >
                Rejected
                </button>
            </div>
            </header>
            <!-- Info globale de la commande -->
            <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-semibold mb-4">Global Purchase Info</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div><strong>Reference:</strong> {{ requests.reference }}</div>
                <div><strong>Total Items:</strong> {{ requests.total_item }}</div>
                <div><strong>Total Quantity:</strong> {{ requests.total_quantity }}</div>
                <div><strong>Total Amount:</strong> {{ requests.total_amount }}</div>
                <div><strong>Status: </strong>  <StatusRequestBadge :status="requests.status" /></div>
                <div><strong>Date:</strong> {{ requests.date }}</div>
            </div>
            </div>
            <!-- Cards par supplier -->
            <div class="space-y-4">
            <div v-for="group in requestsBySupplier" :key="group.supplier.id" class="bg-white shadow rounded overflow-hidden">
                <!-- Header supplier -->
                <div
                class="px-6 py-4 flex justify-between items-center cursor-pointer hover:bg-gray-50"
                @click="toggleSupplier(group.supplier.id)"
                >
                <div class="flex items-center gap-4">
                    <div class="font-semibold text-lg">{{ group.supplier.name }} {{ group.supplier.last_name }}</div>
                    <div class="text-gray-500 text-sm">({{ group.requests.length }} request(s))</div>
                </div>
                <div class="text-gray-500">{{ openSupplier[group.supplier.id] ? '▲' : '▼' }}</div>
                </div>

                <!-- Body des requests -->
                <transition name="fade">
                <div v-if="openSupplier[group.supplier.id]" class="px-6 py-4 border-t border-gray-200 space-y-4">
                    <div v-for="req in group.requests" :key="req.id" class="bg-gray-50 p-4 rounded shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-medium">Request: {{ req.reference }}</div>
                        <div class="text-sm text-gray-600">{{ req.status }}</div>
                    </div>
                    <div class="grid mb-5 grid-cols-3 md:grid-cols-6 gap-2 text-sm text-gray-700 ">
                        <div>Total Items: {{ req.total_item }}</div>
                        <div>Total quantity: {{ req.total_quantity }}</div>
                        <div>Total amount: {{ req.total_amount }}</div>
                        <!-- <div>Date: {{ req.date }}</div> -->
                        <!-- <div v-if="req.remarks">Remarks: {{ req.remarks }}</div> -->
                    </div>

                    <!-- Items -->
                    <div class="mt-2 space-y-1">
                        <h2>Items</h2>
                        <div v-for="item in req.items" :key="item.id" class="flex justify-between text-sm px-2 py-1 bg-white rounded shadow-sm">
                        <div>Item: {{ item?.name || "N/A" }}</div>
                        <div>Qty: {{ item.quantity }}</div>
                        <div>Unit: {{ item.unit_price }}</div>
                        <div>Subtotal: {{ item.subtotal }}</div>
                        </div>
                    </div>
                    </div>
                </div>
                </transition>
            </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
