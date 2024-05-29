<template>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Category List</h1>
        <router-link to="/admin-panel/add-category" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-upload fa-sm text-white-50"></i> Add Category
        </router-link>
    </div>
    
    <!-- Content Row -->
    <div class="row">
        <!-- Total Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ categoryStatistics.total_categories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Active Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ categoryStatistics.active_categories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Deleted Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Deleted Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ categoryStatistics.deleted_categories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Parent Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Parent Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ categoryStatistics.parent_categories }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-2">
        <div class="p-2 col-md-3 bg-white">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input v-model="searchTerm" type="text" class="form-control bg-light border-0 small" placeholder="Search by name"
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Categories Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Categories Table</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
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
                    <div v-if="loading" class="card flex justify-content-center">
                        <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>
                    </div>
                    <div v-else-if="error" class="alert alert-danger">
                        Error fetching categories: {{ error }}
                    </div>
                    <DataTable v-else :value="filteredCategories" :paginator="true" :rows="5">
                        <Column field="id" header="ID"></Column>
                        <Column field="name" header="Name"></Column>
                        <Column field="slug" header="Slug "></Column>
                        <Column field="status" header="Status"></Column>
                        <Column field="parent_id" header="Parent Category"></Column>
                        <Column field="id" header="">
                            <template #body="slotProps">
                                <i class="fas fa-edit mx-2 edit-icon" @click="editCategory(slotProps.data.id)"></i>
                                <i class="fas fa-trash-alt delete-icon" @click="confirmDelete(slotProps.data.id, slotProps.data.name)"></i>
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
import ProgressBar from 'primevue/progressbar';

import { getToken } from '../../../src/helpers/tokenhelper';

export default {
    components: {
        DataTable,
        Column,
        ProgressBar
    },
    data() {
        return {
            categories: [],
            searchTerm: '',
            loading: false,
            error: null,
            categoryStatistics: {}
        };
    },
    computed: {
        filteredCategories() {
            if (this.searchTerm.trim() === '') {
                return this.categories;
            }
            const lowerCaseSearchTerm = this.searchTerm.toLowerCase();
            return this.categories.filter(category => 
                category.name.toLowerCase().includes(lowerCaseSearchTerm)
            );
        },  
        token() {
            return getToken();
        }
    },
    methods: {
        fetchCategories() {
            this.loading = true;
            this.error = null;
           
            axios.get('/api/categories', {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    this.error = error.message;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        editCategory(id) {
            this.$router.push(`/admin-panel/edit-category/${id}`);
        },
        confirmDelete(id, name) {
            this.$swal({
                title: 'Are you sure?',
                text: `You want to delete category: ${name}!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteCategory(id);
                }
            });
        },
        deleteCategory(id) {
            axios.delete(`/api/categories/${id}`, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.$swal('Deleted!', 'Category has been deleted.', 'success');
                    this.fetchCategories();
                })
                .catch(error => {
                    console.error('Error deleting category:', error);
                    this.$swal('Error!', 'Failed to delete category.', 'error');
                });
        },
        fetchCategoryStatistics() {
            axios.get('/api/category-statistics', {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.categoryStatistics = response.data;
                })
                .catch(error => {
                    console.error('Error fetching category statistics:', error);
                });
        }
    },
    mounted() {
        
        this.fetchCategories();
        this.fetchCategoryStatistics();
    }
};
</script>

<style src=".../../resources/css/Adminpanel.css"></style>
<style scoped>
.edit-icon,
.delete-icon {
    cursor: pointer;
}
</style>
