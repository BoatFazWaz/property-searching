<template>
  <div class="card-glass p-10 my-8 min-h-[50vh] flex flex-col justify-start">
    <h1 class="text-4xl font-serif mb-6">About Us</h1>
    <p class="text-lg mb-4">Luxury Properties is Thailand's premier real estate agency specializing in high-end properties across the most desirable locations in the country.</p>
    <p class="mb-4">Founded in 2010, our team of experienced professionals is dedicated to providing exceptional service and finding the perfect property for our discerning clients.</p>
    <p class="mb-6">Our extensive portfolio includes luxury villas, penthouses, beachfront properties, and exclusive developments in Bangkok, Phuket, Koh Samui, Chiang Mai, and other prestigious locations.</p>
    
    <div class="mt-auto pt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center p-6 bg-white/50 rounded-xl">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary/10 flex items-center justify-center">
          <i class="fas fa-gem text-primary text-xl"></i>
        </div>
        <h3 class="font-serif text-xl mb-2">Luxury Selection</h3>
        <p class="text-gray-600">Only the finest properties that meet our strict quality standards</p>
      </div>
      
      <div class="text-center p-6 bg-white/50 rounded-xl">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary/10 flex items-center justify-center">
          <i class="fas fa-handshake text-primary text-xl"></i>
        </div>
        <h3 class="font-serif text-xl mb-2">Personalized Service</h3>
        <p class="text-gray-600">Tailored approach to meet each client's unique requirements</p>
      </div>
      
      <div class="text-center p-6 bg-white/50 rounded-xl">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary/10 flex items-center justify-center">
          <i class="fas fa-globe-asia text-primary text-xl"></i>
        </div>
        <h3 class="font-serif text-xl mb-2">Local Expertise</h3>
        <p class="text-gray-600">Deep knowledge of Thailand's most exclusive locations</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutPage'
}
</script> 