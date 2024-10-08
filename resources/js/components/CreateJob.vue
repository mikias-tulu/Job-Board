<template>
    <div class="bg-white p-4 shadow-md rounded-md">
      <h2 class="text-lg font-bold mb-3">Create a New Job Posting</h2>
      <form @submit.prevent="submitJob">
        <div class="mb-4">
          <label class="block text-gray-700">Job Title</label>
          <input
            type="text"
            v-model="job.title"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </div>
  
        <div class="mb-4">
          <label class="block text-gray-700">Location</label>
          <input
            type="text"
            v-model="job.location"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </div>
  
        <div class="mb-4">
          <label class="block text-gray-700">Job Type</label>
          <input
            type="text"
            v-model="job.job_type"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </div>
  
        <button
          type="submit"
          class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
        >
          Create Job
        </button>
      </form>
  
      <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
      <p v-if="successMessage" class="text-green-500 mt-2">{{ successMessage }}</p>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  
  export default {
    name: 'CreateJobPosting',
    setup() {
      const job = ref({
        title: '',
        location: '',
        job_type: '',
      });
      const error = ref(null);
      const successMessage = ref(null); // New success message variable
  
      const submitJob = async () => {
        error.value = null; // Reset error
        successMessage.value = null; // Reset success message
        try {
          await axios.post('/api/jobs', job.value, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
  
          // Optionally, reset the form
          job.value = { title: '', location: '', job_type: '' };
          
          // Set the success message
          successMessage.value = 'Job created successfully!'; // Set the success message
  
          // Notify parent component or update job postings list (optional)
        } catch (err) {
          error.value = err.response.data.message || 'An error occurred while creating the job.';
          console.error('Error creating job:', err);
        }
      };
  
      return {
        job,
        submitJob,
        error,
        successMessage, // Return the success message
      };
    },
  };
  </script>
  
  <style scoped>
  /* Add any specific styles you need here */
  </style>
  