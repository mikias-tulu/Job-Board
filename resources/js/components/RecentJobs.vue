<template>
    <div class="w-full bg-white rounded shadow px-5 mt-4">
      <h3 class="text-xl font-bold mb-4 mt-2">Recent Jobs</h3>
      <ul>
        <li v-for="job in recentJobs" :key="job.id" class="border-b py-2">
          <h4 class="text-lg font-semibold">{{ job.title }}</h4>
          <p class="text-gray-600">{{ job.job_type }}</p> 
          <p class="text-gray-500 text-sm">{{ job.location }}</p>
        </li>
      </ul>
      <div v-if="recentJobs.length === 0" class="text-gray-500">
        No recent jobs available.
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'RecentJobs',
    data() {
      return {
        recentJobs: [],
      };
    },
    mounted() {
      this.fetchRecentJobs();
    },
    methods: {
      async fetchRecentJobs() {
        try {
          const response = await axios.get('/api/jobs/recent'); // This should match your API endpoint
          this.recentJobs = response.data; // Directly use the response data\
          console.log("recent", response.data)
        } catch (error) {
          console.error('Failed to fetch recent jobs:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add styles if needed */
  </style>
  