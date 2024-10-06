import './bootstrap';
import { createApp, ref } from 'vue';
import axios from 'axios';

import Auth from './components/Auth.vue';
import Dashboard from './components/Dashboard.vue';

const app = createApp({
    setup() {
        const isAuthenticated = ref(false); // Define a reactive property
        const showDashboard = ref(false); // Track whether to show the dashboard

        // Check authentication state on app initialization
        const checkAuth = async () => {
            try {
                await axios.get('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`, // Include token in the header
                    }
                });
                console.log("first token", localStorage.getItem('token'))
                isAuthenticated.value = true; // User is authenticated
                showDashboard.value = true; // Show dashboard if authenticated
            } catch (error) {
                isAuthenticated.value = false; // User is not authenticated
                showDashboard.value = false; // Don't show dashboard
            }
        };
        

        // Call the checkAuth function when the app initializes
        checkAuth();

        return { isAuthenticated, showDashboard };
    },
    components: {
        Auth,
        Dashboard,
    },
});

// Listen for an event from Auth.vue to toggle authentication state
app.component('auth', {
    props: {
        onLogin: {
            type: Function,
            required: true,
        },
    },
    setup(props) {
        const handleLogin = () => {
            props.onLogin(); // Call the provided login handler
        };

        return { handleLogin };
    },
});

app.mount('#app');
