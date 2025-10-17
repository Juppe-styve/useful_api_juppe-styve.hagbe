<script setup>
import { useUserStore } from '@/stores/user'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loginPage = () => {
  router.push('/login')
}
//user store
const userStore = useUserStore()
const name = ref('')
const name_error = ref(false)
const email = ref('')
const email_error = ref(false)
const password = ref('')
const password_error = ref(false)
const password_confirmation = ref('')
const password_confirmation_error = ref(false)

const handleRegister = async () => {
  console.log('helle')
  const countError = ref(0)
  if (!name.value || name.value.length == 0) {
    countError.value++
    name_error.value = true
  }
  if (!email.value || email.value.length == 0) {
    countError.value++
    email_error.value = true
  }
  if (!password.value || password.value.length == 0) {
    countError.value++
    password_error.value = true
  }
  if (!password_confirmation.value || password.value != password_confirmation.value) {
    countError.value++
    password_confirmation_error.value = true
  }
  if (countError.value > 0) {
    return
  }
  const data = await userStore.register(name.value, email.value, password.value)
  if (data) {
    router.push('/login')
  }
}
</script>

<template>
  <div class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >
            Create an account
          </h1>
          <form class="flex flex-col space-y-4 md:space-y-8" @submit.prevent="handleRegister">
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your name</label
              >
              <input
                v-model.trim="name"
                type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p class="text-red-500 text-[12px]" v-if="name_error">Name field is required</p>
            </div>
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your email</label
              >
              <input
                v-model.trim="email"
                type="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p class="text-red-500 text-[12px]" v-if="email_error">Email field is required</p>
            </div>
            <div>
              <label
                for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Password</label
              >
              <input
                v-model.trim="password"
                type="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p class="text-red-500 text-[12px]" v-if="password_error">
                Password field is required
              </p>
            </div>
            <div>
              <label
                for="confirm-password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Confirm password</label
              >
              <input
                type="password"
                v-model.trim="password_confirmation"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p class="text-red-500 text-[12px]" v-if="password_error">
                Password confimation must match password
              </p>
            </div>
            <button
              type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            >
              Create an account
            </button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Already have an account?
              <a
                href="#"
                @click="loginPage"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                >Login here</a
              >
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
