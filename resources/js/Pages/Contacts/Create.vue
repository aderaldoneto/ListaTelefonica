<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import { ref, watch, onBeforeUnmount } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const form = useForm({
  name: '',
  email: '',
  phone: '',
  image: null,
})

function submit () {
  form.post(route('contacts.store'), { forceFormData: true })
}

// Preview da imagem escolhida
const previewUrl = ref(null)
let lastObjectUrl = null

watch(() => form.image, (file) => {
  if (lastObjectUrl) URL.revokeObjectURL(lastObjectUrl)
  previewUrl.value = file ? URL.createObjectURL(file) : null
  lastObjectUrl = previewUrl.value
})

onBeforeUnmount(() => {
  if (lastObjectUrl) URL.revokeObjectURL(lastObjectUrl)
})
</script>

<template>
  <Head title="Adicionar" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Novo contato</h2>
        <Link :href="route('contacts.index')" class="btn-secondary">Voltar</Link>
      </div>
    </template>

    <div class="mx-auto max-w-2xl p-4">
      <div class="card">
        <h1 class="mb-4 text-lg font-semibold">Preencha os dados do contato</h1>

        <form @submit.prevent="submit" enctype="multipart/form-data" class="grid gap-4">
          <!-- Nome -->
          <div>
            <label for="name" class="label">Nome</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="input"
              placeholder="Ex.: Maria Silva"
              required
              autocomplete="name"
            />
            <p v-if="form.errors.name" class="error">{{ form.errors.name }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="label">E-mail</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="input"
              placeholder="exemplo@dominio.com"
              autocomplete="email"
              required
            />
            <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
          </div>

          <!-- Telefone -->
          <div>
            <label for="phone" class="label">Telefone</label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              class="input"
              placeholder="(71) 9 9999-9999"
              autocomplete="tel"
              required
            />
            <p v-if="form.errors.phone" class="error">{{ form.errors.phone }}</p>
          </div>

          <!-- Imagem -->
          <div>
            <label for="image" class="label">Foto (opcional)</label>
            <input
              id="image"
              type="file"
              accept="image/*"
              class="block w-full text-sm file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100"
              @change="e => form.image = e.target.files[0]"
            />
            <p v-if="form.errors.image" class="error">{{ form.errors.image }}</p>

            <div v-if="previewUrl" class="mt-3 flex items-center gap-3">
              <img :src="previewUrl" alt="Pré-visualização" class="h-16 w-16 rounded-full object-cover ring-1 ring-gray-200" />
              <span class="text-sm text-gray-500">Pré-visualização</span>
            </div>
          </div>

          <!-- Ações -->
          <div class="mt-2 flex items-center gap-2">
            <button class="btn" :disabled="form.processing">
              <span v-if="!form.processing">Salvar</span>
              <span v-else>Salvando…</span>
            </button>
            <Link :href="route('contacts.index')" class="btn-secondary">Cancelar</Link>
          </div>

          <!-- Erros gerais (fallback) -->
          <div v-if="Object.keys(form.errors).length" class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            Verifique os campos acima.
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.label { @apply block text-sm font-medium text-gray-700 mb-1; }
.input { @apply w-full rounded border px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500; }
.btn { @apply rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 disabled:opacity-50; }
.btn-secondary { @apply rounded border px-3 py-2 hover:bg-gray-50; }
.card { @apply rounded border bg-white p-5 shadow-sm; }
.error { @apply mt-1 text-sm text-red-600; }
</style>
