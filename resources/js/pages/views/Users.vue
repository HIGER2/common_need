
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import TableComponent from '../components/TableComponent.vue';
import ModalComponent from '../components/ModalComponent.vue';
import { ref } from 'vue';
import AddUserComponent from '../components/AddUserComponent.vue';
import { useComposables } from '../../composables';
const userModal = ref(null)

defineProps({
  users: Object
})

const { useUser } = useComposables()

const handleAddUser = async (userData) => {
  // await useUser().AddUser(userData);
}
const openModal = () => {
  userModal.value.show()
}

const columns=[
  {key:'name',label:'Name'},
  {key:'last_name',label:'last name'},
  {key:'email',label:'email'},
  {key:'role',label:'role'},
]
</script>


<template>
  <AdminLayout>
    <header class="bg-white  border-b border-gray-200 flex justify-center items-center px-4 h-16">
      <div class="flex justify-between items-center w-full">
        <!-- Titre -->
         
        <h1 class="flex items-center gap-1.5 text-[17px] font-semibold text-highlighted truncate">Users</h1>
        <!-- Bouton -->
        <AddUserComponent @handleAddUser="handleAddUser"/>
        <button 
        onclick="my_modal_3.showModal()"
          class="px-4 py-1 btn  shrink-0 flex items-center justify-between border-b border-default  sm:px-6 gap-1.5 bg-primarys text-[15px] text-white font-medium rounded-md shadow-md hover:bg-primarys-700 cursor-pointer transition-colors duration-200"
      >
          + New User 
      </button>
      </div>
  </header>
   
    
    <div class="w-full p-4">
      <!-- <pre>{{ users.length }}</pre>
      <pre>{{ users }}</pre> -->
      <TableComponent :columns="columns" :data="users"/>
    </div>
  </AdminLayout>
</template>

