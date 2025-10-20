<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Monthly Reports</h1>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Month</th><th>Year</th><th>Center</th><th>Total Amount</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="r in reports" :key="r.id">
          <td>{{ r.id }}</td>
          <td>{{ r.month }}</td>
          <td>{{ r.year }}</td>
          <td>{{ r.center_name }}</td>
          <td>{{ r.total_amount }}</td>
          <td><a :href="r.report_file" target="_blank" class="btn btn-sm btn-info">Download</a></td>
        </tr>
      </tbody>
    </table>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const reports = ref([]);
function fetchReports(){ axios.get('/api/admin/monthly-reports').then(res=>reports.value=res.data.data); }
onMounted(fetchReports);
</script>
