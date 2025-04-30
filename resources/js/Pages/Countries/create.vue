<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CountryForm from './Components/CountryForm.vue'

</script>

<template>
  <AuthenticatedLayout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Yangi davlat qo'shish</h1>
      <CountryForm />
    </div>
  </AuthenticatedLayout>
</template>