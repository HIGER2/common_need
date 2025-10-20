<template>
  <div>
    
    <dialog id="my_modal_3" class="modal">
    <div class="modal-box !w-200 ">
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Add Supplier</h3>
        <div class="w-full">
            <div class="flex w-full items-end gap-2">
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Name</legend>
                    <input type="text" class="input" placeholder="Type here" />
                </fieldset>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Last name</legend>
                    <input type="text" class="input" placeholder="Type here" />
                </fieldset>
            </div>
            <div class="flex w-full items-end gap-2">
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Phone</legend>
                    <input type="text" class="input" placeholder="Type here" />
                </fieldset>
                <fieldset class="fieldset w-full">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="text" class="input" placeholder="Type here" />
                </fieldset>
            </div>
            <fieldset class="fieldset w-full">
                <legend class="fieldset-legend">Adress</legend>
                <input type="text" class="input w-full" placeholder="Type here" />
            </fieldset>

            <button 
                class="px-4 w-full mt-5 text-center py-1 btn  shrink-0  border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md   cursor-pointer "
            >
                Submit
            </button>
        </div>
    </div>
    </dialog>
  </div>
</template>

<script lang="ts" setup>

</script>

<style>

</style>