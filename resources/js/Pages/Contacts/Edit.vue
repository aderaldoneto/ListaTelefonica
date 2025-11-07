<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import { ref, watch, onBeforeUnmount } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { sanitizePhoneInput } from '@/Composables/usePhoneInput'

const props = defineProps({
  contact: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  name: props.contact.name ?? '',
  email: props.contact.email ?? '',
  phone: props.contact.phone ?? '',
  image: null, 
  _remove_image: false,
})

function submit() {
  form.transform(data => ({ ...data, _method: 'PUT' }))
  form.post(route('contacts.update', props.contact.id), {
    preserveScroll: true,
    forceFormData: true,
  })
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

// Quando marcar em remover imagem, limpar o file e o preview
watch(() => form._remove_image, (val) => {
  if (val) {
    form.image = null
    if (lastObjectUrl) {
      URL.revokeObjectURL(lastObjectUrl)
      lastObjectUrl = null
    }
    previewUrl.value = null
  }
})

function onPhoneInput(e) {
  e.target.value = sanitizePhoneInput(e.target.value)
  form.phone = e.target.value
}
</script>

<template>
  <Head title="Editar" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Editar contato
        </h2>
        <div class="flex gap-2">
          <Link :href="route('contacts.index')" class="btn-secondary">Voltar</Link>
        </div>
      </div>
    </template>

    <div class="mx-auto max-w-2xl p-4">
      <div class="card">
        <h1 class="mb-4 text-lg font-semibold">Atualize os dados do contato</h1>

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
              required
              autocomplete="email"
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
              required
              autocomplete="tel"
              @input="onPhoneInput"
            />
            <p v-if="form.errors.phone" class="error">{{ form.errors.phone }}</p>
          </div>

          <!-- Img + opções -->
          <div>
            <label class="label">Foto</label>

            <div v-if="props.contact.image_url && !form._remove_image && !previewUrl" class="flex items-center gap-3">
              <img :src="props.contact.image_url" alt="Imagem atual"
                   class="h-16 w-16 rounded-full object-cover ring-1 ring-gray-200" />
              <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" v-model="form._remove_image" />
                Remover foto atual
              </label>
            </div>

            <input
              id="image"
              type="file"
              accept="image/*"
              class="mt-2 block w-full text-sm file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-700 hover:file:bg-blue-100"
              @change="e => form.image = e.target.files[0]"
              :disabled="form._remove_image"
            />
            <p v-if="form.errors.image" class="error">{{ form.errors.image }}</p>

            <div v-if="previewUrl" class="mt-3 flex items-center gap-3">
              <img :src="previewUrl" alt="Pré-visualização"
                   class="h-16 w-16 rounded-full object-cover ring-1 ring-gray-200" />
              <span class="text-sm text-gray-500">Nova imagem selecionada</span>
            </div>
          </div>

          <!-- Ações -->
          <div class="mt-2 flex items-center gap-2">
            <button class="btn" :disabled="form.processing">
              <span v-if="!form.processing">Salvar alterações</span>
              <span v-else>Salvando…</span>
            </button>
            <Link :href="route('contacts.index')" class="btn-secondary">Cancelar</Link>
          </div>

          <!-- Erros -->
          <div v-if="Object.keys(form.errors).length"
               class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
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
