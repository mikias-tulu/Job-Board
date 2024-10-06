<template>
    <div class="min-h-screen flex flex-col">
      <Header />
      <div class="flex flex-grow">
        <Sidebar @navigate="changePage" />
        <div class="flex-grow p-6 bg-gray-100">
          <p class="text-xl font-semibold mb-4">
            Welcome, {{ user.name }}! Here you can manage your job postings.
          </p>
  
          <div v-if="currentPage === 'dashboard'" class="bg-white p-4 shadow-md rounded-md mb-4">
            <h2 class="text-lg font-bold mb-3">Your Job Postings</h2>
            <ul v-if="jobPostings.length" class="space-y-3">
              <li
                v-for="job in jobPostings"
                :key="job.id"
                class="flex justify-between items-center p-2 bg-gray-50 rounded-md shadow-sm"
              >
                <span>{{ job.title }} - {{ job.status }}</span>
                <div class="space-x-2">
                  <button
                    @click="editJobPosting(job)"
                    class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                  >
                    Edit
                  </button>
                  <button
                    @click="deleteJobPosting(job.id)"
                    class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                  >
                    Delete
                  </button>
                </div>
              </li>
            </ul>
            <p v-else class="text-gray-500">No job postings available.</p>
          </div>
  
          <div v-if="currentPage === 'jobPostings'" class="p-4">
            <CreateJobPosting @job-created="fetchJobPostings" />
          </div>
  
          <div v-if="currentPage === 'dashboard'" class="p-4">
            <button
            @click="changePage('jobPostings')"
            class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
          >
            Post a New Job
          </button>
          </div>
  
          <EditJobPosting
            v-if="editingJob"
            :jobId="editingJob.id"
            :currentJob="editingJob"
            @job-updated="fetchJobPostings"
          />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import Sidebar from './Sidebar.vue';
  import Header from './Header.vue';
  import CreateJobPosting from './CreateJob.vue';
  import EditJobPosting from './EditJobPosting.vue';
  
  export default {
    name: 'Dashboard',
    components: {
      Sidebar,
      Header,
      CreateJobPosting,
      EditJobPosting,
    },
    setup() {
      const user = ref({});
      const jobPostings = ref([]);
      const editingJob = ref(null);
      const currentPage = ref('dashboard'); // Track the current page
  
      onMounted(async () => {
        await fetchUser();
        await fetchJobPostings();
      });
  
      const fetchUser = async () => {
        try {
          const response = await axios.get('/api/user', {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          user.value = response.data;
        } catch (error) {
          console.error('Error fetching user data:', error);
        }
      };
  
      const fetchJobPostings = async () => {
        try {
          const response = await axios.get('/api/jobs', {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          jobPostings.value = response.data;
        } catch (error) {
          console.error('Error fetching job postings:', error);
        }
      };
  
      const createJobPosting = () => {
        console.log('Logic to create job posting here.');
      };
  
      const editJobPosting = (job) => {
        editingJob.value = job; // Set the job to be edited
      };
  
      const deleteJobPosting = async (jobId) => {
        try {
          await axios.delete(`/api/jobs/${jobId}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          fetchJobPostings(); // Refresh the job postings list after deletion
        } catch (error) {
          console.error('Error deleting job posting:', error);
        }
      };
  
      const changePage = (page) => {
        currentPage.value = page; // Set the current page
        console.log(`Navigating to ${page}`);
      };
  
      return {
        user,
        jobPostings,
        editingJob,
        currentPage,
        createJobPosting,
        editJobPosting,
        deleteJobPosting,
        changePage,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Dashboard styles */
  </style>
  