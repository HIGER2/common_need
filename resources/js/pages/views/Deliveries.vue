<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Deliveries</h1>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Order</th><th>Delivered By</th><th>Delivery Date</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="del in deliveries" :key="del.id">
          <td>{{ del.id }}</td>
          <td>{{ del.order_number }}</td>
          <td>{{ del.delivered_by_name }}</td>
          <td>{{ del.delivery_date }}</td>
          <td>{{ del.status }}</td>
          <td>
            <button class="btn btn-sm btn-success" @click="confirmReceived(del.id)">Confirm Received</button>
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

const deliveries = ref([]);

function fetchDeliveries(){ axios.get('/api/admin/deliveries').then(res=>deliveries.value=res.data.data); }
function confirmReceived(id){ axios.post(`/api/admin/deliveries/${id}/confirm`).then(fetchDeliveries); }

onMounted(fetchDeliveries);
</script>
