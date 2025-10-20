
<script setup>
import { InertiaLink } from '@inertiajs/inertia-vue3';
const props = defineProps({
  items: Array
});
</script>

<template>
  <aside class="w-64 bg-white border-r border-gray-200 p-3">
    <div class="font-bold w-35">
      <img src="https://static.wixstatic.com/media/0839e4_7910df264aee46ba85347ab33684d739~mv2_d_4782_1488_s_2.png/v1/fill/w_520,h_160,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/0839e4_7910df264aee46ba85347ab33684d739~mv2_d_4782_1488_s_2.png" alt="Logo" 
      class="w-full object-contain">
    </div>
    <ul class="mt-4 w-full">
    <li v-for="item in items" :key="item.link" class="my-2">
      <a
        :href="item.link"
        class="flex items-center gap-2 p-2 rounded-lg text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200 font-[500] text-[14px]"
      >
        <span v-html="item.icon"></span>
        <span class="truncate">{{ item.name }}</span>
      </a>
  </li>

    </ul>
  </aside>
</template>

