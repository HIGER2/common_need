
<script setup>
import { InertiaLink } from '@inertiajs/inertia-vue3';
import Logo from './Logo.vue';
import Logout from './Logout.vue';
import { provide } from 'vue';

const props = defineProps({
  items: Array,
  user: Object
})

</script>

<template>
  <aside class="w-full  bg-white flex items-center justify-between p-3 no-print">
    <!-- {{ user }} -->
    <div class="flex items-center gap-4">
      <div class="border-r border-zinc-200">
        <Logo/>
      </div>
      <ul class="flex items-center ">
        <template  v-for="item in items" :key="item.link">
          <li class="" v-if="!item.role || item.role === user.role">
              <a
                :href="item.link"
                class="flex items-center p-2 gap-1 rounded-box text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200 font-[500] text-[14px]"
              >
                <span v-html="item.icon"></span>
                <span class="truncate">{{ item.name }}</span>
              </a>
          </li>
        </template>
      </ul>
    </div>
    <Logout/>
  </aside>
</template>

