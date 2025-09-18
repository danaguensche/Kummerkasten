import { createRouter, createWebHistory } from 'vue-router';
import KummerkastenPage from './components/pages/KummerkastenPage.vue';

const routes = [{
        path: '/home',
        name: 'Home',
        component: KummerkastenPage

    }

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;