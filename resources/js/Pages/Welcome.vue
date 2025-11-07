<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  canLogin: { type: Boolean, default: true },
  canRegister: { type: Boolean, default: true },
})
</script>

<template>
  <Head title="Agenda Telefônica" />

  <div class="min-h-screen bg-gradient-to-b from-white to-gray-50 dark:from-zinc-950 dark:to-zinc-900 text-zinc-800 dark:text-zinc-100">
    <!-- Header -->
    <header class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-2xl bg-blue-600/10 flex items-center justify-center">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V21a1 1 0 0 1-1 1C10.3 22 2 13.7 2 3a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2Z"/>
          </svg>
        </div>
        <span class="font-semibold text-lg">MyContacts</span>
      </div>

      <nav class="flex items-center gap-3">
        <template v-if="$page.props.auth?.user">
          <Link :href="route('contacts.index')" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Ir para a Agenda</Link>
        </template>
        <template v-else>
          <Link v-if="canLogin" :href="route('login')" class="px-4 py-2 rounded-lg border hover:bg-zinc-50 dark:hover:bg-zinc-800">Entrar</Link>
          <Link v-if="canRegister" :href="route('register')" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Criar conta</Link>
        </template>
      </nav>
    </header>

    <!-- Body esquerto -->
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-16 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="text-3xl md:text-5xl font-bold leading-tight">
          Organize seus contatos com <span class="text-blue-600">rapidez</span> e <span class="text-blue-600">simplicidade</span>!
        </h1>
        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-300">
          Todos os seus contatos em um só lugar.
        </p>

        <div class="mt-6 flex flex-wrap items-center gap-3">
          <Link v-if="!$page.props.auth?.user && canRegister" :href="route('register')" class="px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
            Criar conta grátis
          </Link>
          <Link v-if="!$page.props.auth?.user && canLogin" :href="route('login')" class="px-5 py-3 rounded-xl border hover:bg-zinc-50 dark:hover:bg-zinc-800">
            Já tenho conta
          </Link>
          <Link v-else :href="route('contacts.index')" class="px-5 py-3 rounded-xl border hover:bg-zinc-50 dark:hover:bg-zinc-800">
            Ver minha agenda
          </Link>
        </div>

        <ul class="mt-6 grid sm:grid-cols-2 gap-3 text-sm text-zinc-600 dark:text-zinc-300">
          <li class="flex items-center gap-2"><span class="h-2 w-2 bg-blue-600 rounded-full" />Botar algo aqui 01</li>
          <li class="flex items-center gap-2"><span class="h-2 w-2 bg-blue-600 rounded-full" />Botar algo aqui 02</li>
          <li class="flex items-center gap-2"><span class="h-2 w-2 bg-blue-600 rounded-full" />Botar algo aqui 03</li>
          <li class="flex items-center gap-2"><span class="h-2 w-2 bg-blue-600 rounded-full" />Botar algo aqui 04</li>
        </ul>
      </div>

      <!-- body direito -->
      <div class="relative">
        <div class="absolute -inset-4 rounded-3xl bg-blue-600/10 blur-2xl" />
        <div class="relative rounded-2xl border bg-white dark:bg-zinc-900 dark:border-zinc-800 shadow-xl overflow-hidden">
          <div class="px-4 py-3 border-b dark:border-zinc-800 flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-red-400"></span>
            <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
            <span class="h-3 w-3 rounded-full bg-green-400"></span>
            <span class="ml-3 text-sm text-zinc-500">Lista de Contatos</span>
          </div>

          <!-- Lista fake só para visual -->
          <div class="p-4 sm:p-6 grid gap-3">
            <div class="flex items-center gap-4 p-3 rounded-xl border dark:border-zinc-800">
              <div class="h-12 w-12 rounded-full bg-zinc-200 dark:bg-zinc-800" />
              <div class="flex-1">
                <div class="font-medium">Aderaldo Neto</div>
                <div class="text-sm text-zinc-500">aderaldo@betabit.com · (71) 99999-9999</div>
              </div>
              <div class="flex gap-2">
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Ver</span>
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Editar</span>
              </div>
            </div>

            <div class="flex items-center gap-4 p-3 rounded-xl border dark:border-zinc-800">
              <div class="h-12 w-12 rounded-full bg-zinc-200 dark:bg-zinc-800" />
              <div class="flex-1">
                <div class="font-medium">Felipe Massa</div>
                <div class="text-sm text-zinc-500">felipe_massa_@f1.com · (71) 98888-8888</div>
              </div>
              <div class="flex gap-2">
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Ver</span>
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Editar</span>
              </div>
            </div>

            <div class="flex items-center gap-4 p-3 rounded-xl border dark:border-zinc-800">
              <div class="h-12 w-12 rounded-full bg-zinc-200 dark:bg-zinc-800" />
              <div class="flex-1">
                <div class="font-medium">Michael Jackson</div>
                <div class="text-sm text-zinc-500">mj_king@king.com · (11) 98777-7777</div>
              </div>
              <div class="flex gap-2">
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Ver</span>
                <span class="px-2 py-1 text-xs rounded-lg border dark:border-zinc-800">Editar</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-sm text-zinc-500 text-center bg-zinc-100 rounded-md border border-zinc-200">
      Todos os direitos reservados © 2025
    </footer>
  </div>
</template>
