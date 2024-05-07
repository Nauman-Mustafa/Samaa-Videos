<template>
   <div class="admin-panel">

      <div id="wrapper">
        <RightNavbar />



        <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">
    
    <TopNavbar />

<div class="container-fluid">
    <router-view></router-view>

</div>

     </div>
    </div>


</div>
</div>

</template>
<script>
import TopNavbar from './topNavbar.vue';
import RightNavbar from './rightNavbar.vue';

export default {
    components: {
    TopNavbar, 
    RightNavbar,
  },
  data() {
    return {
   
    };
  },
  
};
</script>
<style src=".../../resources/css/Adminpanel.css" ></style>
