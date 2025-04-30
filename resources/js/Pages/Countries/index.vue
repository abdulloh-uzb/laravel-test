<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  countries: Array
})

const search = ref('')
const filteredCountries = computed(() => {
  const q = search.value.toLowerCase()
  return props.countries.filter(c =>
    c.name.toLowerCase().includes(q) || c.capital.toLowerCase().includes(q)
  )
})

function deleteCountry(id) {
  if (confirm('Rostdan ham o‘chirmoqchimisiz?')) {
    router.delete(route("country.destroy", id))
  }
}

function createCountry() {
  router.get(route("country.create"))
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-bold text-gray-800">
          Davlatlar ro'yxati
      </h2>
    </template>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <input
          v-model="search"
          type="text"
          placeholder="Qidirish..."
          class="border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
        />
        <a href="/country/create"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Yangi Davlat
        </a>
      </div>
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Davlat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poytaxt</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(country, index) in filteredCountries" :key="country.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ country.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ country.capital }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <a :href="`/country/${country.id}/edit`" class="text-indigo-600 hover:text-indigo-900 mr-4">Tahrirlash</a>
                  <button @click="deleteCountry(country.id)" class="text-red-600 hover:text-red-900">O'chirish</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
