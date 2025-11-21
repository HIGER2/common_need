<template>
<div class="w-full h-screen flex items-center justify-center">
    <div class="min-w-md">
        
        <!-- LOGO -->
        <div class="flex justify-center mb-4">
           <Logo/>
        </div>

        <h1 class="text-2xl font-bold mb-2 text-center ">Enter Your OTP Code</h1>

        <p class="mb-3 text-center text-gray-600">{{ email }}</p>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label>OTP Code</label>
                <input
                    v-model="form.otp"
                    type="text"
                    placeholder="Enter your OTP"
                    class="w-full input border p-2 rounded"
                />
                <div v-if="form.errors.otp" class="text-red-500 text-sm mt-1">
                    {{ form.errors.otp }}
                </div>
            </div>

            <button
                type="submit"
                class="bg-primarys text-white px-4 py-2 rounded hover:bg-primarys-dark cursor-pointer w-full transition"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Sending...' : 'Verify OTP' }}
            </button>
        </form>
    </div>
</div>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import Logo from '../components/Logo.vue'

const email = new URLSearchParams(window.location.search).get('email')

const form = useForm({
  email: email,
  otp: ''
})

function submit() {
  form.post('/auth/verify-otp')
}
</script>
