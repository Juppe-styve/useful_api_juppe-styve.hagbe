import { acceptHMRUpdate, defineStore } from 'pinia'
import { ref } from 'vue'
import { useUserStore } from './user'

export const useModuleStore = defineStore(
  'modules',
  () => {
    const modules = ref([])
    const user_modules = ref([])
    const API_BASE = import.meta.env.VITE_API_URL
    const user = useUserStore()
    const token = user.token

    const getModules = async () => {
      const response = await fetch(`${API_BASE}/modules`, {
        method: 'GET',
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${token}`,
        },
      })
      if (!response.ok) {
        console.warn('erreur')
        return
      } else {
        const data = await response.json()
        modules.value = data.data
      }
    }
    const getUserModules = async () => {
      const response = await fetch(`${API_BASE}/user/modules`, {
        method: 'GET',
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${token}`,
        },
      })
      if (!response.ok) {
        console.warn('erreur')
        return
      } else {
        const data = await response.json()
        user_modules.value = data
      }
    }

    return {
      modules,
      user_modules,
      getModules,
      getUserModules,
    }
  },
  {
    persist: {
      key: 'modules',
    },
  },
)

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useModuleStore, import.meta.hot))
}
