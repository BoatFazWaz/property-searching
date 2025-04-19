<template>
  <div class="min-h-[70vh] flex items-center justify-center bg-gray-50 p-4">
    <div class="text-center max-w-xl mx-auto bg-white p-10 rounded-lg shadow-xl">
      <div class="inline-block p-4 bg-indigo-50 rounded-full mb-6">
        <i class="fas fa-map-marker-alt text-3xl text-indigo-900"></i>
      </div>
      <h1 class="text-5xl font-serif font-light text-gray-800 mb-6">404</h1>
      <p class="text-xl text-gray-600 mb-8 font-light">Location not found</p>
      <p class="text-gray-500 mb-8">We couldn't find the province you're looking for. Please check the address or explore our available locations.</p>
      <router-link
        to="/"
        class="inline-block bg-gradient-to-r from-indigo-900 to-purple-900 text-white px-8 py-4 rounded-lg font-medium hover:from-indigo-800 hover:to-purple-800 transition-all duration-300 shadow-md hover:shadow-lg"
      >
        Return to Homepage
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script> 