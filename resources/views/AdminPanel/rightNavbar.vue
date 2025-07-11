<template>
    <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
    >
        <!-- Sidebar - Brand -->
        <router-link
            to="/"
            class="sidebar-brand d-flex flex-column align-items-center justify-content-center py-4"
        >
            <div class="sidebar-brand-icon mb-1">
                <img
                    src="../../../public/images/sama-white.png"
                    alt="SAMAA Logo"
                    style="width: 100px; height: auto; margin-top: 20px"
                />
            </div>
            <div class="sidebar-brand-text text-center">
                <div class="font-weight-bold">Asset Management</div>
            </div>
        </router-link>

        <!-- Divider -->
        <hr class="sidebar-divider mt-4 mb-2" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item" :class="{ active: $route.path === '/' }">
            <router-link to="/" class="nav-link">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Management</div>

        <!-- Inventory Section -->
        <li class="nav-item" :class="{ active: isInventoryActive }">
            <a
                class="nav-link collapsed d-flex justify-content-between align-items-center"
                @click="toggleInventoryCollapse"
                :aria-expanded="isInventoryCollapseExpanded.toString()"
                aria-controls="collapseInventory"
            >
                <span>Inventory</span>
                <i
                    class="fas fa-chevron-right fa-sm ml-2"
                    :class="{ 'rotate-icon': isInventoryCollapseExpanded }"
                ></i>
            </a>
            <div
                class="collapse"
                :class="{ show: isInventoryCollapseExpanded }"
                id="collapseInventory"
            >
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Asset Management:</h6>
                    <router-link to="/add-asset" class="collapse-item"
                        >Add Asset</router-link
                    >
                    <router-link to="/asset-list" class="collapse-item"
                        >Asset List</router-link
                    >
                    <router-link to="/import-assets" class="collapse-item"
                        >Import Assets</router-link
                    >
                    <router-link to="/organizations" class="collapse-item"
                        >Organizations</router-link
                    >
                </div>
            </div>
        </li>

        <!-- Categories Section -->
        <li class="nav-item" :class="{ active: isUtilitiesActive }">
            <a
                class="nav-link collapsed d-flex justify-content-between align-items-center"
                @click="toggleUtilitiesCollapse"
                :aria-expanded="isUtilitiesCollapseExpanded.toString()"
                aria-controls="collapseUtilities"
            >
                <span>Categories</span>
                <i
                    class="fas fa-chevron-right fa-sm ml-2"
                    :class="{ 'rotate-icon': isUtilitiesCollapseExpanded }"
                ></i>
            </a>
            <div
                class="collapse"
                :class="{ show: isUtilitiesCollapseExpanded }"
                id="collapseUtilities"
            >
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Categories:</h6>
                    <router-link to="/add-category" class="collapse-item"
                        >Add Categories</router-link
                    >
                    <router-link to="/category-list" class="collapse-item"
                        >Categories List</router-link
                    >
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Settings</div>

        <!-- Users Section -->
        <li class="nav-item" :class="{ active: isPagesActive }">
            <a
                class="nav-link collapsed d-flex justify-content-between align-items-center"
                @click="togglePagesCollapse"
                :aria-expanded="isPagesCollapseExpanded.toString()"
                aria-controls="collapsePages"
            >
                <span>Users</span>
                <i
                    class="fas fa-chevron-right fa-sm ml-2"
                    :class="{ 'rotate-icon': isPagesCollapseExpanded }"
                ></i>
            </a>
            <div
                class="collapse"
                :class="{ show: isPagesCollapseExpanded }"
                id="collapsePages"
            >
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link to="/add-user" class="collapse-item"
                        >Add Users</router-link
                    >
                    <router-link to="/user-list" class="collapse-item"
                        >User List</router-link
                    >
                </div>
            </div>
        </li>

        <!-- Search -->
        <li class="nav-item">
            <router-link to="/search" class="nav-link">
                <i class="fas fa-fw fa-search"></i>
                <span>Search</span>
            </router-link>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <div @click="handleLogout" class="nav-link" style="cursor: pointer">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Log-Out</span>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <!-- <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

        <!-- Sidebar Message -->
    </ul>
</template>
<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            isUtilitiesCollapseExpanded: false,
            isPagesCollapseExpanded: false,
            isInventoryCollapseExpanded: false,
        };
    },
    computed: {
        isUtilitiesActive() {
            return this.$route.path.includes("/category");
        },
        isPagesActive() {
            return this.$route.path.includes("/user");
        },
        isInventoryActive() {
            return (
                this.$route.path.includes("/asset") ||
                this.$route.path === "/organizations"
            );
        },
    },
    methods: {
        ...mapActions(["logout"]),
        toggleUtilitiesCollapse() {
            this.isUtilitiesCollapseExpanded =
                !this.isUtilitiesCollapseExpanded;
        },
        togglePagesCollapse() {
            this.isPagesCollapseExpanded = !this.isPagesCollapseExpanded;
        },
        toggleInventoryCollapse() {
            this.isInventoryCollapseExpanded =
                !this.isInventoryCollapseExpanded;
        },
        async handleLogout() {
            try {
                await this.logout();
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
    },
};
</script>

<style scoped>
.rotate-icon {
    transform: rotate(90deg);
    transition: transform 0.3s;
}

/* Add these styles */
#accordionSidebar {
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Ensure dropdown menus stay within viewport */
.collapse-inner {
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}
</style>
