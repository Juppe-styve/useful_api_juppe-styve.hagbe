import { defineStore, acceptHMRUpdate } from 'pinia'
import { ref } from 'vue'

export const useUserStore = defineStore(
  'user',
  () => {
    const user = ref({})
    const user_id = ref(null)
    const token = ref('')
    const API_BASE = import.meta.env.VITE_API_URL
    const register = async (name, email, password) => {
      const formdata = new FormData()
      formdata.append('name', `${name}`)
      formdata.append('email', `${email}`)
      formdata.append('password', `${password}`)
      const response = await fetch(`${API_BASE}/register`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
        },
        body: formdata,
      })
      if (!response.ok) {
        console.warn('erreur')
        return false
      } else {
        user.value = response.json()
        return true
      }
    }
    const login = async (email, password) => {
      const formdata = new FormData()
      formdata.append('email', `${email}`)
      formdata.append('password', `${password}`)
      const response = await fetch(`${API_BASE}/login`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
        },
        body: formdata,
      })
      if (!response.ok) {
        console.warn('erreur')
        return false
      } else {
        const data = await response.json()
        user_id.value = data.user_id
        token.value = data.token
        return true
      }
    }
    return {
      user,
      token,
      user_id,
      register,
      login,
    }
  },
  {
    persist: {
      key: 'user',
    },
  },
)

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}
