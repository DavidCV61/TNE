<template>
  <q-page class="flex flex-center bg-grey-2">
    <q-card style="width: 420px" class="q-pa-lg shadow-10">
      <q-card-section class="text-center">
        <div class="text-h5 text-weight-bold">Crear Cuenta</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit="handleRegister" class="q-gutter-md">

          <q-input
            v-model="name"
            label="Nombre completo"
            outlined
            :rules="[val => !!val || 'El nombre es obligatorio']"
          />

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
            :rules="[
              val => !!val || 'La contraseña es obligatoria',
              val => val.length >= 8 || 'Mínimo 8 caracteres'
            ]"
          />

          <q-input
            v-model="passwordConfirmation"
            label="Confirmar contraseña"
            type="password"
            outlined
            :rules="[
              val => !!val || 'Confirma tu contraseña',
              val => val === password || 'Las contraseñas no coinciden'
            ]"
          />

          <div v-if="errorMsg" class="text-negative text-center">
            {{ errorMsg }}
          </div>

          <div v-if="successMsg" class="text-positive text-center">
            {{ successMsg }}
          </div>

          <q-btn
            type="submit"
            label="Registrarse"
            color="positive"
            class="full-width"
            :loading="loading"
          />

        </q-form>
      </q-card-section>

      <q-card-section class="text-center">
        <span>¿Ya tienes cuenta? </span>
        <router-link to="/login">Inicia sesión</router-link>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from 'src/stores/auth'

const router    = useRouter()
const authStore = useAuthStore()

const name                 = ref('')
const email                = ref('')
const password             = ref('')
const passwordConfirmation = ref('')
const loading              = ref(false)
const errorMsg             = ref('')
const successMsg           = ref('')

async function handleRegister() {
  loading.value  = true
  errorMsg.value = ''
  successMsg.value = ''
  try {
    await authStore.register(name.value, email.value, password.value, passwordConfirmation.value)
    successMsg.value = 'Cuenta creada :) Redirigiendo al login'
    setTimeout(() => router.push('/login'), 1500)
  } catch (error) {
    const errors = error.response?.data?.errors
    if (errors) {
      errorMsg.value = Object.values(errors).flat().join(' ')
    } else {
      errorMsg.value = error.response?.data?.message || 'Error al registrar'
    }
  } finally {
    loading.value = false
  }
}
</script>
