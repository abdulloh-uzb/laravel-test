<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CountryForm from './Components/CountryForm.vue'


const props = defineProps({
  country: Object,
  errors: Object
})

const form = ref({
  name: props.country.name,
  capital: props.country.capital,
  population: props.country.population,
  continent: props.country.continent
})

const submit = () => {
  router.put(route('country.update', props.country.id), form.value, {
    preserveScroll: true,
  })
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Davlatni tahrirlash</h1>
        <CountryForm :country="country" :errors="errors" is-editing />
        </div>
    </AuthenticatedLayout>

</template>