<template>
  <AdminLayout>
    <div class="flex justify-between mb-4">
      <h1 class="text-2xl font-bold">Purchase Requests</h1>
      <button class="btn btn-primary" @click="openModal = true">New Request</button>
    </div>

    <!-- Table des demandes -->
    <table class="table w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th>Requester</th>
          <th>Supplier</th>
          <th>Status</th>
          <th>Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="request in requests" :key="request.id">
          <td>{{ request.id }}</td>
          <td>{{ request.requester.name }}</td>
          <td>{{ request.supplier.name }}</td>
          <td>{{ request.status }}</td>
          <td>{{ request.total_amount }}</td>
          <td class="space-x-2">
            <button class="btn btn-sm btn-warning" @click="editRequest(request)">Edit</button>
            <button class="btn btn-sm btn-error" @click="deleteRequest(request.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const requests = ref([]);
const openModal = ref(false);

function fetchRequests() {
  axios.get('/api/admin/purchase-requests').then(res => {
    requests.value = res.data.data;
  });
}

function editRequest(request) {
  // ouvrir modal ou page pour modifier
}

function deleteRequest(id) {
  if (!confirm('Are you sure?')) return;
  axios.delete(`/api/admin/purchase-requests/${id}`).then(() => fetchRequests());
}

onMounted(() => fetchRequests());
</script>
