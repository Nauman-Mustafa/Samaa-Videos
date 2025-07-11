<template>
    <div class="admin-panel">
        <div id="wrapper">
            <RightNavbar />
            <TopNavbar />

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <div class="container-fluid content-container">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TopNavbar from "./topNavbar.vue";
import RightNavbar from "./rightNavbar.vue";
import "../../css/Adminpanel.css";
export default {
    components: {
        TopNavbar,
        RightNavbar,
    },
    data() {
        return {};
    },
};
</script>

<style>
/* Ensure admin-panel styles are globally available */
.admin-panel {
    min-height: 100vh;
    width: 100%;
}
</style>

<style scoped>
.content-container {
    padding: 1.5rem;
    width: calc(100% - 14rem); /* Match sidebar width */
    margin-left: 14rem;
}

@media (max-width: 768px) {
    .content-container {
        width: calc(100% - 6.5rem);
        margin-left: 6.5rem;
    }
}
</style>
