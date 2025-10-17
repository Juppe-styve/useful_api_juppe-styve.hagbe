<template>
  <main class="flex min-h-screen bg-gray-100 flex-col lg:flex-row">
    <!-- Sidebar -->
    <SidebarComponent :is-open="sidebarOpen" @toggle="toggleSidebar" />

    <!-- Contenu principal -->
    <section
      class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-all duration-300"
    >
      <!-- Header mobile -->
      <header
        class="bg-white shadow-sm p-4 flex items-center justify-between mb-6 lg:hidden"
      >
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

      <!-- Contenu dynamique -->
      <slot />
    </section>
  </main>
</template>

<script setup>
import SidebarComponent from "./SidebarComponent.vue";
</script>
