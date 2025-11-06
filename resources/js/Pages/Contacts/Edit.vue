<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({ name:'', email:'', phone:'', image:null })

function submit(){
  form.post(route('contacts.store'), { forceFormData: true })
}
</script>

<template>
  <div class="max-w-lg mx-auto p-4">
    <h1 class="text-xl font-semibold mb-4">Novo Contato</h1>

    <form @submit.prevent="submit" enctype="multipart/form-data" class="grid gap-3">
      <input v-model="form.name" placeholder="Nome" class="input" />
      <input v-model="form.email" placeholder="Email" class="input" />
      <input v-model="form.phone" placeholder="Telefone" class="input" />
      <input type="file" @change="e => form.image = e.target.files[0]" accept="image/*" />

      <button class="btn" :disabled="form.processing">Salvar</button>
    </form>

    <div v-if="form.errors" class="text-red-600 mt-2">
      <div v-for="(m,k) in form.errors" :key="k">{{ m }}</div>
    </div>
  </div>
</template>
