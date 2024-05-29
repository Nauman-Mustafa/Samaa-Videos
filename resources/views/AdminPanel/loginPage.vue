<template>
  <div class="container">
      <!-- Outer Row -->
      <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-12 col-md-9">
              <div class="card o-hidden border-0 shadow-lg my-5">
                  <div class="card-body p-0">
                      <!-- Nested Row within Card Body -->
                      <div class="row">
                          <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                          <div class="col-lg-6">
                              <div class="p-5">
                                  <div class="text-center">
                                      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                  </div>
                                  <form class="user" @submit.prevent="submitLoginForm">
                                      <div class="form-group">
                                          <input type="email" class="form-control form-control-user"
                                              v-model="email" id="exampleInputEmail" aria-describedby="emailHelp"
                                              placeholder="Enter Email Address...">
                                      </div>
                                      <div class="form-group">
                                          <input type="password" class="form-control form-control-user"
                                              v-model="password" id="exampleInputPassword" placeholder="Password">
                                      </div>
                                      <div class="form-group">
                                          <div class="custom-control custom-checkbox small">
                                              <input type="checkbox" class="custom-control-input" id="customCheck" v-model="rememberMe">
                                              <label class="custom-control-label" for="customCheck">Remember Me</label>
                                          </div>
                                      </div>
                                      <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                      <hr>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
      error: '',
      isLoggingIn: false // Add a flag to track login process
    };
  },
  methods: {
    ...mapActions(['login']),
    async submitLoginForm() {
      if (this.isLoggingIn) return; // Prevent duplicate login attempts
      try {
        this.isLoggingIn = true; // Set flag to indicate login process is in progress
        // console.log('Attempting to login with:', this.email, this.password);
        await this.login({ email: this.email, password: this.password });
        this.$router.push(this.$route.query.redirect || '/admin-panel');
      } catch (error) {
        this.error = 'Invalid credentials';
      } finally {
        this.isLoggingIn = false; // Reset the flag after login attempt is completed
      }
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
