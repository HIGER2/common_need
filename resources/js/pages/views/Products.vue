<template>
  <AdminLayout>
    <div class="flex justify-between mb-4">
      <h1 class="text-2xl font-bold">Purchase Requests</h1>
      <button class="btn btn-primary" @click="openModal = true">New Request</button>
    </div>

    <table class="table w-full">
      <thead>
        <tr><th>ID</th><th>Requester</th><th>Supplier</th><th>Total</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr v-for="req in requests" :key="req.id">
          <td>{{ req.id }}</td>
          <td>{{ req.requester_name }}</td>
          <td>{{ req.supplier_name }}</td>
          <td>{{ req.total_amount }}</td>
          <td>{{ req.status }}</td>
          <td class="space-x-2">
            <button class="btn btn-sm btn-warning" @click="editRequest(req)">Edit</button>
            <button class="btn btn-sm btn-error" @click="deleteRequest(req.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="openModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded w-2/3 max-h-[90vh] overflow-auto">
        <h2 class="text-xl font-bold mb-4">{{ editing ? 'Edit Request' : 'New Request' }}</h2>
        <form @submit.prevent="saveRequest">
          <div class="mb-4">
            <label>Supplier</label>
            <select v-model="form.supplier_id" class="select select-bordered w-full">
              <option v-for="s in suppliers" :key="s.id" :value="s.id">{{ s.name }}</option>
            </select>
          </div>
          <div class="mb-4">
            <label>Products</label>
            <div v-for="(item, idx) in form.items" :key="idx" class="flex space-x-2 mb-2">
              <select v-model="item.product_id" class="select select-bordered flex-1">
                <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }}</option>
              </select>
              <input v-model="item.quantity" type="number" placeholder="Qty" class="input input-bordered w-20"/>
              <button type="button" class="btn btn-error btn-sm" @click="removeItem(idx)">X</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline mt-2" @click="addItem">Add Product</button>
          </div>
          <div class="flex justify-end space-x-2">
            <button type="button" class="btn btn-ghost" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary">{{ editing ? 'Update' : 'Create' }}</button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const requests = ref([]);
const suppliers = ref([]);
const products = ref([]);
const openModal = ref(false);
const editing = ref(false);
const form = ref({id:null,supplier_id:null,items:[]});

function fetchData(){
  axios.get('/api/admin/purchase-requests').then(res=>requests.value=res.data.data);
  axios.get('/api/admin/suppliers').then(res=>suppliers.value=res.data.data);
  axios.get('/api/admin/products').then(res=>products.value=res.data.data);
}

function addItem(){ form.value.items.push({product_id:null,quantity:1}); }
function removeItem(idx){ form.value.items.splice(idx,1); }

function editRequest(req){ editing.value=true; form.value={...req, items:req.items}; openModal.value=true; }
function closeModal(){ openModal.value=false; editing.value=false; form.value={id:null,supplier_id:null,items:[]}; }

function saveRequest(){
  if(editing.value) axios.put(`/api/admin/purchase-requests/${form.value.id}`,form.value).then(()=>{fetchData(); closeModal();});
  else axios.post('/api/admin/purchase-requests',form.value).then(()=>{fetchData(); closeModal();});
}

function deleteRequest(id){ if(!confirm('Are you sure?')) return; axios.delete(`/api/admin/purchase-requests/${id}`).then(fetchData); }

onMounted(fetchData);
</script>
