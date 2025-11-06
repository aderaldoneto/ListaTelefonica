<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  contact: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 py-10">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100">
        Detalhes do Contato
      </h1>

      <div class="flex gap-2">
        <Link
          :href="route('contacts.index')"
          class="rounded-lg border px-4 py-2 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800"
        >
          Voltar
        </Link>
      </div>
    </div>

    <!-- Card principal -->
    <div
      class="rounded-2xl border bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
    >
      <div class="flex flex-col sm:flex-row sm:items-center gap-6">
        <div class="flex-shrink-0">
          <img
            v-if="contact.image_url"
            :src="contact.image_url"
            alt="Foto do contato"
            class="h-32 w-32 rounded-full object-cover ring-4 ring-zinc-100 dark:ring-zinc-800"
          />
          <div
            v-else
            class="h-32 w-32 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-4xl text-zinc-400"
          >
            <span>{{ contact.name.charAt(0).toUpperCase() }}</span>
          </div>
        </div>

        <div class="flex-1">
          <h2 class="text-xl font-semibold mb-2">
            {{ contact.name }}
          </h2>
          <p class="text-zinc-600 dark:text-zinc-300">
            <span v-if="contact.email">📧 {{ contact.email }}</span><br />
            <span v-if="contact.phone">📞 {{ contact.phone }}</span>
          </p>
          <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">
            Criado em: {{ new Date(contact.created_at).toLocaleString('pt-BR') }}
          </p>
        </div>
      </div>
    </div>

    <!-- Ações -->
    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-end">
      <Link
        :href="route('contacts.edit', contact.id)"
        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700"
      >
        Editar contato
      </Link>

      <form
        :action="route('contacts.destroy', contact.id)"
        method="post"
        @submit.prevent="(e) => e.target.submit()"
        class="inline"
      >
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="_token" :value="$page.props.csrf_token" />
        <button
          type="submit"
          class="inline-flex items-center justify-center rounded-lg bg-red-600 px-5 py-2 text-white hover:bg-red-700"
        >
          Excluir
        </button>
      </form>
    </div>
  </div>
</template>
