<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Purchase Orders</h1>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Request</th><th>Supplier</th><th>Status</th><th>Order Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.request_number }}</td>
          <td>{{ order.supplier_name }}</td>
          <td>{{ order.status }}</td>
          <td>{{ order.order_date }}</td>
          <td class="space-x-2">
            <button class="btn btn-sm btn-info" @click="viewOrder(order)">View</button>
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

const orders = ref([]);

function fetchOrders(){ axios.get('/api/admin/purchase-orders').then(res=>orders.value=res.data.data); }
function viewOrder(order){ alert(JSON.stringify(order.items)); }

onMounted(fetchOrders);
</script>
