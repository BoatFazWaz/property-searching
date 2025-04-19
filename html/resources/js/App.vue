<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <nav class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white p-4 shadow-xl">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-serif tracking-wide">
          <span class="text-yellow-400">LUXURY</span> PROPERTIES
        </h1>
        <div class="hidden md:flex space-x-6 font-light">
          <a href="/" class="hover:text-yellow-400 transition duration-300">Home</a>
          <a href="#" class="hover:text-yellow-400 transition duration-300">About</a>
          <a href="#" class="hover:text-yellow-400 transition duration-300">Contact</a>
        </div>
      </div>
    </nav>
    
    <div class="py-10 px-4 container mx-auto">
      <router-view></router-view>
    </div>
    
    <footer class="bg-gray-900 text-white py-10">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between">
          <div class="mb-6 md:mb-0">
            <h2 class="text-xl font-serif mb-4">LUXURY PROPERTIES</h2>
            <p class="text-gray-400">Discover your dream property in Thailand's most desirable locations.</p>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
            <div>
              <h3 class="text-yellow-400 font-semibold mb-3">Explore</h3>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition duration-300">Properties</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Locations</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Investments</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-yellow-400 font-semibold mb-3">Company</h3>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition duration-300">About Us</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Our Team</a></li>
                <li><a href="#" class="hover:text-white transition duration-300">Careers</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-yellow-400 font-semibold mb-3">Contact</h3>
              <ul class="space-y-2 text-gray-400">
                <li>contact@luxuryproperties.com</li>
                <li>+66 2 123 4567</li>
                <li>Bangkok, Thailand</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-10 pt-6 text-gray-500 text-sm text-center">
          &copy; {{ new Date().getFullYear() }} Luxury Properties. All rights reserved.
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