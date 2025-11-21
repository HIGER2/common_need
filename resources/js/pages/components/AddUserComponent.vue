
<script lang="ts" setup>
import { reactive } from 'vue';
import { Form } from '@inertiajs/vue3'

const emit = defineEmits(['handleAddUser']);

const newUser = reactive({
    name: 'dqwdwq',
    last_name: 'qweqwewq',
    email: 'dqwdwq@qweqwe.com',
    role: 'Requester'
});
const options =[
    {label:'Requester',value:'Requester'},
    {label:'BudgetOfficer',value:'BudgetOfficer'},
    {label:'LiaisonOfficer',value:'LiaisonOfficer'},
    {label:'Vendor',value:'Vendor'},
    {label:'Finance',value:'Finance'},
]
const submitForm = () => {
    emit('handleAddUser', { ...newUser });
    // Reset form fields
    // newUser.name = '';
    // newUser.last_name = '';
    // newUser.email = '';
};
</script>

<template>
  <div>
    
    <dialog id="my_modal_3" class="modal">
    <div class="modal-box !w-200 ">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <Form  
        action="/api/admin/users/create" 
        method="post"
        :options="{
            preserveScroll: true,
            preserveState: true,
            preserveUrl: true,
            replace: true,
            only: ['users'],
            except: ['secret'],
            reset: ['page'],
        }"
        #default="{
            errors,
            hasErrors,
            processing,
            progress,
            wasSuccessful,
            recentlySuccessful,
            setError,
            clearErrors,
            resetAndClearErrors,
            defaults,
            isDirty,
            reset,
            submit,
        }"
        >
            <h3 class="text-lg font-bold">Add User</h3>
            <div class="w-full">
                <div v-if="wasSuccessful" role="alert" class="alert  alert-success alert-soft">
                    <span class="text-center">User created successfully!</span>
                </div>
                <div class="flex w-full items-end gap-2">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">Name</legend>
                        <input  required type="text" name="name" class="input" placeholder="Type here" />
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">Last name</legend>
                        <input  required type="text" name="last_name" class="input" placeholder="Type here" />
                    </fieldset>
                </div>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Email</legend>
                    <input  required type="text" name="email" class="input w-full" placeholder="Type here" />
                </fieldset>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Role</legend>
                    <select value="Requester"  class="select w-full" name="role">
                        <option disabled selected>Select role</option>
                        <option 
                            v-for="(option,index) in options"
                            :value="option.value"
                            :key="index">
                            {{ option.label }}
                        </option>
                    </select>
                </fieldset>
                
                <button 
                @click.prevent="submit({ onSuccess: () => reset() })"
                type="submit"
                class="px-4 w-full mt-5 text-center py-1 btn  shrink-0  border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md   cursor-pointer "
                >
                {{ processing ? 'Creating...' : 'Create User' }}
                </button>
            </div>
        </Form>
    </div>
    </dialog>
  </div>
</template>


<style>

</style>