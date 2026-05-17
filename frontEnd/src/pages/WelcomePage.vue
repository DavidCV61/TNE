<template>
  <q-page class="flex flex-center bg-grey-2">
    <q-card style="width: 450px" class="q-pa-xl shadow-10 text-center">

      <q-icon name="account_circle" size="80px" color="primary" />

      <div class="text-h4 text-weight-bold q-mt-md">
        ¡Bienvenidx {{ authStore.userName }}!
      </div>

      <div class="text-h6 text-grey-7 q-mt-sm">
        Tu rol es <strong class="text-primary">{{ authStore.userRole }}</strong>
      </div>

      <q-separator class="q-my-lg" />

      <div class="text-body1 text-grey-6">
        Correo: {{ authStore.user?.email }}
      </div>

      <q-btn
        label="Cerrar Sesión"
        color="negative"
        outline
        class="q-mt-xl"
        icon="logout"
        @click="handleLogout"
        :loading="loading"
      />

    </q-card>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from 'src/stores/auth'

const router    = useRouter()
const authStore = useAuthStore()
const loading   = ref(false)

onMounted(async () => {
  if (!authStore.user) {
    await authStore.fetchUser()
  }
})

async function handleLogout() {
  loading.value = true
  await authStore.logout()
  router.push('/login')
}
</script>
