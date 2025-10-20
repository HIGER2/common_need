<template>
  <AdminLayout>
    <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-4 gap-4">
      <div class="card bg-base-100 shadow-md p-4">
        <div class="font-bold text-xl">Users</div>
        <div>{{ stats.users }}</div>
      </div>
      <div class="card bg-base-100 shadow-md p-4">
        <div class="font-bold text-xl">Suppliers</div>
        <div>{{ stats.suppliers }}</div>
      </div>
      <div class="card bg-base-100 shadow-md p-4">
        <div class="font-bold text-xl">Purchase Requests</div>
        <div>{{ stats.purchase_requests }}</div>
      </div>
      <div class="card bg-base-100 shadow-md p-4">
        <div class="font-bold text-xl">Orders</div>
        <div>{{ stats.orders }}</div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref({
  users: 0,
  suppliers: 0,
  purchase_requests: 0,
  orders: 0,
});

onMounted(() => {
//   axios.get('/api/admin/stats').then(res => stats.value = res.data);
});
</script>
