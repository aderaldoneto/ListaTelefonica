<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth?.user ?? null)
</script>

<template>
  <div class="min-h-screen bg-gray-100">

    <nav class="bg-white border-b">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        
        <div class="flex items-center gap-6">
          <Link :href="route('contacts.index')" class="font-semibold hover:underline">Agenda</Link>
        </div>

       
        <div class="flex items-center gap-3">
          <span v-if="user" class="text-sm text-gray-600">Olá, <strong>{{ user.name }}</strong></span>

          <Link :href="route('profile.edit')" class="rounded border px-3 py-1 text-sm hover:bg-gray-50">
            Ver perfil
          </Link>

          <Link :href="route('logout')" method="post" as="button"
                class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
            Sair
          </Link>
        </div>
      </div>
    </nav>

    <!-- Header Novo ctt -->
    <header v-if="$slots.header" class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <!-- Conteúdo -->
    <main>
      <div class="py-6">
        <slot />
      </div>
    </main>
  </div>
</template>
