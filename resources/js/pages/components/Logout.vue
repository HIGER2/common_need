<template>
  <button 
    @click="handleLogout" 
    :disabled="processing"
    class="px-4 py-1  cursor-pointer text-primarys  border btn-soft  btn border-gray-200 rounded "
  >
  <i class="uil uil-signout"></i>
    {{ processing ? 'Logging out...' : 'Logout' }}
  </button>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'

const processing = ref(false)

const handleLogout = () => {
  processing.value = true
  Inertia.post('/logout', {}, {
    onSuccess: () => {
      // Redirige vers login
    //   Inertia.visit('/auth/login')
    },
    onError: (errors) => {
      console.error(errors)
      alert('Logout failed')
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
