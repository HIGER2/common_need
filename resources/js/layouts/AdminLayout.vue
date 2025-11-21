<template>
  <div class="flex  flex-col print:min-h-screen print:bg-white h-screen bg-zinc-100">
    <Sidebar  :user :items="menuItems" />
    <div class="flex-1 overflow-auto p-2 print:overflow-visible">
      <main class="w-full print:min-h-screen h-full bg-white  shadow print:overflow-visible print:shadow-none  overflow-hidden rounded-2xl p-3">
        <div class="w-full print:min-h-screen h-full overflow-auto print:overflow-visible">
          <slot :user />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../pages/components/Navbar.vue';
import Sidebar from '../pages/components/Sidebar.vue';
import { usePage } from '@inertiajs/vue3'
import { computed, provide } from 'vue';
const menuItems = [ 
    {
      name: 'Requests',
      role: 'Requester',
      link: '/',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" viewBox="0 0 24 24">
      <path fill="currentColor" d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8 8a2 2 0 0 0 2.828 0l7.172-7.172a2 2 0 0 0 0-2.828l-8-8zM7 9a2 2 0 1 1 .001-4.001A2 2 0 0 1 7 9z"/>
  </svg>`
    },
    
    {
      name: 'Orders',
      link: '/purchase-orders',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" viewBox="0 0 24 24">
      <path fill="currentColor" d="m17.275 20.25l3.475-3.45l-1.05-1.05l-2.425 2.375l-.975-.975l-1.05 1.075l2.025 2.025ZM6 9h12V7H6v2Zm12 14q-2.075 0-3.538-1.463T13 18q0-2.075 1.463-3.538T18 13q2.075 0 3.538 1.463T23 18q0 2.075-1.463 3.538T18 23ZM3 22V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v6.675q-.475-.225-.975-.375T19 11.075V5H5v14.05h6.075q.125.775.388 1.475t.687 1.325L12 22l-1.5-1.5L9 22l-1.5-1.5L6 22l-1.5-1.5L3 22Zm3-5h5.075q.075-.525.225-1.025t.375-.975H6v2Zm0-4h7.1q.95-.925 2.213-1.463T18 11H6v2Zm-1 6.05V5v14.05Z"/>
  </svg>`
    },
    {
      name: 'Products',
      link: '/products',
      role: 'Requester',
      icon: `<svg xmlns="http://www.w3.org/2000/svg"class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" viewBox="0 0 512 512">
      <path fill="currentColor" fill-rule="evenodd" d="m256 34.347l192 110.851v221.703L256 477.752L64 366.901V145.198zm-64.001 206.918L192 391.536l42.667 24.635V265.899zM106.667 192v150.267l42.666 24.635V216.633zm233.324-59.894l-125.578 72.836L256 228.952l125.867-72.669zM256 83.614l-125.867 72.67l41.662 24.052l125.579-72.835z"/>
  </svg>`
    },
    
  //   {
  //     name: 'Purchase Approvals',
  //     link: '/purchase-approvals',
  //     icon: `<svg xmlns="http://www.w3.org/2000/svg"  class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" viewBox="0 0 32 32">
  //     <path fill="currentColor" d="M15.629.512a1.5 1.5 0 1 0-2.258 1.976l1.375 1.572C8.155 4.69 3 10.243 3 17c0 7.18 5.82 13 13 13s13-5.82 13-13v-.5a1.5 1.5 0 1 0-3 0v.5c0 5.523-4.477 10-10 10S6 22.523 6 17c0-5.051 3.745-9.228 8.61-9.904l-1.239 1.416a1.5 1.5 0 1 0 2.258 1.976l3.5-4a1.5 1.5 0 0 0 0-1.976l-3.5-4Zm6.98 11.979a1.5 1.5 0 0 1-.1 2.119l-5.5 5a1.5 1.5 0 0 1-2.07-.05l-2.5-2.5a1.5 1.5 0 0 1 2.122-2.12l1.488 1.488l4.442-4.038a1.5 1.5 0 0 1 2.119.101Z"/>
  // </svg>`
  //   },
  
    {
      name: 'Suppliers',
      link: '/suppliers',
      role: 'Requester',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
        <path d="M16 11c1.656 0 3-1.344 3-3s-1.344-3-3-3-3 1.344-3 3 1.344 3 3 3zm-8 0c1.656 0 3-1.344 3-3S9.656 5 8 5 5 6.344 5 8s1.344 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05c1.16.84 1.97 2.02 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
      </svg>`
    },
    {
      name: 'Users',
      link: '/users',
      role: 'Requester',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primarys group-hover:text-gray-700 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 12c2.7 0 4-1.8 4-4s-1.3-4-4-4-4 1.8-4 4 1.3 4 4 4zm0 2c-2.7 0-8 1.3-8 4v2h16v-2c0-2.7-5.3-4-8-4z"/>
      </svg>`
    },
];

const page = usePage()

const user = computed(() => page.props.auth.user)
provide('user', user);

</script>


<style>
@media print {
   div, section {
    page-break-inside: avoid; /* évite de couper un bloc au milieu */
    /* page-break-before: always; */
     /* force un saut de page */

  }
   .force-page-break {
    page-break-before: always; /* force un saut de page */
  }
  .no-print {
    display: none !important;
  }
  table {
    page-break-inside: auto;
    width: 100% !important;
  }

  tr {
    page-break-inside: avoid;
    page-break-after: auto;
  }

  thead {
    display: table-header-group; /* pour répéter les en-têtes sur chaque page */
  }

  tbody {
    display: table-row-group;
  }
}

</style>