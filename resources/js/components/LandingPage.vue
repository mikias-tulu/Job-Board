<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 relative">
      <header class="w-full flex justify-between items-center p-4">
        <h2 class="text-2xl font-bold">Mini Job board</h2>
        <div class="space-x-4">
          <button
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
            @click="showAuth('login')"
          >
            Login
          </button>
          <button
            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded"
            @click="showAuth('register')"
          >
            Register
          </button>
        </div>
      </header>
  
      <p class="text-lg text-gray-700 text-center mt-5">Find your dream job today!</p>
  
      <Auth 
        v-if="isAuthVisible" 
        :is-registering="isRegistering" 
        :is-visible="isAuthVisible" 
        @login-success="showDashboard" 
        @close-auth="closeAuth" 
        @toggle-registering="toggleRegistering"
      />
  
      <JobSearch />
      <Div class="w-full flex justify-between items-center p-8 mt-4">
        <RecentJobs />
      </Div>

    </div>
  </template>
  
  <script>
  import JobSearch from './JobSearch.vue';
  import RecentJobs from './RecentJobs.vue';
  import Auth from './Auth.vue';
  
  export default {
    name: 'LandingPage',
    components: {
      JobSearch,
      Auth,
      RecentJobs
    },
    data() {
      return {
        isAuthVisible: false, 
        isRegistering: false,
      };
    },
    methods: {
      showAuth(type) {
        this.isAuthVisible = true;
        this.isRegistering = (type === 'register');
      },
      closeAuth() {
        this.isAuthVisible = false; 
        this.isRegistering = false;
      },
      toggleRegistering() {
        this.isRegistering = !this.isRegistering; 
      },
      showDashboard() {
        console.log('User logged in successfully!');
      }
    },
  };
  </script>
  
  <style scoped>
  /* No additional styles are needed when using Tailwind CSS */
  </style>
  