<template>
    <header class="bg-gray-800 text-white">
      <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <a href="/" class="text-2xl font-bold">Job Board</a>
          </div>
          <!-- Links and Hamburger Menu -->
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="#" class="hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Home</a>

              <!-- Dropdown -->
              <div @click="toggleDropdown" class="relative">
                <button class="hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                  More
                  <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md z-20">
                  <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Option 1</a>
                  <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Option 2</a>
                  <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Option 3</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Mobile Menu Button -->
          <div class="md:hidden">
            <button @click="toggleMobileMenu" class="text-gray-300 hover:text-white focus:outline-none focus:text-white">
              <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </button>
          </div>
        </div>
      </nav>
      <!-- Mobile Menu -->
      <div v-if="mobileMenuOpen" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">Home</a>
          <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">About</a>
          <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">Services</a>
          <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">Contact</a>
        </div>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    data() {
      return {
        dropdownOpen: false,
        mobileMenuOpen: false,
      };
    },
    methods: {
      toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
      },
      toggleMobileMenu() {
        this.mobileMenuOpen = !this.mobileMenuOpen;
      },
    },
  };
  </script>
  
  <style scoped>
  /* You can add custom styles here or use Tailwind classes */
  </style>
  