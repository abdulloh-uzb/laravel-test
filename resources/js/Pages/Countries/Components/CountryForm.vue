<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  country: {
    type: Object,
    default: () => ({
      id: null,
      name: '',
      capital: '',
      population: '',
      continent: 'asia'
    })
  },
  errors: {
    type: Object,
    default: () => ({})
  },
  isEditing: {
    type: Boolean,
    default: false
  }
})

const form = ref({ ...props.country })

const submit = () => {
  const url = props.isEditing 
    ? route('country.update', form.value.id)
    : route('country.store')
  
  const method = props.isEditing ? 'put' : 'post'

  router[method](url, form.value, {
    preserveScroll: true,
    onSuccess: () => {
      if (!props.isEditing) {
        // Create holati uchun formani tozalash
        form.value = {
          name: '',
          capital: '',
          population: '',
          continent: 'asia'
        }
      }
    }
  })
}
</script>

<template>
  <form @submit.prevent="submit" class="bg-white shadow-md rounded-lg p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Davlat nomi</label>
        <input
          v-model="form.name"
          id="name"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
        >
        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
      </div>

      <div>
        <label for="capital" class="block text-sm font-medium text-gray-700 mb-1">Poytaxt</label>
        <input
          v-model="form.capital"
          id="capital"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
        >
        <p v-if="errors.capital" class="mt-1 text-sm text-red-600">{{ errors.capital }}</p>
      </div>

      <div>
        <label for="population" class="block text-sm font-medium text-gray-700 mb-1">Aholi soni</label>
        <input
          v-model="form.population"
          id="population"
          type="number"
          min="0"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
        >
        <p v-if="errors.population" class="mt-1 text-sm text-red-600">{{ errors.population }}</p>
      </div>

      <div>
        <label for="continent" class="block text-sm font-medium text-gray-700 mb-1">Qit'a</label>
        <select
          v-model="form.continent"
          id="continent"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
        >
          <option value="asia">Osiyo</option>
          <option value="africa">Afrika</option>
          <option value="europe">Yevropa</option>
          <option value="north america">Shimoliy Amerika</option>
          <option value="south america">Janubiy Amerika</option>
          <option value="australia">Avstraliya</option>
        </select>
        <p v-if="errors.continent" class="mt-1 text-sm text-red-600">{{ errors.continent }}</p>
      </div>
    </div>

    <div class="mt-6">
      <button
        type="submit"
        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
      >
        {{ isEditing ? 'Oʻzgarishlarni saqlash' : 'Yangi davlat qoʻshish' }}
      </button>
    </div>
  </form>
</template>