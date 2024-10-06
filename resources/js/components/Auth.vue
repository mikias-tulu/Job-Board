<template>
    <div class="modal" v-if="isVisible">
        <div class="modal-background" @click="closeModal"></div>
        <div class="auth-container">
            <h1>{{ isRegistering ? 'Register' : 'Login' }}</h1>

            <form @submit.prevent="isRegistering ? register() : login()">
                <div class="form-group" v-if="isRegistering">
                    <label for="name">Name</label>
                    <input type="text" v-model="form.name" required />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" v-model="form.email" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" v-model="form.password" required />
                </div>

                <button type="submit">{{ isRegistering ? 'Register' : 'Login' }}</button>
            </form>

            <button @click="toggleForm">{{ isRegistering ? 'Already have an account? Login' : 'Do not have an account? Register' }}</button>

            <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
            <div v-if="successMessage" class="success">{{ successMessage }}</div>
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

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999; /* Ensure modal is on top */
}

.modal-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
}

.auth-container {
    position: relative;
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background: white; /* White background for the modal */
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000; /* Ensure the modal content is above the background */
}

.form-group {
    margin-bottom: 15px;
}

.error {
    color: red;
}

.success {
    color: green;
}
</style>
