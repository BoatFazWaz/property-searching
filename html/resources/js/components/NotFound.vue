<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
      <p class="text-xl text-gray-600 mb-8">Page not found</p>
      <router-link
        to="/"
        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700"
      >
        Go back home
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script> 