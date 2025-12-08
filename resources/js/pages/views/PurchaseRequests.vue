
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import TableComponent from '../components/TableComponent.vue';
import { ref } from 'vue';
import AddRequestComponent from '../components/AddRequestComponent.vue';
import StatusRequestBadge from '../components/StatusRequestBadge.vue';
const userModal = ref(null)

const openModal = () => {
  userModal.value.show()
}

defineProps({
  requests: Object,
  productSelect:Array,
  budgetOfficer:Array
})

const columns=[
  {key:'reference',label:'reference'},
  {key:'total_item',label:'Items'},
  {key:'total_quantity',label:'Total quantity'},
  {key:'total_amount',label:'Total amount'},
  {key:'status',label:'status'},
  {key:'date',label:'date'},
  {key:'action',label:''},
]

</script>

<template>
  <AdminLayout>
    <header class="bg-white  border-b border-gray-200 flex justify-center items-center px-4 h-16">
      <div class="flex justify-between items-center w-full">
        <!-- Titre -->
        <h1 class="flex items-center gap-1.5 text-xl font-semibold text-highlighted truncate">
          Requests
        </h1>
        <!-- Bouton -->
        <AddRequestComponent :productSelect="productSelect" :budgetOfficer="budgetOfficer"/>
          <button 
          onclick="my_modal_3.showModal()"
            class="px-4 py-1 btn  shrink-0 flex items-center justify-between border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md shadow-md hover:bg-primarys-700 cursor-pointer transition-colors duration-200"
        >
            + New request
        </button>
      </div>
  </header>
    <div class="w-full p-4">
      <!-- <pre>{{ requests }}</pre> -->
      <TableComponent :columns="columns" :data="requests">
        <template #action="{row}">
          <a :href="`/requests/${row?.uuid}`" class="p-2 text-xl">
            <i class="uil uil-info-circle"></i>
          </a>
         </template>
         <template #status="{row}">
            <StatusRequestBadge :status="row.status" />
         </template>
      </TableComponent>
    </div>
  </AdminLayout>
</template>

