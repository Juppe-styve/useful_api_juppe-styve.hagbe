<script setup>
import { useUserStore } from '@/stores/user'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const registerPage = () => {
  router.push('/register')
}
//user store
const userStore = useUserStore()
const email = ref('')
const email_error = ref(false)
const password = ref('')
const password_error = ref(false)
const countError = ref(0)

const handleLogin = async () => {
  if (!email.value || email.value.length == 0) {
    countError.value++
    email_error.value = true
  }
  if (!password.value || password.value.length == 0) {
    countError.value++
    password_error.value = true
  }
  if (countError.value > 0) {
    return
  }
  const data = await userStore.login(email.value, password.value)
  if (data) {
    //redirect to dash
  }
}
</script>

<template>
  <form class="max-w-sm mx-auto" @submit.prevent="handleLogin">
    <div class="mb-5">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >Your email</label
      >
      <input
        v-model="email"
        type="email"
        id="email"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      />
      <p class="text-red-500 text-[12px]" v-if="email_error">Email field is required</p>
    </div>
    <div class="mb-5">
      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >Your password</label
      >
      <input
        v-model="password"
        type="password"
        id="password"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      />
      <p class="text-red-500 text-[12px]" v-if="password_error">Email field is required</p>
    </div>

    <button
      type="submit"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
      Submit
    </button>
    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
      Don't have account ?
      <a
        href="#"
        @click="registerPage"
        class="font-medium text-primary-600 hover:underline dark:text-primary-500"
        >Register here</a
      >
    </p>
  </form>
</template>
