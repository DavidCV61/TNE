<template>
  <q-page class="flex flex-center bg-grey-2">
    <q-card style="width: 400px" class="q-pa-lg shadow-10">
      <q-card-section class="text-center">
        <div class="text-h5 text-weight-bold">Iniciar Sesión</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit="handleLogin" class="q-gutter-md">

          <q-input
            v-model="email"
            label="Correo electrónico"
            type="email"
            outlined
            :rules="[
              val => !!val || 'El correo es obligatorio',
              val => /.+@.+\..+/.test(val) || 'Correo no válido'
            ]"
          />

          <q-input
            v-model="password"
            label="Contraseña"
            type="password"
            outlined
            :rules="[val => !!val || 'La contraseña es obligatoria']"
          />

          <div v-if="errorMsg" class="text-negative text-center">
            {{ errorMsg }}
          </div>

          <q-btn
            type="submit"
            label="Iniciar Sesión"
            color="primary"
            class="full-width"
            :loading="loading"
          />

        </q-form>
      </q-card-section>

      <q-card-section class="text-center">
        <span>¿No tienes cuenta? </span>
        <router-link to="/register">Regístrate aquí</router-link>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from 'src/stores/auth'

const router   = useRouter()
const authStore = useAuthStore()

const email    = ref('')
const password = ref('')
const loading  = ref(false)
const errorMsg = ref('')

async function handleLogin() {
  loading.value  = true
  errorMsg.value = ''
  try {
    await authStore.login(email.value, password.value)
    router.push('/welcome')
  } catch (error) {
    errorMsg.value = error.response?.data?.message || 'Credenciales incorrectas'
  } finally {
    loading.value = false
  }
}
</script>
