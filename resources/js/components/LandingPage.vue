<template>
    <div class="landing-page">
        <header class="header">
            <h1>Welcome to Our Job Portal</h1>
            <p>Find your dream job today!</p>
            <button @click="showAuth('login')">Login</button>
            <button @click="showAuth('register')">Register</button>
        </header>
        
        <Auth 
            v-if="isAuthVisible" 
            :is-registering="isRegistering" 
            :is-visible="isAuthVisible" 
            @login-success="showDashboard" 
            @close-auth="closeAuth" 
            @toggle-registering="toggleRegistering"
        />

        <JobSearch />
    </div>
</template>

<script>
import JobSearch from './JobSearch.vue';
import Auth from './Auth.vue';

export default {
    name: 'LandingPage',
    components: {
        JobSearch,
        Auth,
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
.landing-page {
    text-align: center;
    padding: 20px;
}
</style>
