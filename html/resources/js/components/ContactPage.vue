<template>
  <div class="card-glass p-10 my-8 min-h-[50vh] flex flex-col">
    <h1 class="text-4xl font-serif mb-6">Contact Us</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-grow">
      <div>
        <p class="mb-6">We'd love to hear from you. Please use the form or contact details below to get in touch with our team.</p>
        <div class="space-y-4 mb-6">
          <div class="flex items-center">
            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
            <span>123 Sukhumvit Road, Bangkok, Thailand 10110</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-phone-alt text-primary mr-3"></i>
            <span>+66 2 123 4567</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-envelope text-primary mr-3"></i>
            <span>contact@luxuryproperties.com</span>
          </div>
        </div>
        
        <div class="mt-8 p-4 bg-white/50 rounded-xl border border-primary/10">
          <h3 class="font-serif text-xl mb-3 text-primary">Office Hours</h3>
          <ul class="space-y-2">
            <li class="flex justify-between">
              <span>Monday - Friday</span>
              <span class="font-medium">9:00 AM - 6:00 PM</span>
            </li>
            <li class="flex justify-between">
              <span>Saturday</span>
              <span class="font-medium">10:00 AM - 4:00 PM</span>
            </li>
            <li class="flex justify-between">
              <span>Sunday</span>
              <span class="font-medium">Closed</span>
            </li>
          </ul>
        </div>
      </div>
      <div>
        <form class="space-y-4" @submit.prevent="handleSubmit">
          <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" v-model="form.name" class="input-modern w-full" placeholder="Your name">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" v-model="form.email" class="input-modern w-full" placeholder="Your email">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Message</label>
            <textarea rows="4" v-model="form.message" class="input-modern w-full" placeholder="Your message"></textarea>
          </div>
          <button type="submit" class="btn-primary w-full">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ContactPage',
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: ''
      }
    }
  },
  methods: {
    handleSubmit() {
      alert('Thank you for your message! We will get back to you soon.');
      this.form.name = '';
      this.form.email = '';
      this.form.message = '';
    }
  }
}
</script> 