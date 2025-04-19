<template>
  <div>
    <!-- Hero Section -->
    <div class="relative bg-gray-900 text-white mb-16">
      <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2053&q=80" alt="Luxury Properties" class="w-full h-64 md:h-96 object-cover mix-blend-overlay">
      <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-3xl md:text-5xl font-serif font-light mb-4">Discover Luxury Living</h1>
        <p class="text-xl md:text-2xl font-light opacity-90 max-w-2xl">Exceptional properties in Thailand's most prestigious locations</p>
      </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-12 bg-white rounded-lg shadow-xl p-8 max-w-6xl mx-auto -mt-24 relative z-10">
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
              class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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
              class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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
              class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-900"></div>
    </div>

    <!-- No Results -->
    <div v-else-if="properties.length === 0" class="text-center py-20">
      <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
      <h3 class="text-xl text-gray-600 font-light">No properties found</h3>
      <p class="mt-2 text-gray-500">Try adjusting your search criteria</p>
    </div>

    <!-- Properties Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
      <div v-for="property in properties" :key="property.id" class="relative group bg-white rounded-lg shadow-lg overflow-hidden property-card hover:shadow-2xl transition-all duration-300">
        <div class="absolute top-4 right-4 z-10">
          <span v-if="property.for_sale" class="bg-indigo-900 text-white text-xs uppercase tracking-wider font-medium px-3 py-1 rounded-full">For Sale</span>
          <span v-else class="bg-purple-700 text-white text-xs uppercase tracking-wider font-medium px-3 py-1 rounded-full">For Rent</span>
        </div>
        <div class="relative">
          <img :src="property.photo_search" :alt="property.title" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105">
          <div class="absolute inset-0 bg-black opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
        </div>
        <div class="p-6">
          <div class="flex justify-between">
            <h3 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-1">{{ property.title }}</h3>
          </div>
          
          <p class="text-indigo-600 mb-2 text-sm">
            <i class="fas fa-map-marker-alt mr-1"></i>
            <router-link :to="'/' + property.province" class="hover:text-indigo-800 transition duration-300">
              {{ property.province }}
            </router-link>
          </p>
          
          <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ property.description }}</p>
          
          <div class="border-t border-gray-100 pt-4 mt-4">
            <div class="flex justify-between items-center">
              <span class="text-2xl font-bold text-indigo-900">{{ property.currency_symbol }}{{ formatPrice(property.price) }}</span>
              <div class="flex space-x-4 text-gray-500">
                <span class="flex items-center">
                  <i class="fas fa-bed mr-1"></i> {{ property.bedrooms }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-bath mr-1"></i> {{ property.bathrooms }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-ruler-combined mr-1"></i> {{ property.area }} {{ property.area_type }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="properties.length > 0" class="mt-12 mb-16 flex justify-center">
      <nav class="flex flex-wrap gap-2">
        <button
          v-if="currentPage > 1"
          @click="handlePageChange(currentPage - 1)"
          class="px-4 py-2 rounded-md bg-white border border-gray-300 text-indigo-600 hover:bg-indigo-50 transition-colors duration-300"
        >
          <i class="fas fa-chevron-left mr-1"></i> Previous
        </button>
        
        <button
          v-for="page in paginationPages"
          :key="page"
          @click="handlePageChange(page)"
          :class="[
            'px-4 py-2 rounded-md border transition-colors duration-300',
            currentPage === page
              ? 'bg-indigo-900 text-white border-indigo-900'
              : 'bg-white text-indigo-600 border-gray-300 hover:bg-indigo-50'
          ]"
        >
          {{ page }}
        </button>
        
        <button
          v-if="currentPage < totalPages"
          @click="handlePageChange(currentPage + 1)"
          class="px-4 py-2 rounded-md bg-white border border-gray-300 text-indigo-600 hover:bg-indigo-50 transition-colors duration-300"
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
 