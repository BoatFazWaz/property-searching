<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Search and Filter Section -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
      <div class="flex flex-wrap gap-4">
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
        
        <!-- Sort Dropdown -->
        <div class="w-48">
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

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="property in properties" :key="property.id" class="bg-white rounded-lg shadow overflow-hidden">
        <img :src="property.photo_search" :alt="property.title" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2">{{ property.title }}</h3>
          <p class="text-gray-600 mb-2">{{ property.province }}</p>
          <div class="flex justify-between items-center">
            <span class="text-xl font-bold text-blue-600">{{ property.currency_symbol }}{{ property.price.toLocaleString() }}</span>
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
    <div class="mt-8 flex justify-center">
      <nav class="flex gap-2">
        <button
          v-for="page in totalPages"
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
      </nav>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'PropertyList',
  setup() {
    const properties = ref([]);
    const searchQuery = ref('');
    const sortBy = ref('created_at-desc');
    const currentPage = ref(1);
    const totalPages = ref(1);
    const route = useRoute();
    const router = useRouter();

    const fetchProperties = async () => {
      try {
        const params = {
          page: currentPage.value,
          search: searchQuery.value,
        };

        if (route.params.province) {
          params.province = route.params.province;
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
    };

    watch(() => route.params.province, () => {
      currentPage.value = 1;
      fetchProperties();
    });

    onMounted(() => {
      fetchProperties();
    });

    return {
      properties,
      searchQuery,
      sortBy,
      currentPage,
      totalPages,
      handleSearch,
      handleSort,
      handlePageChange,
    };
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
 