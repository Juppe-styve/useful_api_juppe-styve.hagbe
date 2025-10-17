<template>
  <aside
    :class="[
      'bg-slate-800 text-white fixed lg:static z-40 inset-y-0 left-0 transform transition-transform duration-300 w-64 min-h-screen p-6 space-y-6',
      isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
    ]"
  >
    <div class="flex items-center justify-between lg:block">
      <h1 class="text-2xl font-bold tracking-wide">MODULES</h1>
      <button
        @click="$emit('toggle')"
        class="lg:hidden text-white hover:text-red-400 focus:outline-none"
      >
        ✕
      </button>
    </div>

    <nav class="flex text-sm flex-col space-y-3 mt-6">
      <div v-for="module in modules">
        <div class="flex hover:bg-slate-700 p-2 space-x-4 rounded-md text-gray-300">
          <span class="">{{ module.name }}</span>
        </div>
      </div>
    </nav>
  </aside>
</template>

<script setup>
const props = defineProps({
  isOpen: Boolean,
  modules: Object,
  user_modules: Object,
})
</script>
