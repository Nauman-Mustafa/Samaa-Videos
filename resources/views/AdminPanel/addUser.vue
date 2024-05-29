<template>
  <div>
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">{{ isEditing ? 'Edit User' : 'Add New User' }}</h1>
          <router-link to='/admin-panel/user-list' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fas fa-upload fa-sm text-white-50"></i> View User List
          </router-link>
      </div>

      <!-- Content Row -->
      <div class="row">
          <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">{{ isEditing ? 'Edit User' : 'Add User' }}</h6>
                  </div>
                  <div class="card-body">
                      <form @submit.prevent="submitForm">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="first_name">First Name</label>
                                      <input type="text" class="form-control" id="first_name" v-model="formData.first_name" placeholder="Enter First Name" required>
                                      <div v-if="errors.first_name" class="invalid-feedback">{{ errors.first_name }}</div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="last_name">Last Name</label>
                                      <input type="text" class="form-control" id="last_name" v-model="formData.last_name" placeholder="Enter Last Name" required>
                                      <div v-if="errors.last_name" class="invalid-feedback">{{ errors.last_name }}</div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="bio">Bio (Optional)</label>
                                      <textarea class="form-control" id="bio" v-model="formData.bio" rows="3"></textarea>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="display_name">Display Name</label>
                                      <input type="text" class="form-control" id="display_name" v-model="formData.display_name" placeholder="Enter Display Name" required>
                                      <div v-if="errors.display_name" class="invalid-feedback">{{ errors.display_name }}</div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="email">Email</label>
                                      <input type="email" class="form-control" id="email" v-model="formData.email" placeholder="Enter Email" required>
                                      <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="password">Password</label>
                                      <input type="password" class="form-control" id="password" v-model="formData.password" placeholder="Enter Password" required>
                                      <div v-if="errors.password" class="invalid-feedback">{{ errors.password }}</div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="role">Role</label>
                                      <select class="form-control" id="role" v-model="formData.role" required>
                                          <option disabled value="">Please select role</option>
                                          <option>Admin</option>
                                          <option>Author</option>
                                      </select>
                                      <div v-if="errors.role" class="invalid-feedback">{{ errors.role }}</div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="status">Status</label>
                                      <select class="form-control" id="status" v-model="formData.status" required>
                                          <option disabled value="">Please select status</option>
                                          <option>Active</option>
                                          <option>Blocked</option>
                                          <option>Deleted</option>
                                      </select>
                                      <div v-if="errors.status" class="invalid-feedback">{{ errors.status }}</div>
                                  </div>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary">{{ isEditing ? 'Update' : 'Submit' }}</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
import { getToken } from '../../../src/helpers/tokenhelper';

export default {
  data() {
      return {
          formData: {
              first_name: '',
              last_name: '',
              bio: '',
              display_name: '',
              email: '',
              password: '',
              role: '',
              status: ''
          },
          errors: {},
          isEditing: false
      };
  },
  computed: {
        token() {
            return getToken();
        }
    },
  methods: {
      async submitForm() {
          this.errors = {};

          // Validate form fields
          if (!this.formData.first_name) this.errors.first_name = 'Please fill this field';
          if (!this.formData.last_name) this.errors.last_name = 'Please fill this field';
          if (!this.formData.display_name) this.errors.display_name = 'Please fill this field';
          if (!this.formData.email) this.errors.email = 'Please fill this field';
          if (!this.formData.password) this.errors.password = 'Please fill this field';
          if (!this.formData.role) this.errors.role = 'Please select a role';
          if (!this.formData.status) this.errors.status = 'Please select a status';

          if (Object.keys(this.errors).length === 0) {
              try {
                  if (this.isEditing) {
                      await axios.put(`/api/users/${this.$route.params.id}`, this.formData, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                      this.$swal('Success!', 'User updated successfully.', 'success');
                  } else {
                      await axios.post('/api/users', this.formData, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                      this.$swal('Success!', 'User created successfully.', 'success');
                  }
                  this.$router.push('/admin-panel/user-list');
              } catch (error) {
                  this.$swal('Error!', 'Error saving user.', 'error');
              }
          } else {
              this.$swal('Error!', 'Please fill in all required fields.', 'error');
          }
      },
      async fetchUser() {
          try {
              const response = await axios.get(`/api/users/${this.$route.params.id}`,{
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
              this.formData = response.data;
          } catch (error) {
              this.$swal('Error!', 'Error fetching user data.', 'error');
          }
      }
  },
  mounted() {
      if (this.$route.params.id) {
          this.isEditing = true;
          this.fetchUser();
      }
  }
};
</script>


<style src=".../../resources/css/Adminpanel.css"  ></style>
