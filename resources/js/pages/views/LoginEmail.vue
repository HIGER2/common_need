<template>
<div class="w-screen h-screen flex items-center justify-center">
    <div class="min-w-md mt-20 p-6  rounded  bg-white">
        
        <!-- LOGO WITH LINK -->
        <div class="flex justify-center mb-6">
           <Logo/>
        </div>

        <!-- TITLE -->
        <h1 class="text-2xl font-bold mb-6 text-center">Login with Email</h1>

        <form @submit.prevent="submit">
            <!-- EMAIL INPUT -->
            <div class="mb-4">
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Email</legend>
                    <input
                        required
                        type="email"
                        v-model="form.email"
                        placeholder="Enter your email"
                        class="input w-full border p-2 rounded"
                    />
                </fieldset>

                <!-- Validation Error -->
                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button
                type="submit"
                class="bg-primarys text-white px-4 py-2 rounded hover:bg-primarys-dark cursor-pointer w-full transition"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Sending...' : 'Send OTP' }}
            </button>
        </form>

        <!-- Success message -->
        <div v-if="successMessage" class="text-green-500 mt-4 text-center">
            {{ successMessage }}
        </div>
    </div>
</div>

</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Logo from '../components/Logo.vue'

const form = useForm({
  email: ''
})

const successMessage = ref('')

// Fonction submit
function submit() {
  form.post('/auth/send-otp', {
    onSuccess: (page) => {
      // Inertia::location() fera la redirection vers /otp
      successMessage.value = 'OTP envoyé avec succès !'
    },
    onError: (errors) => {
      console.log('Erreurs envoyées par Laravel:', errors)
    }
  })
}
</script>

<style scoped>
/* Optionnel pour un style plus propre */
/* input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 1px #2563eb;
} */
</style>
