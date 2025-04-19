<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50">
    <!-- Modern Navigation Bar -->
    <header class="sticky top-0 z-50">
      <nav class="bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
          <div class="flex items-center">
            <h1 class="text-2xl font-serif tracking-wide">
              <span class="text-gradient font-bold">LUXURY</span> 
              <span class="text-gray-800">PROPERTIES</span>
            </h1>
          </div>
          
          <div class="hidden md:flex items-center space-x-8">
            <router-link to="/" class="text-gray-700 hover:text-primary transition duration-300 ease-in-out font-medium">Home</router-link>
            <router-link to="/properties" class="text-gray-700 hover:text-primary transition duration-300 ease-in-out font-medium">Properties</router-link>
            <router-link to="/about" class="text-gray-700 hover:text-primary transition duration-300 ease-in-out font-medium">About</router-link>
            <router-link to="/contact" class="text-gray-700 hover:text-primary transition duration-300 ease-in-out font-medium">Contact</router-link>
            <router-link to="/properties" class="btn-primary">
              <span class="flex items-center">
                <span>View Listings</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </span>
            </router-link>
          </div>
          
          <!-- Mobile menu button -->
          <button class="md:hidden text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </nav>
    </header>
    
    <main class="flex-grow py-6 px-4 container mx-auto">
      <router-view></router-view>
    </main>
    
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-16">
      <div class="container mx-auto px-4">
        <!-- Top footer section -->
        <div class="flex flex-col md:flex-row justify-between mb-12">
          <div class="mb-8 md:mb-0 md:w-1/3 pr-8">
            <h2 class="text-2xl font-serif mb-6 text-gradient">LUXURY PROPERTIES</h2>
            <p class="text-gray-400 mb-6 leading-relaxed">
              Discover your dream property in Thailand's most prestigious locations. Our curated collection 
              features only the finest luxury homes, condos, and villas in the most sought-after destinations.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary/80 flex items-center justify-center transition duration-300">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary/80 flex items-center justify-center transition duration-300">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary/80 flex items-center justify-center transition duration-300">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary/80 flex items-center justify-center transition duration-300">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>
          
          <div class="grid grid-cols-2 md:grid-cols-3 gap-8 md:w-2/3">
            <div>
              <h3 class="text-accent font-semibold mb-4 text-lg">Explore</h3>
              <ul class="space-y-3 text-gray-400">
                <li><router-link to="/properties" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Properties</router-link></li>
                <li><router-link to="/locations" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Locations</router-link></li>
                <li><router-link to="/investments" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Investments</router-link></li>
                <li><router-link to="/new-developments" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> New Developments</router-link></li>
              </ul>
            </div>
            <div>
              <h3 class="text-accent font-semibold mb-4 text-lg">Company</h3>
              <ul class="space-y-3 text-gray-400">
                <li><router-link to="/about" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> About Us</router-link></li>
                <li><router-link to="/team" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Our Team</router-link></li>
                <li><router-link to="/careers" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Careers</router-link></li>
                <li><router-link to="/testimonials" class="hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-accent/70"></i> Testimonials</router-link></li>
              </ul>
            </div>
            <div>
              <h3 class="text-accent font-semibold mb-4 text-lg">Contact</h3>
              <ul class="space-y-3 text-gray-400">
                <li class="flex items-start">
                  <i class="fas fa-map-marker-alt mt-1.5 mr-3 text-accent/80"></i>
                  <span>123 Sukhumvit Road<br>Bangkok, Thailand 10110</span>
                </li>
                <li class="flex items-center">
                  <i class="fas fa-phone-alt mr-3 text-accent/80"></i>
                  <span>+66 2 123 4567</span>
                </li>
                <li class="flex items-center">
                  <i class="fas fa-envelope mr-3 text-accent/80"></i>
                  <span>contact@luxuryproperties.com</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        
        <!-- Bottom footer section -->
        <div class="border-t border-gray-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-500 text-sm mb-4 md:mb-0">
            &copy; {{ new Date().getFullYear() }} Luxury Properties. All rights reserved.
          </p>
          <div class="flex space-x-6 text-sm text-gray-500">
            <router-link to="/privacy" class="hover:text-white transition duration-300">Privacy Policy</router-link>
            <router-link to="/terms" class="hover:text-white transition duration-300">Terms of Service</router-link>
            <router-link to="/cookies" class="hover:text-white transition duration-300">Cookie Policy</router-link>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script> 