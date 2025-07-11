<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Import Assets</h1>
            <router-link to="/admin-panel/asset-list" class="btn btn-primary">
                View Asset List
            </router-link>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Upload Excel File
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="font-weight-bold">
                                Excel Format Requirements:
                            </h6>
                            <p>
                                Your Excel file should include the following
                                columns:
                            </p>
                            <ul>
                                <li>Sr. (optional)</li>
                                <li>City (required)</li>
                                <li>Major Category (required)</li>
                                <li>Minor Category (required)</li>
                                <li>Asset Company (optional)</li>
                                <li>Asset Description (required)</li>
                                <li>Location/User (optional)</li>
                                <li>Model No. (optional)</li>
                                <li>Serial No. (optional)</li>
                                <li>Condition (optional)</li>
                                <li>Asset Tag No. (required)</li>
                                <li>Matching (optional)</li>
                                <li>Status (optional)</li>
                                <li>
                                    New Location/Additional remarks (optional)
                                </li>
                                <li>Comments (optional)</li>
                            </ul>
                        </div>

                        <!-- Sample File Download -->
                        <div class="mb-4">
                            <a
                                href="/sample-template.xlsx"
                                class="btn btn-success"
                            >
                                <i class="fas fa-download mr-1"></i> Download
                                Sample Template
                            </a>
                        </div>

                        <form
                            @submit.prevent="submitForm"
                            enctype="multipart/form-data"
                        >
                            <div class="form-group">
                                <label>Select Excel File</label>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    @change="handleFileUpload"
                                    accept=".xlsx,.xls,.csv"
                                    required
                                />
                                <small class="form-text text-muted">
                                    Accepted formats: .xlsx, .xls (Max size:
                                    5MB)
                                </small>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="loading || !selectedFile"
                            >
                                <span
                                    v-if="loading"
                                    class="spinner-border spinner-border-sm mr-2"
                                ></span>
                                {{ loading ? "Importing..." : "Import Assets" }}
                            </button>
                        </form>

                        <!-- Progress Section -->
                        <div v-if="importProgress" class="mt-4">
                            <div class="progress">
                                <div
                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    :style="{ width: importProgress + '%' }"
                                    :aria-valuenow="importProgress"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                >
                                    {{ importProgress }}%
                                </div>
                            </div>
                            <small class="text-muted mt-2">
                                Processing rows: {{ processedRows }} /
                                {{ totalRows }}
                            </small>
                        </div>

                        <!-- Error Display -->
                        <div
                            v-if="errors.length > 0"
                            class="alert alert-danger mt-4"
                        >
                            <h6 class="font-weight-bold">Import Errors:</h6>
                            <ul class="mb-0">
                                <li
                                    v-for="(error, index) in errors"
                                    :key="index"
                                >
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { getToken } from "@/helpers/tokenhelper";

export default {
    data() {
        return {
            selectedFile: null,
            loading: false,
            importProgress: 0,
            processedRows: 0,
            totalRows: 0,
            errors: [],
        };
    },
    computed: {
        token() {
            return getToken();
        },
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                // Check file type
                const validTypes = [
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    "application/vnd.ms-excel",
                    "text/csv",
                ];
                if (!validTypes.includes(file.type)) {
                    this.$swal(
                        "Error!",
                        "Please upload a valid Excel or CSV file.",
                        "error"
                    );
                    event.target.value = ""; // Clear the file input
                    return;
                }

                // Check file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    this.$swal(
                        "Error!",
                        "File size should not exceed 5MB.",
                        "error"
                    );
                    event.target.value = ""; // Clear the file input
                    return;
                }

                this.selectedFile = file;
                console.log("File selected:", {
                    name: file.name,
                    type: file.type,
                    size: file.size,
                });
            }
        },

        async submitForm() {
            try {
                if (!this.selectedFile) {
                    this.$swal(
                        "Error!",
                        "Please select a file first.",
                        "error"
                    );
                    return;
                }

                // Log file details
                console.log("File details:", {
                    name: this.selectedFile.name,
                    type: this.selectedFile.type,
                    size: this.selectedFile.size,
                });

                const formData = new FormData();
                formData.append("file", this.selectedFile);
                formData.append("organization_id", 1); // Make sure this matches a valid organization_id

                this.loading = true;
                this.errors = [];
                this.importProgress = 0;

                const response = await axios.post(
                    "/api/assets/import",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.token}`,
                        },
                        onUploadProgress: (progressEvent) => {
                            const percentCompleted = Math.round(
                                (progressEvent.loaded * 100) /
                                    progressEvent.total
                            );
                            this.importProgress = percentCompleted;
                        },
                    }
                );

                console.log("Import response:", response.data); // Debug log

                if (response.data.success) {
                    this.$swal({
                        title: "Success!",
                        text: `Successfully imported ${response.data.imported_count} assets.`,
                        icon: "success",
                    });
                    this.$router.push("/admin-panel/asset-list");
                } else {
                    this.errors = response.data.errors || [
                        "Unknown error occurred",
                    ];
                    this.$swal({
                        title: "Warning!",
                        text: `Import completed with ${this.errors.length} errors. Please check the error list below.`,
                        icon: "warning",
                    });
                }
            } catch (error) {
                console.error(
                    "Import error details:",
                    error.response?.data || error
                );

                // Handle different types of errors
                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors || [
                        error.response.data.message,
                    ];
                } else {
                    this.errors = [
                        error.response?.data?.error ||
                            "Failed to import assets. Please try again.",
                    ];
                }

                this.$swal({
                    title: "Error!",
                    text: this.errors[0],
                    icon: "error",
                });
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        console.log("ImportAssets component mounted");
    },
};
</script>

<style scoped>
.progress {
    height: 20px;
}
.alert ul {
    padding-left: 20px;
}
</style>
