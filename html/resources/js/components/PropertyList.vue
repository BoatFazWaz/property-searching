<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Search and Filters -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <input
            type="text"
            v-model="filters.search"
            @input="debouncedSearch"
            placeholder="Search by title or location"
            class="w-full px-4 py-2 border rounded-lg"
          />
        </div>
        <div>
          <select
            v-model="filters.type"
            @change="loadProperties"
            class="w-full px-4 py-2 border rounded-lg"
          >
            <option value="">All Property Types</option>
            <option v-for="type in propertyTypes" :key="type" :value="type">
              {{ type }}
            </option>
          </select>
        </div>
        <div>
          <select
            v-model="filters.province"
            @change="loadProperties"
            class="w-full px-4 py-2 border rounded-lg"
          >
            <option value="">All Provinces</option>
            <option v-for="province in provinces" :key="province" :value="province">
              {{ province }}
            </option>
          </select>
        </div>
      </div>
      
      <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <select
            v-model="filters.sort_by"
            @change="loadProperties"
            class="w-full px-4 py-2 border rounded-lg"
          >
            <option value="created_at">Sort by Date</option>
            <option value="price">Sort by Price</option>
          </select>
        </div>
        <div>
          <select
            v-model="filters.sort_direction"
            @change="loadProperties"
            class="w-full px-4 py-2 border rounded-lg"
          >
            <option value="desc">Descending</option>
            <option value="asc">Ascending</option>
          </select>
        </div>
        <div class="flex gap-4">
          <label class="flex items-center">
            <input
              type="checkbox"
              v-model="filters.for_sale"
              @change="loadProperties"
              class="mr-2"
            />
            For Sale
          </label>
          <label class="flex items-center">
            <input
              type="checkbox"
              v-model="filters.for_rent"
              @change="loadProperties"
              class="mr-2"
            />
            For Rent
          </label>
        </div>
      </div>
    </div>

    <!-- Property Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="property in properties"
        :key="property.id"
        class="bg-white rounded-lg shadow overflow-hidden"
      >
        <img
          :src="property.photo_search"
          :alt="property.title"
          class="w-full h-48 object-cover"
        />
        <div class="p-4">
          <h3 class="text-xl font-semibold mb-2">{{ property.title }}</h3>
          <p class="text-gray-600 mb-4">{{ property.description }}</p>
          <div class="flex justify-between items-center mb-4">
            <span class="text-2xl font-bold text-blue-600">
              {{ property.currency_symbol }}{{ property.price.toLocaleString() }}
            </span>
            <div class="flex items-center">
              <span class="mr-4">
                <i class="fas fa-bed"></i> {{ property.bedrooms }}
              </span>
              <span>
                <i class="fas fa-bath"></i> {{ property.bathrooms }}
              </span>
            </div>
          </div>
          <div class="flex justify-between items-center text-sm text-gray-500">
            <span>{{ property.property_type }}</span>
            <span>{{ property.area }} {{ property.area_type }}</span>
          </div>
          <div class="mt-2 text-sm text-gray-500">
            {{ property.province }}, {{ property.country }}
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
      <button
        v-for="page in totalPages"
        :key="page"
        @click="goToPage(page)"
        :class="[
          'mx-1 px-4 py-2 rounded',
          currentPage === page
            ? 'bg-blue-600 text-white'
            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import debounce from 'lodash/debounce'

export default {
  setup() {
    const properties = ref([])
    const provinces = ref([])
    const propertyTypes = ref([])
    const currentPage = ref(1)
    const totalPages = ref(1)
    const filters = ref({
      search: '',
      type: '',
      province: '',
      sort_by: 'created_at',
      sort_direction: 'desc',
      for_sale: false,
      for_rent: false,
    })

    const loadProperties = async (page = 1) => {
      try {
        const params = {
          ...filters.value,
          page,
        }
        
        const response = await axios.get('/api/properties', { params })
        properties.value = response.data.data
        currentPage.value = response.data.current_page
        totalPages.value = response.data.last_page
      } catch (error) {
        console.error('Error loading properties:', error)
      }
    }

    const loadProvinces = async () => {
      try {
        const response = await axios.get('/api/properties/provinces')
        provinces.value = response.data
      } catch (error) {
        console.error('Error loading provinces:', error)
      }
    }

    const loadPropertyTypes = async () => {
      try {
        const response = await axios.get('/api/properties/types')
        propertyTypes.value = response.data
      } catch (error) {
        console.error('Error loading property types:', error)
      }
    }

    const debouncedSearch = debounce(() => {
      loadProperties()
    }, 300)

    const goToPage = (page) => {
      loadProperties(page)
    }

    onMounted(() => {
      loadProperties()
      loadProvinces()
      loadPropertyTypes()
    })

    return {
      properties,
      provinces,
      propertyTypes,
      filters,
      currentPage,
      totalPages,
      loadProperties,
      debouncedSearch,
      goToPage,
 