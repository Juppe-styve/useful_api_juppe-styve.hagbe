<template>
  <main class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <SidebarComponent
      :is-open="sidebarOpen"
      @toggle="toggleSidebar"
      :user_modules="modulesStore.user_modules"
    />

    <!-- Contenu principal -->
    <section class="flex-1 flex flex-col transition-all duration-300">
      <!-- Header (mobile only) -->
      <header class="bg-white shadow-sm p-4 flex items-center justify-between lg:hidden">
        <button
          @click="toggleSidebar"
          class="text-gray-700 hover:text-indigo-600 focus:outline-none"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
        <h1 class="font-semibold text-gray-800 text-lg">Dashboard</h1>
      </header>

      <!-- Contenu principal -->
      <section class="p-6 flex-1 space-y-8">
        <p>Listes des modules</p>
        <div class="grid grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4">
          <StatsCard
            :module="module"
            :user_modules="modulesStore.user_modules"
            v-for="module in modulesStore.modules"
          />
        </div>
      </section>
    </section>
  </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import SidebarComponent from '@/components/Dashboard/SidebarComponent.vue'
import StatsCard from '@/components/Dashboard/StatsCard.vue'
import { useModuleStore } from '@/stores/module'
const sidebarOpen = ref(false)
const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value
}
const modulesStore = useModuleStore()
onMounted(async () => {
  await modulesStore.getModules()
  await modulesStore.getUserModules()
})
</script>
