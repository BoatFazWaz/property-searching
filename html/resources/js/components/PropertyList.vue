<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Search and Filter Section -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
      <div class="flex flex-col md:flex-row gap-4">
        <!-- Search Input -->
        <div class="flex-1">
          <input
            type="text"
            v-model="searchQuery"
            @input="handleSearch"
            placeholder="Search by title or location..."
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
        </div>
        
        <!-- Filter by Province Dropdown -->
        <div class="w-full md:w-48">
          <select
            v-model="selectedProvince"
            @change="handleProvinceChange"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">All Provinces</option>
            <option v-for="province in provinces" :key="province" :value="province">
              {{ province }}
            </option>
          </select>
        </div>
        
        <!-- Sort Dropdown -->
        <div class="w-full md:w-48">
          <select
            v-model="sortBy"
            @change="handleSort"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="created_at-desc">Newest First</option>
            <option value="created_at-asc">Oldest First</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
    </div>

    <!-- No Results -->
    <div v-else-if="properties.length === 0" class="text-center py-20">
      <h3 class="text-xl text-gray-600">No properties found</h3>
      <p class="mt-2 text-gray-500">Try adjusting your search criteria</p>
    </div>

    <!-- Properties Grid -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="property in properties" :key="property.id" class="bg-white rounded-lg shadow overflow-hidden property-card">
        <img :src="property.photo_search" :alt="property.title" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2">{{ property.title }}</h3>
          <p class="text-gray-600 mb-2">
            <router-link :to="'/' + property.province" class="text-blue-600 hover:underline">
              {{ property.province }}
            </router-link>
          </p>
          <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ property.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-xl font-bold text-blue-600">{{ property.currency_symbol }}{{ formatPrice(property.price) }}</span>
            <div class="flex gap-2">
              <span class="text-gray-600">
                <i class="fas fa-bed"></i> {{ property.bedrooms }}
              </span>
              <span class="text-gray-600">
                <i class="fas fa-bath"></i> {{ property.bathrooms }}
              </span>
              <span class="text-gray-600">
                <i class="fas fa-ruler-combined"></i> {{ property.area }}{{ property.area_type }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="properties.length > 0" class="mt-8 flex justify-center">
      <nav class="flex flex-wrap gap-2">
        <button
          v-if="currentPage > 1"
          @click="handlePageChange(currentPage - 1)"
          class="px-4 py-2 rounded-lg bg-white text-blue-600 hover:bg-blue-50"
        >
          &laquo; Prev
        </button>
        
        <button
          v-for="page in paginationPages"
          :key="page"
          @click="handlePageChange(page)"
          :class="[
            'px-4 py-2 rounded-lg',
            currentPage === page
              ? 'bg-blue-600 text-white'
              : 'bg-white text-blue-600 hover:bg-blue-50'
          ]"
        >
          {{ page }}
        </button>
        
        <button
          v-if="currentPage < totalPages"
          @click="handlePageChange(currentPage + 1)"
          class="px-4 py-2 rounded-lg bg-white text-blue-600 hover:bg-blue-50"
        >
          Next &raquo;
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
/* Add your styles here */
</style>
 