<template>
  <div>
    <!-- Hero Section -->
    <div class="relative overflow-hidden mb-24">
      <!-- Background -->
      <div class="absolute inset-0 z-0">
        <img 
          src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2053&q=80" 
          alt="Luxury Properties" 
          class="w-full h-full object-cover brightness-75"
        >
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 pt-32 pb-40 px-4 max-w-6xl mx-auto">
        <div class="max-w-3xl">
          <h1 class="text-4xl md:text-6xl font-serif font-light mb-6 text-white leading-tight animate-fadeIn">
            Discover Exceptional <span class="text-accent">Luxury Living</span>
          </h1>
          <p class="text-xl md:text-2xl font-light text-white/90 max-w-2xl mb-10 animate-slideUp">
            Explore Thailand's finest properties in the most prestigious locations
          </p>
          <div class="flex flex-wrap gap-4">
            <a href="#properties" class="btn-primary">
              Browse Properties
            </a>
            <a href="#" class="btn-outline text-white border-white/30 hover:bg-white/10">
              Learn More
            </a>
          </div>
        </div>
      </div>

      <!-- Wave divider -->
      <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" class="w-full h-auto fill-current text-blue-50">
          <path d="M0,32L80,42.7C160,53,320,75,480,74.7C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
        </svg>
      </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-16 card-glass p-8 max-w-6xl mx-auto -mt-40 relative z-10">
      <div class="flex flex-col lg:flex-row gap-6">
        <!-- Search Input -->
        <div class="flex-1">
          <label class="block text-gray-700 text-sm font-medium mb-2">Search Properties</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <i class="fas fa-search text-gray-400"></i>
            </span>
            <input
              type="text"
              v-model="searchQuery"
              @input="handleSearch"
              placeholder="Search by title or location..."
              class="input-modern w-full pl-10"
            >
          </div>
        </div>
        
        <!-- Filter by Province Dropdown -->
        <div class="w-full lg:w-48">
          <label class="block text-gray-700 text-sm font-medium mb-2">Location</label>
          <div class="relative">
            <select
              v-model="selectedProvince"
              @change="handleProvinceChange"
              class="select-modern w-full"
            >
              <option value="">All Locations</option>
              <option v-for="province in provinces" :key="province" :value="province">
                {{ province }}
              </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <i class="fas fa-chevron-down text-xs"></i>
            </div>
          </div>
        </div>
        
        <!-- Sort Dropdown -->
        <div class="w-full lg:w-48">
          <label class="block text-gray-700 text-sm font-medium mb-2">Sort By</label>
          <div class="relative">
            <select
              v-model="sortBy"
              @change="handleSort"
              class="select-modern w-full"
            >
              <option value="created_at-desc">Newest First</option>
              <option value="created_at-asc">Oldest First</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <i class="fas fa-chevron-down text-xs"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="properties" class="-mt-6"></div>

    <!-- Properties Section Title -->
    <div class="text-center mb-12">
      <h2 class="text-3xl font-serif mb-4">Featured Properties</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">Explore our handpicked selection of Thailand's most exceptional properties</p>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-32">
      <div class="relative w-24 h-24">
        <div class="absolute top-0 left-0 w-full h-full rounded-full border-4 border-gray-200"></div>
        <div class="absolute top-0 left-0 w-full h-full rounded-full border-4 border-t-primary animate-spin"></div>
      </div>
    </div>

    <!-- No Results -->
    <div v-else-if="properties.length === 0" class="text-center py-32 px-4">
      <div class="inline-block p-6 rounded-full bg-gray-100 text-gray-500 mb-6">
        <i class="fas fa-search text-4xl"></i>
      </div>
      <h3 class="text-2xl font-serif font-light mb-3">No properties found</h3>
      <p class="text-gray-500 max-w-md mx-auto mb-8">We couldn't find any properties that match your search criteria. Try adjusting your filters or search terms.</p>
      <button @click="resetFilters" class="btn-primary">
        Reset Filters
      </button>
    </div>

    <!-- Properties Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
      <div v-for="property in properties" :key="property.id" class="property-card group rounded-2xl overflow-hidden animate-float">
        <div class="relative">
          <!-- Property Badge -->
          <div class="absolute top-4 right-4 z-10">
            <span v-if="property.for_sale" class="property-badge">For Sale</span>
            <span v-else class="property-badge bg-secondary/90">For Rent</span>
          </div>

          <!-- Property Image -->
          <div class="relative h-64 overflow-hidden">
            <img 
              :src="getPropertyImage(property)" 
              :alt="property.title" 
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300"></div>
          </div>
          
          <!-- Quick Info Overlay -->
          <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
            <div class="flex justify-between items-center">
              <span class="text-2xl font-bold">{{ property.currency_symbol }}{{ formatPrice(property.price) }}</span>
              <div class="flex space-x-3 text-white/90">
                <span class="flex items-center">
                  <i class="fas fa-bed mr-1"></i> {{ property.bedrooms }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-bath mr-1"></i> {{ property.bathrooms }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-ruler-combined mr-1"></i> {{ property.area }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Property Details -->
        <div class="p-6">
          <h3 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-1 group-hover:text-primary transition-colors duration-300">
            {{ property.title }}
          </h3>
          
          <p class="text-primary/80 mb-3 text-sm flex items-center">
            <i class="fas fa-map-marker-alt mr-2"></i>
            <router-link :to="'/' + property.province" class="hover:text-primary transition duration-300">
              {{ property.province }}
            </router-link>
          </p>
          
          <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ property.description }}</p>
          
          <!-- View details button -->
          <button class="w-full py-3 mt-2 text-center border border-primary/30 rounded-xl text-primary font-medium hover:bg-primary hover:text-white transition-all duration-300">
            View Details
          </button>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="properties.length > 0" class="mt-16 mb-24 flex justify-center">
      <nav class="flex flex-wrap gap-2">
        <button
          v-if="currentPage > 1"
          @click="handlePageChange(currentPage - 1)"
          class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors duration-300 shadow-sm"
        >
          <i class="fas fa-chevron-left mr-1"></i> Previous
        </button>
        
        <button
          v-for="page in paginationPages"
          :key="page"
          @click="handlePageChange(page)"
          :class="[
            'px-5 py-2.5 rounded-xl border transition-colors duration-300 shadow-sm',
            currentPage === page
              ? 'bg-primary text-white border-primary'
              : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'
          ]"
        >
          {{ page }}
        </button>
        
        <button
          v-if="currentPage < totalPages"
          @click="handlePageChange(currentPage + 1)"
          class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors duration-300 shadow-sm"
        >
          Next <i class="fas fa-chevron-right ml-1"></i>
        </button>
      </nav>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'PropertyList',
  setup() {
    const properties = ref([]);
    const provinces = ref([]);
    const searchQuery = ref('');
    const sortBy = ref('created_at-desc');
    const currentPage = ref(1);
    const totalPages = ref(1);
    const loading = ref(true);
    const selectedProvince = ref('');
    const route = useRoute();
    const router = useRouter();

    // Property images by type
    const propertyImages = {
      house: [
        'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1600607687644-c7f34c32d2c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      villa: [
        'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      condo: [
        'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1560448204-603b3fc33ddc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      apartment: [
        'https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      penthouse: [
        'https://images.unsplash.com/photo-1600585154526-990dced4db0d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1503174971373-b1f69850bded?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1606046604972-77cc76aee944?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      beach: [
        'https://images.unsplash.com/photo-1615571022219-eb45cf7faa9d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1518684079-3c830dcef090?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      pool: [
        'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ]
    };

    // Locations with specific images
    const locationImages = {
      'Bangkok': [
        'https://images.unsplash.com/photo-1563492065599-3520f775eeed?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1508009603885-50cf7c8dd0d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      'Phuket': [
        'https://images.unsplash.com/photo-1589394815804-964ed0be2eb5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1548567117-02328f050edc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ],
      'Chiang Mai': [
        'https://images.unsplash.com/photo-1553150590-bb0a91f2867d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
        'https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
      ]
    };

    // Default fallback images
    const defaultImages = [
      'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
      'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80',
      'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80'
    ];

    // Get a specific image for a property
    const getPropertyImage = (property) => {
      // If property already has an image, use it
      if (property.photo_search) {
        return property.photo_search;
      }

      // Get images based on property type
      let imagePool = [];

      // Check property type first
      const propertyType = property.property_type ? property.property_type.toLowerCase() : '';
      
      if (propertyType && propertyImages[propertyType]) {
        imagePool = imagePool.concat(propertyImages[propertyType]);
      }
      
      // Add location-specific images if available
      if (property.province && locationImages[property.province]) {
        imagePool = imagePool.concat(locationImages[property.province]);
      }
      
      // Add specific features
      if (property.description) {
        const desc = property.description.toLowerCase();
        if (desc.includes('beach') || desc.includes('sea') || desc.includes('ocean')) {
          imagePool = imagePool.concat(propertyImages.beach);
        }
        if (desc.includes('pool') || desc.includes('swimming')) {
          imagePool = imagePool.concat(propertyImages.pool);
        }
      }
      
      // If no specific images, use default
      if (imagePool.length === 0) {
        imagePool = defaultImages;
      }
      
      // Deterministic selection based on property id to ensure consistency
      const index = property.id % imagePool.length;
      return imagePool[index];
    };

    // Calculate pagination pages (show max 5 pages)
    const paginationPages = computed(() => {
      if (totalPages.value <= 5) {
        return Array.from({ length: totalPages.value }, (_, i) => i + 1);
      }
      
      let start = Math.max(1, currentPage.value - 2);
      let end = Math.min(totalPages.value, start + 4);
      
      if (end - start < 4) {
        start = Math.max(1, end - 4);
      }
      
      return Array.from({ length: end - start + 1 }, (_, i) => start + i);
    });

    const fetchProperties = async () => {
      loading.value = true;
      try {
        const params = {
          page: currentPage.value,
          for_sale: 1, // Only show properties for sale
          include_sold: 0, // Exclude sold properties
        };

        if (searchQuery.value) {
          params.search = searchQuery.value;
        }

        if (selectedProvince.value) {
          params.province = selectedProvince.value;
        } else if (route.params.province) {
          params.province = route.params.province;
          selectedProvince.value = route.params.province;
        }

        if (sortBy.value) {
          const [field, direction] = sortBy.value.split('-');
          params.sort_by = field;
          params.sort_direction = direction;
        }

        const response = await axios.get('/api/properties', { params });
        properties.value = response.data.data;
        totalPages.value = Math.ceil(response.data.total / response.data.per_page);
      } catch (error) {
        console.error('Error fetching properties:', error);
      } finally {
        loading.value = false;
      }
    };

    const fetchProvinces = async () => {
      try {
        const response = await axios.get('/api/properties/provinces');
        provinces.value = response.data;
      } catch (error) {
        console.error('Error fetching provinces:', error);
      }
    };

    const handleSearch = () => {
      currentPage.value = 1;
      fetchProperties();
    };

    const handleSort = () => {
      currentPage.value = 1;
      fetchProperties();
    };

    const handlePageChange = (page) => {
      currentPage.value = page;
      fetchProperties();
      
      // Scroll to top
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    };
    
    const handleProvinceChange = () => {
      currentPage.value = 1;
      
      if (selectedProvince.value) {
        router.push('/' + selectedProvince.value);
      } else {
        router.push('/');
      }
    };
    
    const formatPrice = (price) => {
      return price.toLocaleString();
    };

    const resetFilters = () => {
      searchQuery.value = '';
      selectedProvince.value = '';
      sortBy.value = 'created_at-desc';
      currentPage.value = 1;
      fetchProperties();
      if (route.params.province) {
        router.push('/');
      }
    };

    watch(() => route.params.province, (newProvince) => {
      selectedProvince.value = newProvince || '';
      currentPage.value = 1;
      fetchProperties();
    });

    onMounted(() => {
      fetchProvinces();
      fetchProperties();
    });

    return {
      properties,
      provinces,
      searchQuery,
      sortBy,
      currentPage,
      totalPages,
      loading,
      selectedProvince,
      paginationPages,
      handleSearch,
      handleSort,
      handlePageChange,
      handleProvinceChange,
      formatPrice,
      resetFilters,
      getPropertyImage,
    };
  },
};
</script>

<style scoped>
.property-card {
  transition: all 0.3s ease;
}

.property-card:hover {
  transform: translateY(-5px);
}
</style>
 