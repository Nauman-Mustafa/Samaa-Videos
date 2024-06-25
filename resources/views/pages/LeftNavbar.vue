<template>
    <div class="left-navbar">
        <ul class="nav flex-column px-4 align-items-left">
            <li class="nav-item">
                <a class="nav-link active" href="#">Home</a>
            </li>
            <li v-for="category in categories" :key="category.id" class="nav-item">
                <a class="nav-link" :href="'/' + category.slug">{{ category.name }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LeftNavbar',
    data() {
        return {
            categories: []
        };
    },
    created() {
        this.fetchCategories();
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/get-categories');
                this.categories = response.data;
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        }
    }
};
</script>

<style scoped>
.left-navbar {
    width: 250px;
    position: fixed;
    top: 56px; /* height of top navbar */
    bottom: 0;
    overflow-y: auto;
    background-color: #dbe2e6;
    border-right: 1px solid #ddd;
    padding-top: 15px;
}
.nav-link {
    color: rgb(17, 17, 138);
    font-weight: 500;
    padding: 15px 20px;
}
.nav-link.active {
    font-weight: bold;
    background-color: #e9ecef;
}
.nav-link:hover {
    background-color: #e9ecef;
}
</style>
