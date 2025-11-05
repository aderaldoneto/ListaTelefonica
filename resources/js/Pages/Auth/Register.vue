<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const showPassword = ref(false)
const showPasswordConfirm = ref(false)
const capsOnPwd = ref(false)
const capsOnPwd2 = ref(false)

const onKeyPwd = (e) => { if (e.getModifierState) capsOnPwd.value = e.getModifierState('CapsLock') }
const onKeyPwd2 = (e) => { if (e.getModifierState) capsOnPwd2.value = e.getModifierState('CapsLock') }

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Criar conta" />

    <div class="min-h-[calc(100vh-6rem)] grid place-items-center px-4">
      <div class="w-full max-w-md">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
          <!-- Header -->
          <div class="mb-6 text-center">
            <h1 class="text-xl font-semibold">Criar sua conta</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Comece a organizar seus contatos agora mesmo.</p>
          </div>

          <form @submit.prevent="submit" class="grid gap-4">
            <!-- Nome -->
            <div>
              <InputLabel for="name" value="Nome" />
              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
                placeholder="Seu nome completo"
              />
              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
              <InputLabel for="email" value="E-mail" />
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
                placeholder="seuemail@exemplo.com"
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Senha -->
            <div>
              <InputLabel for="password" value="Senha" />
              <div class="mt-1 relative">
                <TextInput
                  id="password"
                  :type="showPassword ? 'text' : 'password'"
                  class="block w-full pe-11"
                  v-model="form.password"
                  required
                  autocomplete="new-password"
                  placeholder="••••••••"
                  @keydown="onKeyPwd" @keyup="onKeyPwd"
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
              <p v-if="capsOnPwd" class="mt-2 text-xs text-amber-600 dark:text-amber-400">Caps Lock ativado</p>
              <InputError class="mt-2" :message="form.errors.password" />
              <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Mínimo recomendado: 8+ caracteres, combine letras e números.</p>
            </div>

            <!-- Confirmar senha -->
            <div>
              <InputLabel for="password_confirmation" value="Confirmar senha" />
              <div class="mt-1 relative">
                <TextInput
                  id="password_confirmation"
                  :type="showPasswordConfirm ? 'text' : 'password'"
                  class="block w-full pe-11"
                  v-model="form.password_confirmation"
                  required
                  autocomplete="new-password"
                  placeholder="Repita a senha"
                  @keydown="onKeyPwd2" @keyup="onKeyPwd2"
                />
                <button
                  type="button"
                  class="absolute inset-y-0 right-0 grid w-10 place-items-center text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200"
                  @click="showPasswordConfirm = !showPasswordConfirm"
                  :aria-label="showPasswordConfirm ? 'Ocultar confirmação' : 'Mostrar confirmação'"
                >
                  <svg v-if="!showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
              <p v-if="capsOnPwd2" class="mt-2 text-xs text-amber-600 dark:text-amber-400">Caps Lock ativado</p>
              <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Ações -->
            <div class="mt-2 grid gap-3">
              <PrimaryButton
                class="w-full justify-center"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
              >
                <span v-if="!form.processing">Criar conta</span>
                <span v-else class="inline-flex items-center gap-2">
                  <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                  </svg>
                  Criando...
                </span>
              </PrimaryButton>

              <div class="text-center text-sm text-zinc-600 dark:text-zinc-300">
                Já tem conta?
                <Link :href="route('login')" class="text-blue-600 hover:underline dark:text-blue-400">
                  Entrar
                </Link>
              </div>
            </div>
          </form>
        </div>

        <p class="mt-4 text-center text-xs text-zinc-500 dark:text-zinc-400">
          Ao criar a conta, você concorda com os nossos Termos, Politicas de Privacidade e Politicas de Cookies. 
        </p>
      </div>
    </div>
  </GuestLayout>
</template>
