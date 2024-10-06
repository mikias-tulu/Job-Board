<template>
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
  
      <button @click="toggleForm">{{ isRegistering ? 'Already have an account? Login' : 'Don’t have an account? Register' }}</button>
  
      <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
      <div v-if="successMessage" class="success">{{ successMessage }}</div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        isRegistering: false,
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
        this.isRegistering = !this.isRegistering;
        this.resetForm();
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
  
          // Save token to local storage
          localStorage.setItem('token', response.data.token);
          console.log('Token saved:', response.data.token);
  
          // Emit event to notify the parent about successful login
          this.$emit('login-success');
  
          // Redirect to dashboard
          //window.location.href = response.data.redirect; // Make sure your API returns this redirect URL
        } catch (error) {
          this.errorMessage = error.response.data.message || 'Login failed!';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .auth-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
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
  