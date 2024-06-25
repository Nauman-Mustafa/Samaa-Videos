<template>
    <div class="latest-videos-carousel card">
        <h5 class="latest-videos-title px-4 py-1">Latest Videos</h5>
      
        <Carousel :value="latestVideos" :numVisible="4" :numScroll="4" :responsiveOptions="responsiveOptions">
           
            <template #item="slotProps">
                <div class="video-item m-2 p-2">
                    <img :src="slotProps.data.image" :alt="slotProps.data.title" class="video-image" />
                    <div class="video-title mt-2">{{ slotProps.data.title }}</div>
                </div>
            </template>
        </Carousel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Carousel from 'primevue/carousel';

const latestVideos = ref([]);
const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 4,
        numScroll: 4
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 3
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 2
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const dummyVideos = [
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'Those holding press conferences are pardoned, others targeted; everybody knows facts: Justice Minallah', image: 'https://www.samaa.tv//images//supreme-court-sic-reserved-seats.jpg' },
    { title: 'Human milk bank in Karachi suspended following new fatwa', image: 'https://www.samaa.tv/images/human-milk-bank-karachi-pakistan.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
    { title: 'Those holding press conferences are pardoned, others targeted; everybody knows facts: Justice Minallah', image: 'https://www.samaa.tv//images//supreme-court-sic-reserved-seats.jpg' },
    { title: 'Human milk bank in Karachi suspended following new fatwa', image: 'https://www.samaa.tv/images/human-milk-bank-karachi-pakistan.jpg' },
    { title: 'T20 World Cup: South Africa triumph over West Indies to move into semis', image: 'https://www.samaa.tv/images/t20-world-cup-south-africa.jpg' },
];

onMounted(() => {
    latestVideos.value = dummyVideos;
});
</script>

<style scoped>
.latest-videos-carousel {
    width: 100%;
    background-color: rgb(29, 29, 95);
    border-radius: 15px;
}
.latest-videos-title {
    color: white;
}
.video-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    /* border: 1px solid #ccc; */
    border-radius: 8px;
}

.video-image {
    width: 100%; /* Adjust the size of the image */
    height: auto; /* Maintain aspect ratio */
    border-radius: 8px;
}

.video-title {
    font-size: 0.8rem;
    text-align: left;
    color: white;
    margin-top: 8px;
    height: 80px;
}
</style>
