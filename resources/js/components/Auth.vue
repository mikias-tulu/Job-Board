<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center" v-if="isVisible">
        <div class="absolute inset-0 bg-black opacity-50" @click="closeModal"></div>
        <div class="relative max-w-sm w-full p-6 bg-white rounded-lg shadow-lg z-10">
            <h1 class="text-xl font-bold text-center mb-4">{{ isRegistering ? 'Register' : 'Login' }}</h1>

            <form @submit.prevent="isRegistering ? register() : login()">
                <div class="mb-4" v-if="isRegistering">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input
                        type="text"
                        v-model="form.name"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    />
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        v-model="form.email"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        type="password"
                        v-model="form.password"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200"
                >
                    {{ isRegistering ? 'Register' : 'Login' }}
                </button>
            </form>

            <button
                @click="toggleForm"
                class="mt-4 text-blue-600 hover:text-blue-800 transition duration-200"
            >
                {{ isRegistering ? 'Already have an account? Login' : 'Do not have an account? Register' }}
            </button>

            <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
            <div v-if="successMessage" class="text-green-500 mt-2">{{ successMessage }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        isRegistering: {
            type: Boolean,
            default: false,
        },
        isVisible: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
            },
            errorMessage: '',
            successMessage: '',
        };
    },
    methods: {
        toggleForm() {
            this.$emit('toggle-registering');
            this.resetForm();
        },
        closeModal() {
            this.$emit('close-auth');
        },
        resetForm() {
            this.form.name = '';
            this.form.email = '';
            this.form.password = '';
            this.errorMessage = '';
            this.successMessage = '';
        },
        async register() {
            try {
                const response = await axios.post('/api/register', this.form);
                this.successMessage = 'Registration successful!';
                this.errorMessage = '';

                // Save token to local storage
                localStorage.setItem('token', response.data.token);
                console.log('Token saved:', response.data.token);
            } catch (error) {
                this.errorMessage = error.response.data.message || 'Registration failed!';
            }
        },
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.form.email,
                    password: this.form.password,
                });
                this.successMessage = 'Login successful!';
                this.errorMessage = '';

                localStorage.setItem('token', response.data.token);
                console.log('Token saved:', response.data.token);

                this.$emit('login-success');
                this.closeModal();
                window.location.reload();
            } catch (error) {
                this.errorMessage = error.response.data.message || 'Login failed!';
            }
        },
    },
};
</script>
