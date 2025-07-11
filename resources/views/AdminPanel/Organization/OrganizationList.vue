<template>
    <div>
        <!-- No Organization State -->
        <div v-if="!organizations.length" class="card shadow">
            <div class="card-body text-center py-5">
                <div class="empty-state mb-4">
                    <i class="fas fa-building fa-4x text-gray-300"></i>
                </div>
                <h3 class="h4 mb-3">No Organization Set Up</h3>
                <p class="text-gray-600 mb-4">
                    Start by setting up your organization to manage departments
                    and locations.
                </p>
                <button @click="showAddModal" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus fa-sm mr-2"></i>
                    Set Up Organization
                </button>
            </div>
        </div>

        <!-- Organization Details (when exists) -->
        <div v-else>
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex justify-content-between align-items-center"
                >
                    <h6 class="m-0 font-weight-bold text-primary">
                        Organization Details
                    </h6>
                </div>
                <div class="card-body">
                    <div
                        v-if="loading"
                        class="card flex justify-content-center"
                    >
                        <ProgressBar
                            mode="indeterminate"
                            style="height: 6px"
                        ></ProgressBar>
                    </div>
                    <div class="organization-details">
                        <div
                            class="d-flex justify-content-between align-items-center mb-4"
                        >
                            <h2 class="h4 mb-0">{{ organizations[0].name }}</h2>
                            <div>
                                <button
                                    class="btn btn-info btn-sm mr-2"
                                    @click="editOrganization(organizations[0])"
                                >
                                    <i class="fas fa-edit"></i> Edit Name
                                </button>
                                <span class="badge badge-primary ml-2">
                                    Assets: {{ organizations[0].assets_count }}
                                </span>
                            </div>
                        </div>

                        <!-- Departments and Locations Grid -->
                        <div class="row">
                            <!-- Departments Section -->
                            <div class="col-md-6">
                                <div class="card shadow h-100">
                                    <div
                                        class="card-header py-3 d-flex justify-content-between align-items-center"
                                    >
                                        <h6
                                            class="m-0 font-weight-bold text-primary"
                                        >
                                            Departments
                                        </h6>
                                        <button
                                            class="btn btn-primary btn-sm"
                                            @click="showAddDepartmentModal"
                                        >
                                            <i class="fas fa-plus fa-sm"></i>
                                            Add Department
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="departments-grid">
                                            <div
                                                v-for="dept in organizations[0]
                                                    .departments"
                                                :key="dept.id"
                                                class="department-item"
                                            >
                                                <div
                                                    class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2"
                                                >
                                                    <span
                                                        class="font-weight-bold"
                                                        >{{ dept.name }}</span
                                                    >
                                                    <button
                                                        class="btn btn-danger btn-sm"
                                                        @click="
                                                            confirmDeleteDepartment(
                                                                organizations[0],
                                                                dept
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Locations Section -->
                            <div class="col-md-6">
                                <div class="card shadow h-100">
                                    <div
                                        class="card-header py-3 d-flex justify-content-between align-items-center"
                                    >
                                        <h6
                                            class="m-0 font-weight-bold text-primary"
                                        >
                                            Locations
                                        </h6>
                                        <button
                                            class="btn btn-primary btn-sm"
                                            @click="showAddLocationModal"
                                        >
                                            <i class="fas fa-plus fa-sm"></i>
                                            Add Location
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="locations-grid">
                                            <div
                                                v-for="loc in organizations[0]
                                                    .locations"
                                                :key="loc.id"
                                                class="location-item"
                                            >
                                                <div
                                                    class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2"
                                                >
                                                    <span
                                                        class="font-weight-bold"
                                                        >{{ loc.name }}</span
                                                    >
                                                    <button
                                                        class="btn btn-danger btn-sm"
                                                        @click="
                                                            confirmDeleteLocation(
                                                                organizations[0],
                                                                loc
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization Modal -->
        <Dialog
            v-model:visible="displayModal"
            :header="isEditing ? 'Edit Organization' : 'Set Up Organization'"
            :modal="true"
            :style="{ width: '450px' }"
            :closable="false"
        >
            <div class="p-fluid">
                <div class="field">
                    <label for="name">Organization Name</label>
                    <InputText
                        id="name"
                        v-model="formData.name"
                        required
                        :class="{ 'p-invalid': formErrors.name }"
                        @input="clearErrors"
                    />
                    <small class="p-error" v-if="formErrors.name">{{
                        formErrors.name
                    }}</small>
                </div>
            </div>
            <template #footer>
                <Button
                    v-if="isEditing"
                    label="Cancel"
                    icon="pi pi-times"
                    @click="closeModal"
                    class="p-button-text"
                />
                <Button
                    :label="isEditing ? 'Save Changes' : 'Create Organization'"
                    icon="pi pi-check"
                    @click="saveOrganization"
                    :loading="saving"
                />
            </template>
        </Dialog>

        <!-- Add Department Modal -->
        <Dialog
            v-model:visible="showDepartmentModal"
            header="Add Department"
            :modal="true"
            :style="{ width: '400px' }"
        >
            <div class="p-fluid">
                <div class="field">
                    <label for="departmentName">Department Name</label>
                    <InputText
                        id="departmentName"
                        v-model="newDepartment"
                        required
                    />
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    @click="closeDepartmentModal"
                    class="p-button-text"
                />
                <Button
                    label="Add"
                    icon="pi pi-check"
                    @click="addDepartment(organizations[0])"
                    :disabled="!newDepartment.trim()"
                />
            </template>
        </Dialog>

        <!-- Add Location Modal -->
        <Dialog
            v-model:visible="showLocationModal"
            header="Add Location"
            :modal="true"
            :style="{ width: '400px' }"
        >
            <div class="p-fluid">
                <div class="field">
                    <label for="locationName">Location Name</label>
                    <InputText
                        id="locationName"
                        v-model="newLocation"
                        required
                    />
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    @click="closeLocationModal"
                    class="p-button-text"
                />
                <Button
                    label="Add"
                    icon="pi pi-check"
                    @click="addLocation(organizations[0])"
                    :disabled="!newLocation.trim()"
                />
            </template>
        </Dialog>
    </div>
</template>

<script>
import { ref } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import ProgressBar from "primevue/progressbar";
import axios from "axios";
import { getToken } from "../../../../src/helpers/tokenhelper";

export default {
    components: {
        DataTable,
        Column,
        Dialog,
        InputText,
        Button,
        ProgressBar,
    },
    data() {
        return {
            organizations: [],
            displayModal: false,
            showDepartmentModal: false,
            showLocationModal: false,
            loading: false,
            saving: false,
            isEditing: false,
            newDepartment: "",
            newLocation: "",
            formData: {
                id: null,
                name: "",
            },
            formErrors: {
                name: null,
            },
        };
    },
    computed: {
        token() {
            return getToken();
        },
    },
    methods: {
        async fetchOrganizations() {
            this.loading = true;
            try {
                const response = await axios.get("/api/organizations", {
                    headers: { Authorization: `Bearer ${this.token}` },
                });
                this.organizations = response.data;
            } catch (error) {
                this.$swal("Error!", "Failed to fetch organization.", "error");
            } finally {
                this.loading = false;
            }
        },

        showAddDepartmentModal() {
            this.newDepartment = "";
            this.showDepartmentModal = true;
        },

        showAddLocationModal() {
            this.newLocation = "";
            this.showLocationModal = true;
        },

        closeDepartmentModal() {
            this.showDepartmentModal = false;
            this.newDepartment = "";
        },

        closeLocationModal() {
            this.showLocationModal = false;
            this.newLocation = "";
        },

        async addDepartment(org) {
            if (!this.newDepartment.trim()) return;

            try {
                await axios.post(
                    `/api/organizations/${org.id}/departments`,
                    {
                        name: this.newDepartment,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                this.closeDepartmentModal();
                await this.fetchOrganizations();
                this.$swal(
                    "Success!",
                    "Department added successfully.",
                    "success"
                );
            } catch (error) {
                this.$swal("Error!", "Failed to add department.", "error");
            }
        },

        async addLocation(org) {
            if (!this.newLocation.trim()) return;

            try {
                await axios.post(
                    `/api/organizations/${org.id}/locations`,
                    {
                        name: this.newLocation,
                    },
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                this.closeLocationModal();
                await this.fetchOrganizations();
                this.$swal(
                    "Success!",
                    "Location added successfully.",
                    "success"
                );
            } catch (error) {
                this.$swal("Error!", "Failed to add location.", "error");
            }
        },

        confirmDeleteDepartment(org, dept) {
            this.$swal({
                title: "Are you sure?",
                text: `Do you want to delete the department "${dept.name}"?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteDepartment(org, dept);
                }
            });
        },

        confirmDeleteLocation(org, loc) {
            this.$swal({
                title: "Are you sure?",
                text: `Do you want to delete the location "${loc.name}"?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteLocation(org, loc);
                }
            });
        },

        showAddModal() {
            this.isEditing = false;
            this.formData = {
                id: null,
                name: "",
            };
            this.displayModal = true;
        },
        editOrganization(org) {
            this.isEditing = true;
            this.formData = { ...org };
            this.displayModal = true;
        },
        closeModal() {
            this.displayModal = false;
            this.formData = {
                id: null,
                name: "",
            };
        },
        clearErrors() {
            this.formErrors = {
                name: null,
            };
        },
        async saveOrganization() {
            if (!this.formData.name.trim()) {
                this.formErrors.name = "Organization name is required";
                return;
            }

            this.saving = true;
            try {
                if (this.isEditing) {
                    await axios.put(
                        `/api/organizations/${this.formData.id}`,
                        this.formData,
                        {
                            headers: { Authorization: `Bearer ${this.token}` },
                        }
                    );
                } else {
                    await axios.post("/api/organizations", this.formData, {
                        headers: { Authorization: `Bearer ${this.token}` },
                    });
                }

                this.closeModal();
                await this.fetchOrganizations();
                this.$swal(
                    "Success!",
                    `Organization ${
                        this.isEditing ? "updated" : "created"
                    } successfully.`,
                    "success"
                );
            } catch (error) {
                this.$swal(
                    "Error!",
                    error.response?.data?.message ||
                        "Failed to save organization.",
                    "error"
                );
            } finally {
                this.saving = false;
            }
        },
        async deleteDepartment(org, dept) {
            try {
                await axios.delete(
                    `/api/organizations/${org.id}/departments/${dept.id}`,
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                await this.fetchOrganizations();
                this.$swal(
                    "Success!",
                    "Department deleted successfully.",
                    "success"
                );
            } catch (error) {
                this.$swal("Error!", "Failed to delete department.", "error");
            }
        },
        async deleteLocation(org, loc) {
            try {
                await axios.delete(
                    `/api/organizations/${org.id}/locations/${loc.id}`,
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                await this.fetchOrganizations();
                this.$swal(
                    "Success!",
                    "Location deleted successfully.",
                    "success"
                );
            } catch (error) {
                this.$swal("Error!", "Failed to delete location.", "error");
            }
        },
    },
    mounted() {
        this.fetchOrganizations();
    },
};
</script>

<style scoped>
.organization-details {
    max-width: 1200px;
    margin: 0 auto;
}

.departments-grid,
.locations-grid {
    max-height: 400px;
    overflow-y: auto;
}

.department-item,
.location-item {
    transition: all 0.3s ease;
}

.department-item:hover,
.location-item:hover {
    transform: translateX(5px);
}

.badge {
    padding: 0.5em 1em;
    font-size: 0.9em;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.bg-light {
    background-color: #f8f9fc !important;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.empty-state {
    padding: 2rem 0;
}

.empty-state i {
    margin-bottom: 1.5rem;
}
</style>
