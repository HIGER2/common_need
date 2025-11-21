
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import TableComponent from '../components/TableComponent.vue';
import { computed, ref } from 'vue';
import AddProductComponent from '../components/AddProductComponent.vue';
const userModal = ref(null)

const openModal = () => {
  userModal.value.show()
}

const props=defineProps({
  suppliers: Array,
  products:Array
})


const columns=[
  {key:'name',label:'Name'},
  {key:'description',label:'description'},
  {key:'price',label:'price'},
  {key:'supplier',label:'Supplier'},
]
const productsCollection=computed(()=>props.products.map(p => ({
  ...p,
  supplier: p.supplier ? p.supplier.name+' '+ p.supplier.last_name : 'N/A'
})))
</script>

<template>
  <AdminLayout>
  <div>
    <header class="bg-white  border-b border-gray-200 flex justify-center items-center px-4 h-16">
      <div class="flex justify-between items-center w-full">
        <!-- Titre -->
        <h1 class="flex items-center gap-1.5 text-xl font-semibold text-highlighted truncate">
          Products
        </h1>
        <!-- Bouton -->
        <AddProductComponent :suppliers="suppliers"/>
        <button 
        onclick="my_modal_3.showModal()"
          class="px-4 py-1 btn  shrink-0 flex items-center justify-between border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md shadow-md hover:bg-primarys-700 cursor-pointer transition-colors duration-200"
      >
          + Add product
      </button>
      </div>
  </header>
    <div class="w-full p-4">
      <!-- <pre>{{ productsCollection }}</pre> -->
      <TableComponent :columns="columns" :data="productsCollection"/>
    </div>
  </div>
  </AdminLayout>
</template>

