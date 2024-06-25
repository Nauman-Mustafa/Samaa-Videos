<!-- MainLayout.vue -->
<template>
    <div class="homepage">
      <TopNavbar />
      <div class="d-flex">
        <LeftNavbar />
        <div class="content-container">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import TopNavbar from './TopNavbar.vue';
  import LeftNavbar from './LeftNavbar.vue';
  
  export default {

    components: {
      TopNavbar,
      LeftNavbar
    }
  }
  </script>
  
  <style scoped>
  .homepage{
    background-color: #dbe2e6;

  }
  .content-container {
    margin-left: 250px; 
    padding: 20px;
    width: 100%;
  }
  </style>
  