<template>
  <div class="card-glass p-10 my-8">
    <h1 class="text-4xl font-serif mb-6">{{ title }}</h1>
    <p class="mb-4">This page is under construction. We're working on bringing you the best luxury property content.</p>
    <p class="mb-8">Please check back soon for updates or contact our team for more information.</p>
    <router-link to="/" class="btn-primary">Return to Home</router-link>
  </div>
</template>

<script>
export default {
  name: 'PlaceholderPage',
  props: {
    title: {
      type: String,
      required: true
    }
  }
}
</script> 