<template>
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead class="">
        <tr>
          <th>#</th>
          <th v-for="col in columns" :key="col.key">{{ col.label }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="hover:bg-base-300">
          <th>{{ rowIndex + 1 }}</th>
          <td v-for="col in columns" :key="col.key">
            <slot :name="col.key" :row="row">
              {{ row[col.key] }}
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  columns: {
    type: Array,
    default: () => [
      { key: 'name', label: 'Name' },
      { key: 'job', label: 'Job' },
      { key: 'favoriteColor', label: 'Favorite Color' }
    ]
  },
  data: {
    type: Array,
    default: () => [
      { name: 'Cy Ganderton', job: 'Quality Control Specialist', favoriteColor: 'Blue' },
      { name: 'Hart Hagerty', job: 'Desktop Support Technician', favoriteColor: 'Purple' },
      { name: 'Brice Swyre', job: 'Tax Accountant', favoriteColor: 'Red' }
    ]
  }
})
</script>
