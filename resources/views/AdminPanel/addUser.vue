<template>

    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Add New User</h1>
        <router-link to='/admin-panel/user-list' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-upload fa-sm text-white-50"></i> View User List</router-link>
    </div>
    
  
    
    <!-- Content Row -->
    
    <div class="row">
    
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Add User</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <!-- <h4>inputs here to ad users </h4> -->
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
                <label for="bio">Bio(Optional)</label>
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

                </div>
            </div>
        </div>
    
 
     
    </div>
    
    
    
    </template>
  <script>
  import axios from 'axios';

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
              errors: {}
          };
      },
      methods: {
        async submitForm() {
    this.errors = {}; 

  
    if (!this.formData.first_name) {
        this.errors.first_name = 'Please fill this field';
    }
    if (!this.formData.last_name) {
        this.errors.last_name = 'Please fill this field';
    }
    if (!this.formData.display_name) {
        this.errors.display_name = 'Please fill this field';
    }
    if (!this.formData.email) {
        this.errors.email = 'Please fill this field';
    }
    if (!this.formData.password) {
        this.errors.password = 'Please fill this field';
    }
    if (!this.formData.role) {
        this.errors.role = 'Please select a role';
    }
    if (!this.formData.status) {
        this.errors.status = 'Please select a status';
    }


    if (Object.keys(this.errors).length === 0) {
        try {
          
            const response = await axios.post('/api/users', this.formData);
            this.formData = {
                first_name: '',
                last_name: '',
                bio: '',
                display_name: '',
                email: '',
                password: '',
                role: '',
                status: ''
            };
            this.$swal({
                title: 'Success!',
                text: 'User created successfully.',
                icon: 'success',
            });

           
        } catch (error) {
           
            this.$swal({
                title: 'Error!',
                text: 'Error creating user.',
                icon: 'error',
            });
            // Handle error response here
        }
    } else {
        this.$swal({
            title: 'Error!',
            text: 'Please fill in all required fields.',
            icon: 'error',
        });
    }
}

      }
  };
</script>
    <style src=".../../resources/css/Adminpanel.css"  ></style>
    <style>
    /* Add your custom CSS styles here */
    .form-group label {
        font-weight: bold;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group textarea
    {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }
   
    .form-group button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .form-group button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>