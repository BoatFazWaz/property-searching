<template>
  <div class="min-h-[80vh] flex items-center justify-center bg-gradient-to-b from-blue-50 to-indigo-50 p-4">
    <div class="text-center max-w-xl mx-auto card-glass p-12 relative overflow-hidden">
      <!-- Decorative Elements -->
      <div class="absolute -top-16 -right-16 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
      <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>
      
      <!-- Icon -->
      <div class="inline-block p-5 mb-8 bg-primary/5 rounded-full relative">
        <div class="animate-pulse absolute inset-0 rounded-full bg-primary/10 scale-125 opacity-60"></div>
        <i class="fas fa-map-marker-alt text-4xl text-primary"></i>
      </div>
      
      <!-- Content -->
      <h1 class="text-6xl font-serif font-light text-gray-800 mb-6">404</h1>
      <p class="text-2xl text-gradient font-medium mb-6">Location not found</p>
      <p class="text-gray-600 mb-10 leading-relaxed">
        We couldn't find the province you're looking for. Please check the address or explore our available locations.
      </p>
      
      <!-- Button -->
      <router-link
        to="/"
        class="btn-primary inline-flex items-center"
      >
        <i class="fas fa-home mr-2"></i> Return to Homepage
      </router-link>
      
      <!-- Decorative pattern -->
      <div class="absolute -z-10 inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(0,0,0,0.5)\'/%3E%3C/svg%3E')"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script> 