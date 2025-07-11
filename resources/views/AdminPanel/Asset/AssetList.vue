<template>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Asset List</h1>
            <div>
                <router-link
                    to="/import-assets"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2"
                >
                    <i class="fas fa-file-import fa-sm text-white-50"></i>
                    Import Assets
                </router-link>
                <router-link
                    to="/add-asset"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                >
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add Asset
                </router-link>
            </div>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-left-primary shadow h-100 py-2 stats-card"
                >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                                >
                                    Total Assets
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    {{ assetStatistics.total_assets || 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-laptop fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-left-success shadow h-100 py-2 stats-card"
                >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-success text-uppercase mb-1"
                                >
                                    Active Assets
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    {{ assetStatistics.active_assets || 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="fas fa-check-circle fa-2x opacity-50"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-left-warning shadow h-100 py-2 stats-card"
                >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                                >
                                    Unuseable Assets
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    {{ assetStatistics.unuseable_assets || 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="fas fa-exclamation-triangle fa-2x opacity-50"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-left-danger shadow h-100 py-2 stats-card"
                >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-danger text-uppercase mb-1"
                                >
                                    Deleted Assets
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    {{ assetStatistics.deleted_assets || 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="fas fa-trash-alt fa-2x opacity-50"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Controls Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-4">
                            <!-- General Search -->
                            <div class="flex-grow-1" style="min-width: 250px">
                                <label class="form-label text-muted small mb-2"
                                    >Search Across All Fields</label
                                >
                                <div class="input-group">
                                    <input
                                        v-model="generalSearchTerm"
                                        type="text"
                                        class="form-control search-input"
                                        placeholder="Type to search..."
                                    />
                                    <button class="btn btn-primary px-4">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Column-Specific Search -->
                            <div class="flex-grow-1" style="min-width: 250px">
                                <label class="form-label text-muted small mb-2"
                                    >Search in Specific Columns</label
                                >
                                <MultiSelect
                                    v-model="selectedSearchColumns"
                                    :options="searchableColumns"
                                    optionLabel="label"
                                    placeholder="Select columns"
                                    class="w-100 custom-multiselect"
                                />
                            </div>

                            <div class="flex-grow-1" style="min-width: 250px">
                                <label class="form-label text-muted small mb-2"
                                    >Search Term</label
                                >
                                <div class="input-group">
                                    <input
                                        v-model="columnSearchTerm"
                                        type="text"
                                        class="form-control search-input"
                                        :placeholder="getSearchPlaceholder"
                                        :disabled="
                                            !selectedSearchColumns.length
                                        "
                                    />
                                    <button
                                        class="btn btn-primary px-4"
                                        :disabled="
                                            !selectedSearchColumns.length
                                        "
                                    >
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div v-if="selectedSearchColumns.length" class="mt-3">
                            <div
                                class="d-flex flex-wrap gap-2 align-items-center"
                            >
                                <span class="text-muted small"
                                    >Active Filters:</span
                                >
                                <span
                                    v-for="column in selectedSearchColumns"
                                    :key="column.field"
                                    class="badge bg-light text-primary border px-3 py-2"
                                >
                                    {{ column.label }}
                                    <i
                                        class="fas fa-times-circle ms-2 cursor-pointer"
                                        @click="removeSearchColumn(column)"
                                    ></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets Table -->
        <div class="card shadow border-0 mb-4">
            <div
                class="card-header bg-white py-3 d-flex justify-content-between align-items-center"
            >
                <h6 class="m-0 font-weight-bold text-primary">Assets List</h6>
                <div class="d-flex gap-3">
                    <!-- Import Button -->
                    <label
                        class="btn btn-primary btn-sm position-relative"
                        :class="{ disabled: isImporting }"
                    >
                        <span
                            v-if="isImporting"
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                        ></span>
                        <i v-else class="fas fa-upload me-2"></i>
                        {{ isImporting ? "Importing..." : "Import Assets" }}
                        <input
                            type="file"
                            class="d-none"
                            @change="handleFileImport"
                            accept=".xlsx,.xls,.csv"
                            :disabled="isImporting"
                        />
                    </label>

                    <!-- Export Button -->
                    <button
                        class="btn btn-success btn-sm"
                        @click="exportToExcel"
                        :disabled="isExporting"
                    >
                        <span
                            v-if="isExporting"
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                        ></span>
                        <i v-else class="fas fa-download me-2"></i>
                        {{ isExporting ? "Exporting..." : "Export Assets" }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <DataTable
                    v-if="!loading && !error"
                    :value="filteredAssets"
                    :paginator="true"
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    responsiveLayout="scroll"
                    class="custom-datatable"
                    stripedRows
                    showGridlines
                    :rowHover="true"
                    @row-click="showAssetDetails"
                    v-model:selection="selectedAsset"
                    selectionMode="single"
                    dataKey="id"
                >
                    <!-- Existing columns with updated styling -->
                    <Column field="asset_tag" header="Asset Tag" sortable>
                        <template #body="slotProps">
                            <span class="fw-medium">{{
                                slotProps.data.asset_tag
                            }}</span>
                        </template>
                    </Column>
                    <Column
                        field="description"
                        header="Description"
                        sortable
                    ></Column>
                    <Column
                        field="major_category"
                        header="Major Category"
                        sortable
                    ></Column>
                    <Column
                        field="minor_category"
                        header="Minor Category"
                        sortable
                    ></Column>
                    <Column
                        field="asset_company"
                        header="Asset Company"
                        sortable
                    ></Column>
                    <Column
                        field="location"
                        header="Location"
                        sortable
                    ></Column>
                    <Column
                        field="department"
                        header="Department"
                        sortable
                    ></Column>
                    <Column
                        field="model_no"
                        header="Model No."
                        sortable
                    ></Column>
                    <Column
                        field="serial_no"
                        header="Serial No."
                        sortable
                    ></Column>
                    <Column field="condition" header="Condition" sortable>
                        <template #body="slotProps">
                            <span
                                :class="
                                    'status-badge status-' +
                                    slotProps.data.condition.toLowerCase()
                                "
                            >
                                {{ slotProps.data.condition }}
                            </span>
                        </template>
                    </Column>
                    <Column field="status" header="Status" sortable>
                        <template #body="slotProps">
                            <span
                                :class="
                                    'status-badge status-' +
                                    slotProps.data.status.toLowerCase()
                                "
                            >
                                {{ slotProps.data.status }}
                            </span>
                        </template>
                    </Column>
                    <Column
                        header="Actions"
                        :exportable="false"
                        style="min-width: 100px"
                    >
                        <template #body="slotProps">
                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-sm btn-outline-primary"
                                    @click="editAsset(slotProps.data.id)"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="
                                        confirmDelete(
                                            slotProps.data.id,
                                            slotProps.data.description
                                        )
                                    "
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </template>
                    </Column>
                </DataTable>

                <div v-if="loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div v-if="error" class="alert alert-danger">
                    {{ error }}
                </div>
            </div>
        </div>

        <!-- Add this Dialog component after your table -->
        <Dialog
            v-model:visible="showAssetModal"
            :modal="true"
            :style="{ width: '50rem' }"
            :header="selectedAsset?.asset_tag || 'Asset Details'"
            class="p-fluid"
        >
            <div v-if="selectedAsset" class="asset-details">
                <!-- Asset Basic Info -->
                <div class="section-card mb-4">
                    <h5 class="section-title">Basic Information</h5>
                    <div class="grid">
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Asset Tag</label>
                                <p>{{ selectedAsset.asset_tag }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Description</label>
                                <p>{{ selectedAsset.description }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Asset Company</label>
                                <p>{{ selectedAsset.asset_company }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Model No</label>
                                <p>{{ selectedAsset.model_no || "N/A" }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Serial No</label>
                                <p>{{ selectedAsset.serial_no || "N/A" }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="section-card mb-4">
                    <h5 class="section-title">Categories</h5>
                    <div class="grid">
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Major Category</label>
                                <p>{{ selectedAsset.major_category }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Minor Category</label>
                                <p>{{ selectedAsset.minor_category }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location & Department -->
                <div class="section-card mb-4">
                    <h5 class="section-title">Location & Department</h5>
                    <div class="grid">
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Location</label>
                                <p>{{ selectedAsset.location }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Department</label>
                                <p>{{ selectedAsset.department }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="section-card mb-4">
                    <h5 class="section-title">Status Information</h5>
                    <div class="grid">
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Condition</label>
                                <span
                                    :class="
                                        'status-badge status-' +
                                        selectedAsset.condition.toLowerCase()
                                    "
                                >
                                    {{ selectedAsset.condition }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="detail-item">
                                <label>Status</label>
                                <span
                                    :class="
                                        'status-badge status-' +
                                        selectedAsset.status.toLowerCase()
                                    "
                                >
                                    {{ selectedAsset.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="section-card">
                    <h5 class="section-title">Additional Information</h5>
                    <div class="detail-item">
                        <label>Comments</label>
                        <p>
                            {{
                                selectedAsset.comments ||
                                "No comments available"
                            }}
                        </p>
                    </div>
                </div>
            </div>

            <template #footer>
                <div class="flex justify-content-end gap-2">
                    <Button
                        label="Edit"
                        icon="pi pi-pencil"
                        class="p-button-secondary"
                        @click="editAsset(selectedAsset.id)"
                    />
                    <Button
                        label="Close"
                        icon="pi pi-times"
                        class="p-button-primary"
                        @click="showAssetModal = false"
                    />
                </div>
            </template>
        </Dialog>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ProgressBar from "primevue/progressbar";
import { getToken } from "../../../../src/helpers/tokenhelper";
import MultiSelect from "primevue/multiselect";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

export default {
    components: {
        DataTable,
        Column,
        ProgressBar,
        MultiSelect,
        Dialog,
        Button,
    },
    data() {
        return {
            assets: [],
            searchTerm: "",
            loading: false,
            error: null,
            assetStatistics: {},
            selectedSearchColumns: [],
            searchableColumns: [
                { field: "asset_tag", label: "Asset Tag" },
                { field: "description", label: "Description" },
                { field: "major_category", label: "Major Category" },
                { field: "minor_category", label: "Minor Category" },
                { field: "asset_company", label: "Asset Company" },
                { field: "location", label: "Location" },
                { field: "department", label: "Department" },
                { field: "model_no", label: "Model No." },
                { field: "serial_no", label: "Serial No." },
                { field: "condition", label: "Condition" },
                { field: "status", label: "Status" },
            ],
            generalSearchTerm: "",
            columnSearchTerm: "",
            isExporting: false,
            isImporting: false,
            showAssetModal: false,
            selectedAsset: null,
        };
    },
    computed: {
        getSearchPlaceholder() {
            if (this.selectedSearchColumns.length === 0) {
                return "Select columns to search...";
            }
            return `Search in ${this.selectedSearchColumns
                .map((col) => col.label)
                .join(", ")}...`;
        },
        filteredAssets() {
            let assets = this.assets;

            // Apply general search if term exists
            if (this.generalSearchTerm?.trim()) {
                const generalSearchLower = this.generalSearchTerm.toLowerCase();
                assets = assets.filter((asset) => {
                    return Object.values(asset).some((value) => {
                        return (
                            value &&
                            String(value)
                                .toLowerCase()
                                .includes(generalSearchLower)
                        );
                    });
                });
            }

            // Apply column-specific search if columns are selected and term exists
            if (
                this.selectedSearchColumns.length > 0 &&
                this.columnSearchTerm?.trim()
            ) {
                const columnSearchLower = this.columnSearchTerm.toLowerCase();
                const searchFields = this.selectedSearchColumns.map(
                    (col) => col.field
                );

                assets = assets.filter((asset) => {
                    return searchFields.some((field) => {
                        try {
                            const fieldValue = asset[field];
                            return (
                                fieldValue &&
                                String(fieldValue)
                                    .toLowerCase()
                                    .includes(columnSearchLower)
                            );
                        } catch {
                            return false;
                        }
                    });
                });
            }

            return assets;
        },
        token() {
            return getToken();
        },
    },
    methods: {
        async fetchAssets() {
            this.loading = true;
            try {
                const response = await axios.get("/api/assets", {
                    headers: { Authorization: `Bearer ${this.token}` },
                });
                this.assets = response.data;
            } catch (error) {
                this.error = "Error fetching assets: " + error.message;
            } finally {
                this.loading = false;
            }
        },
        async fetchAssetStatistics() {
            try {
                const response = await axios.get("/api/asset-statistics", {
                    headers: { Authorization: `Bearer ${this.token}` },
                });
                this.assetStatistics = response.data;
            } catch (error) {
                console.error("Error fetching asset statistics:", error);
            }
        },
        editAsset(id) {
            this.$router.push(`/edit-asset/${id}`);
        },
        confirmDelete(id, name) {
            this.$swal({
                title: "Are you sure?",
                text: `You want to delete asset: ${name}!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteAsset(id);
                }
            });
        },
        async deleteAsset(id) {
            try {
                await axios.delete(`/api/assets/${id}`, {
                    headers: { Authorization: `Bearer ${this.token}` },
                });
                this.$swal("Deleted!", "Asset has been deleted.", "success");
                this.fetchAssets();
                this.fetchAssetStatistics();
            } catch (error) {
                this.$swal("Error!", "Failed to delete asset.", "error");
            }
        },
        getStatusClass(status) {
            const statusMap = {
                Active: "success",
                Inactive: "danger",
                Maintenance: "warning",
                Reserved: "info",
            };
            return statusMap[status] || "secondary";
        },
        getConditionClass(condition) {
            const conditionMap = {
                Done: "success",
                Pending: "warning",
                "In Progress": "info",
            };
            return conditionMap[condition] || "secondary";
        },
        removeSearchColumn(column) {
            this.selectedSearchColumns = this.selectedSearchColumns.filter(
                (col) => col.field !== column.field
            );
            if (this.selectedSearchColumns.length === 0) {
                this.columnSearchTerm = "";
            }
        },
        clearSearches() {
            this.generalSearchTerm = "";
            this.columnSearchTerm = "";
            this.selectedSearchColumns = [];
        },
        async handleFileImport(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.isImporting = true;
            const formData = new FormData();
            formData.append("file", file);
            formData.append(
                "organization_id",
                this.currentUser.organization_id
            );

            try {
                const response = await axios.post(
                    "/api/assets/import",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );

                if (response.data.success) {
                    this.$swal({
                        title: "Success!",
                        text: `Successfully imported ${response.data.imported_count} assets`,
                        icon: "success",
                    });
                    this.fetchAssets(); // Refresh the list
                } else {
                    this.$swal({
                        title: "Warning!",
                        text: response.data.message,
                        icon: "warning",
                    });
                }
            } catch (error) {
                this.$swal({
                    title: "Error!",
                    text: "Failed to import assets",
                    icon: "error",
                });
            } finally {
                this.isImporting = false;
                event.target.value = ""; // Reset file input
            }
        },
        async exportToExcel() {
            try {
                this.isExporting = true;

                const response = await axios.get("/api/assets/export", {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        Accept: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    },
                    responseType: "blob",
                });

                // Create download link
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute(
                    "download",
                    `assets_${new Date().toISOString().split("T")[0]}.xlsx`
                );
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                this.$swal({
                    title: "Success!",
                    text: "Assets exported successfully",
                    icon: "success",
                });
            } catch (error) {
                console.error("Export failed:", error);
                this.$swal({
                    title: "Error!",
                    text: "Failed to export assets",
                    icon: "error",
                });
            } finally {
                this.isExporting = false;
            }
        },
        showAssetDetails(event) {
            this.selectedAsset = event.data;
            this.showAssetModal = true;
        },
    },
    mounted() {
        this.fetchAssets();
        this.fetchAssetStatistics();
    },
};
</script>

<style scoped>
.stats-card {
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-card i {
    color: var(--primary-color);
    opacity: 0.2;
}

.search-input {
    border: 1px solid #e3e6f0;
    padding: 0.75rem 1rem;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.custom-datatable {
    --primary-color: #4e73df;
    --primary-color-light: #eaecf4;
}

.custom-datatable .p-datatable-header {
    background: white;
    border: none;
    padding: 1rem;
}

.custom-datatable .p-datatable-thead > tr > th {
    background: var(--primary-color-light);
    color: var(--primary-color);
    font-weight: 600;
    padding: 1rem;
}

.custom-datatable .p-datatable-tbody > tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f0f0f0;
}

.custom-datatable .p-datatable-tbody > tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.custom-datatable .p-datatable-tbody > tr > td {
    padding: 1rem;
    vertical-align: middle;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.status-done {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.status-useable {
    background-color: #e3f2fd;
    color: #1976d2;
}

.status-unuseable {
    background-color: #fbe9e7;
    color: #d84315;
}

.status-inactive {
    background-color: #fafafa;
    color: #616161;
}

.status-delete {
    background-color: #ffebee;
    color: #c62828;
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
}

.custom-multiselect {
    --ms-border-color: #e3e6f0;
    --ms-border-color-active: var(--primary-color);
    --ms-bg-color: white;
}

.cursor-pointer {
    cursor: pointer;
}

/* Enhanced table styling */
.custom-datatable .p-datatable-tbody > tr:not(:last-child) {
    position: relative;
}

.custom-datatable .p-datatable-tbody > tr:not(:last-child)::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        rgba(78, 115, 223, 0) 0%,
        rgba(78, 115, 223, 0.2) 50%,
        rgba(78, 115, 223, 0) 100%
    );
}

/* Statistics Cards */
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}

.border-left-danger {
    border-left: 4px solid #e74a3b !important;
}

.stats-card {
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stats-card .card-body {
    padding: 1.25rem;
}

.stats-card i {
    transition: all 0.3s ease;
}

.stats-card:hover i {
    transform: scale(1.1);
    opacity: 0.7;
}

/* Enhanced status badges */
.status-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Action buttons with hover effect */
.btn-sm {
    transition: all 0.3s ease;
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn {
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}

.btn:not(:disabled):hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-success {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.btn-success:hover {
    background-color: #169b6b;
    border-color: #169b6b;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

.section-card {
    background: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.section-title {
    color: var(--primary-color);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color-light);
}

.detail-item {
    margin-bottom: 1rem;
}

.detail-item label {
    display: block;
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.detail-item p {
    margin: 0;
    font-size: 1rem;
    color: #2d3748;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-block;
}

/* Add these to your existing status classes */
.status-done {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.status-useable {
    background-color: #e3f2fd;
    color: #1976d2;
}

.status-unuseable {
    background-color: #fbe9e7;
    color: #d84315;
}

.status-inactive {
    background-color: #fafafa;
    color: #616161;
}

.status-delete {
    background-color: #ffebee;
    color: #c62828;
}

:deep(.p-dialog-header) {
    border-bottom: 1px solid #e9ecef;
}

:deep(.p-dialog-footer) {
    border-top: 1px solid #e9ecef;
}

:deep(.p-datatable-tbody > tr) {
    cursor: pointer;
}

:deep(.p-datatable-tbody > tr:hover) {
    background-color: #f8f9fc !important;
}
</style>
