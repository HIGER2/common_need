
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import TableComponent from '../components/TableComponent.vue';
import { ref } from 'vue';
import AddSupplierComponent from '../components/AddSupplierComponent.vue';
const userModal = ref(null)

const openModal = () => {
  userModal.value.show()
}

defineProps({
  suppliers: Object
})


const columns=[
  {key:'name',label:'Name'},
  {key:'last_name',label:'last name'},
  {key:'email',label:'email'},
  {key:'phone',label:'phone'},
  {key:'phone',label:'phone'},
]

</script>

<template>
  <AdminLayout>
    <header class="bg-white  border-b border-gray-200 flex justify-center items-center px-4 h-16">
      <div class="flex justify-between items-center w-full">
        <!-- Titre -->
        <h1 class="flex items-center gap-1.5 text-[17px] font-semibold text-highlighted truncate">Suppliers</h1>
        <!-- Bouton -->
        <AddSupplierComponent/>
        <button 
        onclick="my_modal_3.showModal()"
          class="px-4 py-1 btn  shrink-0 flex items-center justify-between border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md shadow-md hover:bg-primarys-700 cursor-pointer transition-colors duration-200"
      >
          + Supplier
      </button>
      </div>
  </header>
    <div class="w-full p-4">
      <!-- <pre>{{ suppliers }}</pre> -->
      <TableComponent :columns="columns" :data="suppliers"/>
    </div>
  </AdminLayout>
</template>

