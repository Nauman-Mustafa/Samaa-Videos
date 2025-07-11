<template>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a
            href="#"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
            ><i class="fas fa-upload fa-sm text-white-50"></i> Add Videos</a
        >
    </div>

    <!-- Content Row -->

    <div>
        <!-- Statistics Cards Row -->
        <div class="row">
            <!-- Total Assets Card -->
            <div class="col-xl-3 col-md-6 mb-4">
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
                                    {{
                                        dashboardStats?.summary?.total_assets ||
                                        0
                                    }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-laptop fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Assets Card -->
            <div class="col-xl-3 col-md-6 mb-4">
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
                                    {{
                                        dashboardStats?.summary
                                            ?.active_assets || 0
                                    }}
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

            <!-- Maintenance Assets Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div
                    class="card border-left-warning shadow h-100 py-2 stats-card"
                >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                                >
                                    In Maintenance
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    {{
                                        dashboardStats?.summary
                                            ?.maintenance_assets || 0
                                    }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tools fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Value Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 stats-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-info text-uppercase mb-1"
                                >
                                    Total Value
                                </div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800"
                                >
                                    ${{
                                        formatNumber(
                                            dashboardStats?.summary
                                                ?.total_value || 0
                                        )
                                    }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="fas fa-dollar-sign fa-2x opacity-50"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Category Distribution Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Assets by Category
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie">
                            <canvas ref="categoryPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Distribution Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Assets by Location
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas ref="locationBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Assets Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Recent Assets
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Asset Tag</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Added Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="asset in dashboardStats?.recentAssets"
                                        :key="asset.id"
                                    >
                                        <td>{{ asset.asset_tag }}</td>
                                        <td>{{ asset.majorCategory?.name }}</td>
                                        <td>{{ asset.location?.name }}</td>
                                        <td>
                                            <span
                                                :class="
                                                    'badge badge-' +
                                                    getStatusClass(asset.status)
                                                "
                                            >
                                                {{ asset.status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ formatDate(asset.created_at) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style src=".../../resources/css/Adminpanel.css"></style>

<script>
import Chart from "chart.js/auto";
import axios from "axios";
export default {
    data() {
        return {
            dashboardStats: null,
            charts: {
                categoryPie: null,
                locationBar: null,
            },
        };
    },
    async mounted() {
        await this.fetchDashboardStats();
        this.initializeCharts();
    },
    methods: {
        async fetchDashboardStats() {
            try {
                const response = await axios.get("/api/dashboard-stats");
                this.dashboardStats = response.data;
            } catch (error) {
                console.error("Failed to fetch dashboard stats:", error);
            }
        },
        initializeCharts() {
            if (!this.dashboardStats) return;

            // Initialize Category Pie Chart
            const categoryCtx = this.$refs.categoryPieChart.getContext("2d");
            this.charts.categoryPie = new Chart(categoryCtx, {
                type: "pie",
                data: {
                    labels: this.dashboardStats.assetsByCategory.map(
                        (item) => item.name
                    ),
                    datasets: [
                        {
                            data: this.dashboardStats.assetsByCategory.map(
                                (item) => item.total
                            ),
                            backgroundColor: [
                                "#4e73df",
                                "#1cc88a",
                                "#36b9cc",
                                "#f6c23e",
                                "#e74a3b",
                                "#858796",
                                "#5a5c69",
                                "#2e59d9",
                                "#17a673",
                                "#2c9faf",
                            ],
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            });

            // Initialize Location Bar Chart
            const locationCtx = this.$refs.locationBarChart.getContext("2d");
            this.charts.locationBar = new Chart(locationCtx, {
                type: "bar",
                data: {
                    labels: this.dashboardStats.assetsByLocation.map(
                        (item) => item.name
                    ),
                    datasets: [
                        {
                            label: "Number of Assets",
                            data: this.dashboardStats.assetsByLocation.map(
                                (item) => item.total
                            ),
                            backgroundColor: "#4e73df",
                            borderColor: "#4e73df",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                },
            });
        },
        formatNumber(number) {
            return new Intl.NumberFormat("en-US").format(number);
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },
        getStatusClass(status) {
            const statusMap = {
                done: "success",
                maintenance: "warning",
                inactive: "danger",
                delete: "secondary",
            };
            return statusMap[status.toLowerCase()] || "secondary";
        },
    },
    beforeUnmount() {
        // Cleanup charts
        Object.values(this.charts).forEach((chart) => {
            if (chart) chart.destroy();
        });
    },
};
</script>
