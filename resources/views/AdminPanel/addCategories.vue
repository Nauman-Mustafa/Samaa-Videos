<template>
    <div>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isEditing ? 'Edit Category' : 'Add New Category' }}</h1>
        <router-link to='/admin-panel/category-list' class="btn btn-primary">View Category List</router-link>
      </div>
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">{{ isEditing ? 'Edit Category' : 'Add Category' }}</h6>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" v-model="formData.name" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                  <label for="slug">Slug</label>
                  <input type="text" v-model="formData.slug" class="form-control" id="slug" required>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select v-model="formData.status" class="form-control" id="status" required>
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="parent_id">Parent Category</label>
                  <select v-model="formData.parent_id" class="form-control" id="parent_id">
                    <option value="">No Parent</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                  </select>
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
          name: '',
          slug: '',
          status: '',
          parent_id: null
        },
        categories: [],
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
        try {
          if (this.isEditing) {
            await axios.put(`/api/categories/${this.$route.params.id}`, this.formData, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
            this.$swal('Success!', 'Category updated successfully.', 'success');

          } else {
            await axios.post('/api/categories', this.formData, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
            this.$swal('Success!', 'Category created successfully.', 'success');

          }
          this.$router.push('/admin-panel/category-list');
        } catch (error) {
          this.$swal('Error!', 'Error saving Category.', 'error');

        }
      },
      async fetchCategory() {
        try {
          const response = await axios.get(`/api/categories/${this.$route.params.id}`, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
          this.formData = response.data;
        } catch (error) {
          console.error('Error fetching category:', error);
        }
      },
      async fetchCategories() {
        try {
          const response = await axios.get('/api/categories', {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
          this.categories = response.data;
        } catch (error) {
          console.error('Error fetching categories:', error);
        }
      }
    },
    async mounted() {
      
      if (this.$route.params.id) {
        this.isEditing = true;
        await this.fetchCategory();
      }
      await this.fetchCategories();
    }
  };
  </script>
    <style src=".../../resources/css/Adminpanel.css"  ></style>
