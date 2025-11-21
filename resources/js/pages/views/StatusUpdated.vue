<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-10 rounded-lg shadow-lg text-center max-w-md">
      <h1 class="text-2xl font-bold mb-4">{{ message }}</h1>
      <p class="mb-2">Reference: <strong>{{ reference }}</strong></p>
      <p>Status: <strong>{{ status }}</strong></p>
      <!-- <a href="/" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Go Home</a> -->
    </div>
  </div>
</template>

<script setup>
defineProps({
  message: String,
  reference: String,
  status: String
})
</script>

<style scoped>
</style>
