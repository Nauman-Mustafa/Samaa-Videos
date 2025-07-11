<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                {{ isEditing ? "Edit Asset" : "Add New Asset" }}
            </h1>
            <router-link to="/asset-list" class="btn btn-primary">
                View Asset List
            </router-link>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ isEditing ? "Edit Asset" : "Add Asset" }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Asset Tag</label>
                                        <input
                                            type="text"
                                            v-model="formData.asset_tag"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Asset Company</label>
                                        <input
                                            type="text"
                                            v-model="formData.asset_company"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Major Category</label>
                                        <select
                                            v-model="formData.major_category_id"
                                            class="form-control"
                                            required
                                            @change="loadMinorCategories"
                                        >
                                            <option value="">
                                                Select Major Category
                                            </option>
                                            <option
                                                v-for="category in majorCategories"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Minor Category</label>
                                        <select
                                            v-model="formData.minor_category_id"
                                            class="form-control"
                                            required
                                        >
                                            <option value="">
                                                Select Minor Category
                                            </option>
                                            <option
                                                v-for="category in minorCategories"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea
                                    v-model="formData.description"
                                    class="form-control"
                                    rows="3"
                                    required
                                ></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select
                                            v-model="formData.location_id"
                                            class="form-control"
                                            required
                                        >
                                            <option value="">
                                                Select Location
                                            </option>
                                            <option
                                                v-for="location in locations"
                                                :key="location.id"
                                                :value="location.id"
                                            >
                                                {{ location.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select
                                            v-model="formData.department_id"
                                            class="form-control"
                                            required
                                        >
                                            <option value="">
                                                Select Department
                                            </option>
                                            <option
                                                v-for="department in departments"
                                                :key="department.id"
                                                :value="department.id"
                                            >
                                                {{ department.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Model No</label>
                                        <input
                                            type="text"
                                            v-model="formData.model_no"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Serial No</label>
                                        <input
                                            type="text"
                                            v-model="formData.serial_no"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Condition</label>
                                        <select
                                            v-model="formData.condition"
                                            class="form-control"
                                            required
                                        >
                                            <option value="done">Done</option>
                                            <option value="useable">
                                                Useable
                                            </option>
                                            <option value="unuseable">
                                                Unuseable
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select
                                            v-model="formData.status"
                                            class="form-control"
                                            required
                                        >
                                            <option value="done">Done</option>
                                            <option value="inactive">
                                                Inactive
                                            </option>
                                            <option value="delete">
                                                Delete
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Comments</label>
                                <textarea
                                    v-model="formData.comments"
                                    class="form-control"
                                    rows="3"
                                ></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{
                                    isEditing ? "Update Asset" : "Create Asset"
                                }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { getToken } from "../../../../src/helpers/tokenhelper";

export default {
    data() {
        return {
            isEditing: false,
            formData: {
                asset_tag: "",
                major_category_id: "",
                minor_category_id: "",
                asset_company: "",
                description: "",
                location_id: "",
                department_id: "",
                model_no: "",
                serial_no: "",
                condition: "done",
                status: "done",
                organization_id: "", // We'll set this in mounted
                matching: "",
                comments: "",
            },
            locations: [],
            departments: [],
            majorCategories: [],
            minorCategories: [],
            token: localStorage.getItem("token"), // Get token from localStorage instead
        };
    },
    methods: {
        getInitialFormState() {
            return {
                asset_tag: "",
                major_category_id: "",
                minor_category_id: "",
                asset_company: "",
                description: "",
                location_id: "",
                department_id: "",
                model_no: "",
                serial_no: "",
                condition: "done",
                status: "done",
                organization_id: this.$store.state.auth?.organization?.id || "", // Safe access
                matching: "",
                comments: "",
            };
        },

        // Reset form to initial state
        resetForm() {
            this.formData = this.getInitialFormState();
            this.minorCategories = [];
        },

        async fetchAsset() {
            try {
                const response = await axios.get(
                    `/api/assets/${this.$route.params.id}`,
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                // Map the response data to formData, ensuring condition and status are set
                this.formData = {
                    ...this.getInitialFormState(),
                    ...response.data,
                    // Ensure condition and status are lowercase for consistency
                    condition: response.data.condition?.toLowerCase() || "done",
                    status: response.data.status?.toLowerCase() || "done",
                };

                console.log("Loaded asset data:", this.formData);

                // Load minor categories after setting major category
                if (this.formData.major_category_id) {
                    await this.loadMinorCategories();
                }
            } catch (error) {
                console.error("Error fetching asset:", error);
                this.$swal("Error!", "Failed to fetch asset details.", "error");
            }
        },

        async fetchInitialData() {
            try {
                const [locs, deps, majCats] = await Promise.all([
                    axios.get("/api/locations", {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }),
                    axios.get("/api/departments", {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }),
                    axios.get("/api/categories/major", {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }),
                ]);

                this.locations = locs.data;
                this.departments = deps.data;
                this.majorCategories = majCats.data;

                console.log("Loaded initial data:", {
                    locations: this.locations,
                    departments: this.departments,
                    majorCategories: this.majorCategories,
                });
            } catch (error) {
                console.error("Error fetching initial data:", error);
                this.$swal("Error!", "Failed to load form data.", "error");
            }
        },

        async loadMinorCategories() {
            if (!this.formData.major_category_id) {
                this.minorCategories = [];
                this.formData.minor_category_id = ""; // Reset minor category selection
                return;
            }

            try {
                const response = await axios.get(
                    `/api/categories/${this.formData.major_category_id}/minor`,
                    {
                        headers: { Authorization: `Bearer ${this.token}` },
                    }
                );

                this.minorCategories = response.data;
                console.log("Loaded minor categories:", this.minorCategories);

                // Verify selected minor category still exists in new list
                if (this.isEditing && this.formData.minor_category_id) {
                    const exists = this.minorCategories.some(
                        (cat) => cat.id === this.formData.minor_category_id
                    );
                    if (!exists) {
                        this.formData.minor_category_id = "";
                    }
                }
            } catch (error) {
                console.error("Error loading minor categories:", error);
                this.$swal(
                    "Error!",
                    "Failed to load minor categories.",
                    "error"
                );
            }
        },

        async submitForm() {
            try {
                // Ensure organization_id is set before submitting
                if (
                    !this.formData.organization_id &&
                    this.$store.state.auth?.organization?.id
                ) {
                    this.formData.organization_id =
                        this.$store.state.auth.organization.id;
                }

                const url = this.isEditing
                    ? `/api/assets/${this.$route.params.id}`
                    : "/api/assets";

                const method = this.isEditing ? "put" : "post";

                const response = await axios({
                    method: method,
                    url: url,
                    data: this.formData,
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        "Content-Type": "application/json",
                    },
                });

                this.$swal(
                    "Success!",
                    `Asset ${
                        this.isEditing ? "updated" : "created"
                    } successfully.`,
                    "success"
                );
                this.$router.push("/asset-list");
            } catch (error) {
                console.error("Error:", error);
                const errorMessage =
                    error.response?.data?.message ||
                    error.response?.data?.error ||
                    "Failed to save asset.";
                this.$swal("Error!", errorMessage, "error");
            }
        },
    },
    async mounted() {
        try {
            // Set organization_id from store if available
            if (this.$store.state.auth?.organization?.id) {
                this.formData.organization_id =
                    this.$store.state.auth.organization.id;
            }

            await this.fetchInitialData();

            if (this.$route.params.id) {
                this.isEditing = true;
                await this.fetchAsset();
            } else {
                // Reset form for new asset
                this.resetForm();
            }
        } catch (error) {
            console.error("Mounting error:", error);
        }
    },
    created() {
        // Initialize with empty form data
        this.formData = this.getInitialFormState();
    },
    beforeRouteLeave(to, from, next) {
        this.resetForm();
        next();
    },
    watch: {
        // Add watcher for major_category_id changes
        "formData.major_category_id": {
            handler: async function (newVal, oldVal) {
                if (newVal !== oldVal) {
                    await this.loadMinorCategories();
                }
            },
        },
    },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 1rem;
}

.form-control {
    border-radius: 0.35rem;
    font-size: 0.85rem;
    padding: 0.375rem 0.75rem;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
}
</style>
