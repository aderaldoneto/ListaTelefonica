<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
  canResetPassword: { type: Boolean, default: true },
  status: { type: String, default: '' },
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Entrar" />

    <div class="min-h-[calc(100vh-6rem)] grid place-items-center px-4">
      <div class="w-full max-w-md">
        <!-- Card -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
          <!-- Logo + título -->
          <div class="mb-6 flex items-center justify-center gap-3">
            <div class="h-10 w-10 rounded-2xl bg-blue-600/10 text-blue-700 dark:text-blue-400 grid place-items-center">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V21a1 1 0 0 1-1 1C10.3 22 2 13.7 2 3a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2Z"/>
              </svg>
            </div>
            <h1 class="text-xl font-semibold">Entrar na Agenda</h1>
          </div>

          <!-- Status de email de redefinição, etc -->
          <div v-if="status" class="mb-4 rounded-lg bg-green-50 px-4 py-2 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-300">
            {{ status }}
          </div>

          <form @submit.prevent="submit" class="grid gap-4">
            <!-- Email -->
            <div>
              <InputLabel for="email" value="E-mail" />
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autofocus
                autocomplete="username"
                placeholder="email@exemplo.com"
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Senha -->
            <div>
              <div class="flex items-center justify-between">
                <InputLabel for="password" value="Senha" />
                <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                >Esqueci minha senha</Link>
              </div>

              <div class="mt-1 relative">
                <TextInput
                  :id="'password'"
                  :type="showPassword ? 'text' : 'password'"
                  class="block w-full pe-11"
                  v-model="form.password"
                  required
                  autocomplete="current-password"
                  @keydown="onKey"
                  @keyup="onKey"
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  class="absolute inset-y-0 right-0 grid w-10 place-items-center text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200"
                  @click="showPassword = !showPassword"
                  :aria-label="showPassword ? 'Ocultar senha' : 'Mostrar senha'"
                >
                  <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178.07.214.07.43 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="m3 3 18 18M9.88 9.88A3 3 0 0 0 12 15a3 3 0 0 0 2.12-.88M6.228 6.228C4.31 7.56 2.97 9.34 2.036 11.678a1.012 1.012 0 0 0 0 .644C3.423 16.49 7.36 19.5 12 19.5c1.53 0 2.986-.3 4.304-.84M9.88 9.88 6.228 6.228M14.12 14.12 17.772 17.772" />
                  </svg>
                </button>
              </div>

              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Lembrar-me -->
            <label class="mt-1 flex items-center gap-2">
              <Checkbox name="remember" v-model:checked="form.remember" />
              <span class="text-sm text-zinc-600 dark:text-zinc-300">Lembrar de mim</span>
            </label>

            <!-- Ações -->
            <div class="mt-2 grid gap-3">
              <PrimaryButton
                class="w-full justify-center"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
              >
                <span v-if="!form.processing">Entrar</span>
                <span v-else class="inline-flex items-center gap-2">
                  <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                  </svg>
                  Entrando...
                </span>
              </PrimaryButton>

              <div class="text-center text-sm text-zinc-600 dark:text-zinc-300">
                Não tem conta?
                <Link :href="route('register')" class="text-blue-600 hover:underline dark:text-blue-400">
                  Criar conta
                </Link>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </GuestLayout>
</template>
