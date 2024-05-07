<template>
       <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <router-link to="/" class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">SAMAA VIDEOS <sup></sup></div>
    </router-link>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" :class="{ 'active': $route.path === '/' }">
      <router-link to="/admin-panel" class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </router-link>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
       VIDEOS
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item" :class="{ 'active': isComponentActive }">
      <a class="nav-link collapsed d-flex justify-content-between align-items-center" @click="toggleComponentCollapse" :aria-expanded="isComponentCollapseExpanded.toString()" aria-controls="collapseTwo">
        <span>Components</span>
        <i class="fas fa-chevron-right fa-sm ml-2" :class="{ 'rotate-icon': isComponentCollapseExpanded }"></i>
      </a>
      <div class="collapse" :class="{ 'show': isComponentCollapseExpanded }" id="collapseTwo" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Custom Components:</h6>
          <router-link to="/buttons" class="collapse-item">Buttons</router-link>
          <router-link to="/cards" class="collapse-item">Cards</router-link>
        </div>
      </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item" :class="{ 'active': isUtilitiesActive }">
      <a class="nav-link collapsed d-flex justify-content-between align-items-center" @click="toggleUtilitiesCollapse" :aria-expanded="isUtilitiesCollapseExpanded.toString()" aria-controls="collapseUtilities">
        <span>Utilities</span>
        <i class="fas fa-chevron-right fa-sm ml-2" :class="{ 'rotate-icon': isUtilitiesCollapseExpanded }"></i>
      </a>
      <div class="collapse" :class="{ 'show': isUtilitiesCollapseExpanded }" id="collapseUtilities" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Custom Utilities:</h6>
          <router-link to="/utilities-color" class="collapse-item">Colors</router-link>
          <router-link to="/utilities-border" class="collapse-item">Borders</router-link>
          <router-link to="/utilities-animation" class="collapse-item">Animations</router-link>
          <router-link to="/utilities-other" class="collapse-item">Other</router-link>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Settings
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item" :class="{ 'active': isPagesActive }">
      <a class="nav-link collapsed d-flex justify-content-between align-items-center" @click="togglePagesCollapse" :aria-expanded="isPagesCollapseExpanded.toString()" aria-controls="collapsePages">
        <span>Users</span>
        <i class="fas fa-chevron-right fa-sm ml-2" :class="{ 'rotate-icon': isPagesCollapseExpanded }"></i>
      </a>
      <div class="collapse" :class="{ 'show': isPagesCollapseExpanded }" id="collapsePages" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Login Screens:</h6> -->
          <router-link to="/admin-panel/user-setting" class="collapse-item">Users List</router-link>
          <router-link to="/admin-panel/login" class="collapse-item">Login</router-link>
          <router-link to="/forgot-password" class="collapse-item">Forgot Password</router-link>
          <div class="collapse-divider"></div>
          <h6 class="collapse-header">Other Pages:</h6>
          <router-link to="/404" class="collapse-item">404 Page</router-link>
          <router-link to="/blank" class="collapse-item">Blank Page</router-link>
        </div>
      </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
      <router-link to="/charts" class="nav-link">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span>
      </router-link>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
      <router-link to="/tables" class="nav-link">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span>
      </router-link>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

    <!-- Sidebar Message -->
  
  </ul>

</template>
<script>
export default {
data() {
  return {
    isComponentCollapseExpanded: false,
    isUtilitiesCollapseExpanded: false,
    isPagesCollapseExpanded: false,
  };
},
computed: {
  isComponentActive() {
    return this.$route.path === '/buttons' || this.$route.path === '/cards';
  },
  isUtilitiesActive() {
    return this.$route.path === '/utilities-color' || this.$route.path === '/utilities-border' || this.$route.path === '/utilities-animation' || this.$route.path === '/utilities-other';
  },
  isPagesActive() {
    return this.$route.path === '/login' || this.$route.path === '/register' || this.$route.path === '/forgot-password' || this.$route.path === '/404' || this.$route.path === '/blank';
  }
},
methods: {
  toggleComponentCollapse() {
    this.isComponentCollapseExpanded = !this.isComponentCollapseExpanded;
  },
  toggleUtilitiesCollapse() {
    this.isUtilitiesCollapseExpanded = !this.isUtilitiesCollapseExpanded;
  },
  togglePagesCollapse() {
    this.isPagesCollapseExpanded = !this.isPagesCollapseExpanded;
  }
}
};
</script>