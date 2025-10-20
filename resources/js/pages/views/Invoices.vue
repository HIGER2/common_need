<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Invoices</h1>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Order</th><th>Supplier</th><th>Amount</th><th>Status</th><th>Invoice Date</th></tr>
      </thead>
      <tbody>
        <tr v-for="inv in invoices" :key="inv.id">
          <td>{{ inv.id }}</td>
          <td>{{ inv.order_number }}</td>
          <td>{{ inv.supplier_name }}</td>
          <td>{{ inv.amount }}</td>
          <td>{{ inv.status }}</td>
          <td>{{ inv.invoice_date }}</td>
        </tr>
      </tbody>
    </table>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const invoices = ref([]);
function fetchInvoices(){ axios.get('/api/admin/invoices').then(res=>invoices.value=res.data.data); }
onMounted(fetchInvoices);
</script>
