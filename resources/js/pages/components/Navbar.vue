<template>
  <header class="bg-white border-b border-gray-200 flex justify-between items-center px-4 h-16">
    <div class="font-bold text-lg">Dashboard</div>
    <div class="flex items-center space-x-4">
      <span>Douma</span>
      <button class="btn btn-sm btn-error" @click="logout">Logout</button>
    </div>
  </header>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';


function logout() {
  Inertia.post('/logout');
}
</script>
