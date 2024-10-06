import './bootstrap';
import { createApp, ref } from 'vue';
import axios from 'axios';

import Auth from './components/Auth.vue';
import Dashboard from './components/Dashboard.vue';
import LandingPage from './components/LandingPage.vue';

const app = createApp({
    setup() {
        const isAuthenticated = ref(false);
        const showDashboard = ref(false);

        // Check authentication state on app initialization
        const checkAuth = async () => {
            try {
                await axios.get('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    }
                });
                console.log("first token", localStorage.getItem('token'))
                isAuthenticated.value = true; 
                showDashboard.value = true;
            } catch (error) {
                isAuthenticated.value = false;
                showDashboard.value = false;
            }
        };
        

        checkAuth();

        return { isAuthenticated, showDashboard };
    },
    components: {
        LandingPage,
        Dashboard,
    },
});


app.component('auth', {
    props: {
        onLogin: {
            type: Function,
            required: true,
        },
    },
    setup(props) {
        const handleLogin = () => {
            props.onLogin();
        };

        return { handleLogin };
    },
});

app.mount('#app');
