import { createApp } from 'vue';
import App from './App.vue';
import router from './routes';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css'; // theme
import 'primevue/resources/primevue.min.css'; // core css


createApp(App).use(router).use(VueSweetalert2).use(PrimeVue).mount('#app');
