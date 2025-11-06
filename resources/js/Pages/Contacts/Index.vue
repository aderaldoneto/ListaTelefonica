<script setup>
import { router, Link, Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  contacts: { type: Object, required: true }, // paginator (data, links, etc.)
  filters: { type: Object, default: () => ({}) },
})

const q = ref(props.filters.q ?? '')

// Busca com debounce
let t
watch(q, (val) => {
  clearTimeout(t)
  t = setTimeout(() => {
    router.get(route('contacts.index'), { q: val }, { preserveState: true, replace: true })
  }, 300)
})

// Excluir
function destroyContact(id) {
  if (confirm('Tem certeza que deseja excluir este contato?')) {
    router.delete(route('contacts.destroy', id), { preserveScroll: true })
  }
}

// Paginação SPA
function go(link) {
  if (!link.url || link.active) return
  router.get(link.url, {}, { preserveState: true, replace: true })
}
</script>

<template>
  <Head title="Agenda" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Minha agenda
        </h2>
        <Link :href="route('contacts.create')" class="btn">Novo contato</Link>
      </div>
    </template>

    <div class="mx-auto max-w-5xl p-4">
      <!-- Top bar de busca -->
      <div class="flex items-center justify-between gap-2">
        <input
          v-model="q"
          placeholder="Buscar por nome, e-mail ou telefone"
          class="input"
        />
      </div>

      <!-- Mobile: cards -->
      <div class="mt-4 grid gap-3 sm:hidden">
        <article v-for="c in props.contacts.data" :key="c.id" class="card">
          <header class="flex items-center gap-3">
            <img
              v-if="c.image_url"
              :src="c.image_url"
              class="h-12 w-12 rounded-full object-cover"
              alt=""
            />
            <div>
              <h3 class="font-semibold">{{ c.name }}</h3>
              <p class="text-sm text-gray-500">
                <span v-if="c.phone">{{ c.phone }}</span>
                <span v-if="c.email && c.phone"> · </span>
                <span v-if="c.email">{{ c.email }}</span>
              </p>
            </div>
          </header>

          <footer class="mt-3 flex gap-2">
            <Link :href="route('contacts.show', c.id)" class="btn-secondary">Ver</Link>
            <Link :href="route('contacts.edit', c.id)" class="btn-secondary">Editar</Link>
            <button @click="destroyContact(c.id)" class="btn-danger">Excluir</button>
          </footer>
        </article>

        <div v-if="!props.contacts.data?.length" class="text-center text-sm text-gray-500">
          Nenhum contato encontrado.
        </div>
      </div>

      <!-- Desktop: tabela -->
      <div class="mt-4 hidden sm:block">
        <table class="w-full border-collapse">
          <thead>
            <tr class="text-left text-sm text-gray-600">
              <th class="py-2">Imagem</th>
              <th class="py-2">Nome</th>
              <th class="py-2">E-mail</th>
              <th class="py-2">Telefone</th>
              <th class="w-48 py-2">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="c in props.contacts.data" :key="c.id" class="border-t">
              <td class="py-2">
                <img v-if="c.image_url" :src="c.image_url" class="h-10 w-10 rounded-full object-cover" alt="" />
              </td>
              <td class="py-2 font-medium">{{ c.name }}</td>
              <td class="py-2">{{ c.email }}</td>
              <td class="py-2">{{ c.phone }}</td>
              <td class="py-2">
                <div class="flex flex-wrap gap-2">
                  <Link :href="route('contacts.show', c.id)" class="link">Ver</Link>
                  <Link :href="route('contacts.edit', c.id)" class="link">Editar</Link>
                  <button @click="destroyContact(c.id)" class="text-red-600 hover:underline">Excluir</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="!props.contacts.data?.length" class="py-6 text-center text-sm text-gray-500">
          Nenhum contato encontrado.
        </div>
      </div>

      <!-- Paginação -->
      <div class="mt-4 flex flex-wrap items-center gap-2" v-if="props.contacts.links?.length">
        <a
          v-for="l in props.contacts.links"
          :key="l.label + String(l.active)"
          href="#"
          @click.prevent="go(l)"
          :class="[
            'px-3 py-1 border rounded text-sm',
            l.active ? 'bg-gray-200' : 'hover:bg-gray-50'
          ]"
          v-html="l.label"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.input{ @apply w-full rounded border px-3 py-2; }
.btn{ @apply rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700; }
.btn-secondary{ @apply rounded border px-3 py-1 hover:bg-gray-50; }
.btn-danger{ @apply rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700; }
.card{ @apply rounded border p-3; }
.link{ @apply text-blue-600 hover:underline; }
</style>
