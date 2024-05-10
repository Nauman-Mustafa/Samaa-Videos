<template>

    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> User List</h1>
        <router-link to='/admin-panel/add-user' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-upload fa-sm text-white-50"></i> Add User</router-link>
    </div>
    
    <!-- Content Row -->
    <div class="row">
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                              Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">  {{ userStatistics.total_users }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                               Active Users </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">  {{ userStatistics.active_users }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                               Delete Users </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">  {{ userStatistics.deleted_users }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Block Users
                                </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">  {{ userStatistics.blocked_users }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Content Row -->
    
    <div class="row">
    
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Users Tabel</h6>
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
                    <div v-if="loading"  class="card flex justify-content-center">
        <!-- <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
            animationDuration=".5s" aria-label="Custom ProgressSpinner" /> -->
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

    </div>

                    <DataTable v-else  :value="users" :paginator="true" :rows="10">
                        <Column field="first_name" header="First Name"></Column>
                        <Column field="last_name" header="Last Name"></Column>
                        <Column field="display_name" header="Display Name"></Column>
                        <Column field="email" header="Email"></Column>
                        <Column field="role" header="Role"></Column>
                        <Column field="status" header="Status"></Column>
                        
                        <Column field="id" header="">
    <template #body="slotProps">
        <i class="fas fa-edit mx-2 edit-icon"></i> <!-- Edit icon -->
        <i class="fas fa-trash-alt delete-icon" @click="confirmDelete(slotProps.data.id, slotProps.data.first_name, slotProps.data.last_name)"></i>
    </template>
</Column>


                    </DataTable>
                </div>
            </div>
        </div>
    
    
    </div>
    
    
    
    </template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ProgressSpinner from 'primevue/progressspinner';
import ProgressBar from 'primevue/progressbar';

export default {
    components: {
        DataTable,
        Column,
        ProgressSpinner,
        ProgressBar
    },
    data() {
    return {
      users: [],
      loading: false,
      userStatistics: { }
    };
  },
    methods: {
        fetchUsers() {
      // Set loading to true before making API call
      this.loading = true;
      
      axios.get('/api/users')
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error('Error fetching users:', error);
        })
        .finally(() => {
          // Set loading to false after fetching data
          this.loading = false;
        });
    },
        confirmDelete(id, firstName, lastName) {
    this.$swal({
        title: 'Are you sure?',
        text: `You want to delete ${firstName} ${lastName}!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            this.deleteUser(id);
        }
    });
},

        deleteUser(id) {
            axios.delete(`/api/users/${id}`)
                .then(response => {
                    this.$swal('Deleted!', 'User has been deleted.', 'success');
                    this.fetchUsers(); // Refresh user list
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    this.$swal('Error!', 'Failed to delete user.', 'error');
                });
        },
        fetchUserStatistics() {
      axios.get('/api/user-statistics')
        .then(response => {
          this.userStatistics = response.data;
        })
        .catch(error => {
          console.error('Error fetching user statistics:', error);
        });
    }
    },
    mounted() {
        this.fetchUsers();
        this.fetchUserStatistics();

    }
};
</script>


<style src=".../../resources/css/Adminpanel.css"  ></style>
<style scoped>

.edit-icon,
.delete-icon{
cursor: pointer;
}
</style>