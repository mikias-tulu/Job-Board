<template>
    <div class="bg-white p-4 shadow-md rounded-md">
      <h2 class="text-lg font-bold mb-4">Edit Job Posting</h2>
      <form @submit.prevent="updateJobPosting">
        <div class="mb-4">
          <label for="title" class="block mb-2">Job Title</label>
          <input
            type="text"
            id="title"
            v-model="jobPosting.title"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-4">
          <label for="location" class="block mb-2">Location</label>
          <input
            type="text"
            id="location"
            v-model="jobPosting.location"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-4">
          <label for="job_type" class="block mb-2">Job Type</label>
          <input
            type="text"
            id="job_type"
            v-model="jobPosting.job_type"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="flex justify-end">
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
          >
            Update Job Posting
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'EditJobPosting',
    props: {
      jobId: {
        type: Number,
        required: true,
      },
      currentJob: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        jobPosting: {
          title: this.currentJob.title,
          location: this.currentJob.location,
          job_type: this.currentJob.job_type,
        },
      };
    },
    methods: {
      async updateJobPosting() {
        try {
          await axios.put(`/api/jobs/${this.jobId}`, this.jobPosting, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          this.$emit('job-updated'); // Emit event to notify parent component
        } catch (error) {
          console.error('Error updating job posting:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* EditJobPosting styles */
  </style>
  