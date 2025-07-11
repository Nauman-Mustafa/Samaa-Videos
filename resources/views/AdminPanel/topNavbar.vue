<template>
    <nav
        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
    >
        <!-- Sidebar Toggle (Topbar) -->
        <button
            id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3"
        >
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
        <!-- <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
        >
            <div class="input-group">
                <input
                    type="text"
                    class="form-control bg-light border-0 small"
                    placeholder="Search for..."
                    aria-label="Search"
                    aria-describedby="basic-addon2"
                />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form> -->

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="searchDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div
                    class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown"
                >
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control bg-light border-0 small"
                                placeholder="Search for..."
                                aria-label="Search"
                                aria-describedby="basic-addon2"
                            />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    @click.prevent="toggleDropdown('alerts')"
                >
                    <i class="fas fa-bell fa-fw"></i>
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div
                    class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    :class="{ show: dropdowns.alerts }"
                >
                    <h6 class="dropdown-header">Alerts Center</h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">
                                December 12, 2019
                            </div>
                            <span class="font-weight-bold"
                                >A new monthly report is ready to
                                download!</span
                            >
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">
                                December 7, 2019
                            </div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i
                                    class="fas fa-exclamation-triangle text-white"
                                ></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">
                                December 2, 2019
                            </div>
                            Spending Alert: We've noticed unusually high
                            spending for your account.
                        </div>
                    </a>
                    <a
                        class="dropdown-item text-center small text-gray-500"
                        href="#"
                        >Show All Alerts</a
                    >
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    @click.prevent="toggleDropdown('messages')"
                >
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages -->
                <div
                    class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    :class="{ show: dropdowns.messages }"
                >
                    <h6 class="dropdown-header">Message Center</h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="" alt="..." />
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">
                                Hi there! I am wondering if you can help me with
                                a problem I've been having.
                            </div>
                            <div class="small text-gray-500">
                                Emily Fowler · 58m
                            </div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="" alt="..." />
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">
                                I have the photos that you ordered last month,
                                how would you like them sent to you?
                            </div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="" alt="..." />
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">
                                Last month's report looks great, I am very happy
                                with the progress so far, keep up the good work!
                            </div>
                            <div class="small text-gray-500">
                                Morgan Alvarez · 2d
                            </div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img
                                class="rounded-circle"
                                src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                alt="..."
                            />
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">
                                Am I a good boy? The reason I ask is because
                                someone told me that people say this to all
                                dogs, even if they aren't good...
                            </div>
                            <div class="small text-gray-500">
                                Chicken the Dog · 2w
                            </div>
                        </div>
                    </a>
                    <a
                        class="dropdown-item text-center small text-gray-500"
                        href="#"
                        >Read More Messages</a
                    >
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    @click.prevent="toggleDropdown('user')"
                >
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{
                            currentUser
                                ? `${currentUser.first_name} ${currentUser.last_name}`
                                : "Loading..."
                        }}
                    </span>
                    <div
                        class="img-profile rounded-circle bg-gray-100 d-flex align-items-center justify-content-center"
                    >
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                </a>
                <!-- Dropdown - User Information -->
                <div
                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    :class="{ show: dropdowns.user }"
                >
                    <a class="dropdown-item" href="#">
                        <i
                            class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i
                            class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i
                            class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.prevent="handleLogout"
                    >
                        <i
                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                        ></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>
<script>
import axios from "axios";
import { mapActions } from "vuex";
import { getToken } from "../../../src/helpers/tokenhelper";

export default {
    data() {
        return {
            currentUser: null,
            isComponentCollapseExpanded: false,
            isUtilitiesCollapseExpanded: false,
            isPagesCollapseExpanded: false,
            dropdowns: {
                alerts: false,
                messages: false,
                user: false,
            },
        };
    },
    computed: {
        token() {
            return getToken();
        },
        isComponentActive() {
            return (
                this.$route.path === "/buttons" || this.$route.path === "/cards"
            );
        },
        isUtilitiesActive() {
            return (
                this.$route.path === "/utilities-color" ||
                this.$route.path === "/utilities-border" ||
                this.$route.path === "/utilities-animation" ||
                this.$route.path === "/utilities-other"
            );
        },
        isPagesActive() {
            return (
                this.$route.path === "/login" ||
                this.$route.path === "/register" ||
                this.$route.path === "/forgot-password" ||
                this.$route.path === "/404" ||
                this.$route.path === "/blank"
            );
        },
    },
    methods: {
        ...mapActions(["logout"]),
        async fetchCurrentUser() {
            try {
                const response = await axios.get("/api/current-user", {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                    },
                });
                this.currentUser = response.data;
            } catch (error) {
                console.error("Error fetching current user:", error);
            }
        },
        toggleComponentCollapse() {
            this.isComponentCollapseExpanded =
                !this.isComponentCollapseExpanded;
        },
        toggleUtilitiesCollapse() {
            this.isUtilitiesCollapseExpanded =
                !this.isUtilitiesCollapseExpanded;
        },
        togglePagesCollapse() {
            this.isPagesCollapseExpanded = !this.isPagesCollapseExpanded;
        },
        toggleDropdown(type) {
            // Close all other dropdowns
            Object.keys(this.dropdowns).forEach((key) => {
                if (key !== type) this.dropdowns[key] = false;
            });
            // Toggle the clicked dropdown
            this.dropdowns[type] = !this.dropdowns[type];
        },
        async handleLogout() {
            try {
                await this.logout();
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
        closeAllDropdowns() {
            Object.keys(this.dropdowns).forEach((key) => {
                this.dropdowns[key] = false;
            });
        },
    },
    mounted() {
        this.fetchCurrentUser();
        // Close dropdowns when clicking outside
        document.addEventListener("click", (e) => {
            if (!this.$el.contains(e.target)) {
                this.closeAllDropdowns();
            }
        });
    },
    beforeUnmount() {
        // Clean up event listener
        document.removeEventListener("click", this.closeAllDropdowns);
    },
};
</script>

<style scoped>
.img-profile {
    width: 2rem;
    height: 2rem;
}
.img-profile i {
    font-size: 1rem;
}
</style>
