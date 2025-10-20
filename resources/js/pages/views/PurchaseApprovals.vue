<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Purchase Approvals</h1>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Request</th><th>Approved By</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="appr in approvals" :key="appr.id">
          <td>{{ appr.id }}</td>
          <td>{{ appr.request_number }}</td>
          <td>{{ appr.approved_by_name }}</td>
          <td>{{ appr.status }}</td>
          <td class="space-x-2">
            <button class="btn btn-sm btn-success" @click="approve(appr.id)">Approve</button>
            <button class="btn btn-sm btn-error" @click="reject(appr.id)">Reject</button>
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

const approvals = ref([]);

function fetchApprovals(){ axios.get('/api/admin/purchase-approvals').then(res=>approvals.value=res.data.data); }
function approve(id){ axios.post(`/api/admin/purchase-approvals/${id}/approve`).then(fetchApprovals); }
function reject(id){ axios.post(`/api/admin/purchase-approvals/${id}/reject`).then(fetchApprovals); }

onMounted(fetchApprovals);
</script>
