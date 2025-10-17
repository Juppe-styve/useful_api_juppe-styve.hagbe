<template>
  <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col space-y-3 justify-between">
    <div class="lg:flex lg:justify-between flex-col">
      <div class="flex space-x-2">
        <input
          id="default-checkbox"
          type="checkbox"
          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <div class="text-bleck text-sm font-medium">{{ module.name }}</div>
      </div>
      <p class="text-gray-500 text-sm font-medium">{{ module.description }}</p>
    </div>
    <div class="text-sm font-medium mt-3 text-green-500">actif</div>
  </div>
</template>

<script setup>
import { computed, defineProps } from 'vue'
const props = defineProps({
  module: Object,
  user_modules: Object,
})
</script>
