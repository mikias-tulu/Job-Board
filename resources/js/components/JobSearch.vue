<template>
    <div class="w-full flex flex-col items-center justify-start mt- mb-2 bg-gray-100">
      <h1 class="text-2xl font-bold mb-4">Job Search</h1>
      <form 
        @submit.prevent="searchJobs" 
        class="bg-white p-6 shadow-md rounded-md w-full max-w-5xl flex items-center space-x-4" 
      >
        <div class="flex-grow mb-4">
          <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
          <input
            v-model="title"
            type="text"
            id="title"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent p-2 transition duration-200 ease-in-out"
            placeholder="Enter job title"
          />
        </div>
        <div class="flex-grow mb-4">
          <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
          <input
            v-model="location"
            type="text"
            id="location"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent p-2 transition duration-200 ease-in-out"
            placeholder="Enter location"
          />
        </div>
        <button
          type="submit"
          class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
        >
          Search Jobs
        </button>
      </form>
  
      <div v-if="jobs.length" class="mt-6 w-full bg-white rounded shadow px-5 mt-4">
        <h2 class="text-lg font-bold mb-3">Search Results:</h2>
        <ul class="bg-white p-4 rounded-md shadow-md">
          <li
            v-for="job in jobs"
            :key="job.id"
            class="flex justify-between items-center p-2 border-b"
          >
            <span>{{ job.title }}</span>
            <span class="text-sm text-gray-500">{{ job.location }}</span>
          </li>
        </ul>
      </div>
      <p v-else-if="searched" class="mt-6 text-gray-500">No job postings found.</p>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  
  export default {
    name: 'JobSearch',
    setup() {
      const title = ref('');
      const location = ref('');
      const jobs = ref([]);
      const searched = ref(false);
  
      const searchJobs = async () => {
        try {
          const response = await axios.get('/api/search', {
            params: {
              title: title.value,
              location: location.value,
            },
          });
          jobs.value = response.data;
          searched.value = true; // Set searched to true when search is performed
        } catch (error) {
          console.error('Error searching for jobs:', error);
        }
      };
  
      return {
        title,
        location,
        jobs,
        searched,
        searchJobs,
      };
    },
  };
  </script>
  
  <style scoped>
  /* JobSearch styles */
  </style>
  