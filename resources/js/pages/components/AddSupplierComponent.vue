
<script lang="ts" setup>
import { Form } from '@inertiajs/vue3'

const fields=[
    [
        {type:"text", require:true,placeholder:'Name',label:"Name", key:'name'},
        {type:"text", require:true,placeholder:'Last name',label:"Last name", key:'last_name'},
    ],
    [
        {type:"text", require:true,placeholder:'Email',label:"Email", key:'email'},
    ],
    [
        {type:"text", require:true,placeholder:'Phone',label:"Phone", key:'phone'},
    ],
    [
        {type:"text", require:false,placeholder:'Adress',label:"Adress", key:'address'},
    ],
]
</script>


<template>
  <div>
    
    <dialog id="my_modal_3" class="modal">
    <div class="modal-box !w-200 ">
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <Form
         action="/api/admin/suppliers/store" 
        method="post"
        :options="{
            preserveScroll: true,
            preserveState: true,
            preserveUrl: true,
            replace: true,
            only: ['suppliers'],
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
            <h3 class="text-lg font-bold">Add Supplier</h3>
            <div class="w-full">
                <div v-if="wasSuccessful" role="alert" class="alert  alert-success alert-soft">
                    <span class="text-center">Supplier created successfully!</span>
                </div>
                <div 
                v-for="field in fields"
                class="flex w-full items-end gap-2">
                    <fieldset 
                    v-for="value in field"
                    class="fieldset w-full">
                        <legend class="fieldset-legend">
                            {{ value.label }}
                        </legend>
                        <input :required="value.require" type="text" :name="value.key" class="input w-full" :placeholder="value.placeholder" />
                    </fieldset>
                </div>
                <button 
                    class="px-4 w-full mt-5 text-center py-1 btn  shrink-0  border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md   cursor-pointer "
                >
                    {{ processing ? 'Creating...' : 'Create Supplier' }}
                </button>
            </div>
        </Form>
    </div>
    </dialog>
  </div>
</template>

<style>

</style>