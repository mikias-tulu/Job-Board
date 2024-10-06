<template>
    <div class="w-64 bg-gray-800 text-white p-6">
      <h2 class="text-xl font-semibold mb-6">Menu</h2>
      <ul class="space-y-4">
        <li class="cursor-pointer hover:text-gray-300" @click="navigateTo('dashboard')">Dashboard</li>
        <li class="cursor-pointer hover:text-gray-300" @click="navigateTo('jobPostings')">Job Postings</li>
        <li class="cursor-pointer hover:text-gray-300" @click="navigateTo('profile')">Profile</li>
        <li class="cursor-pointer hover:text-red-500" @click="logout">Logout</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      navigateTo(page) {
        this.$emit('navigate', page);
      },
      logout() {
        localStorage.removeItem('token');
        window.location.href = '/';
      }
    }
  };
  </script>
  