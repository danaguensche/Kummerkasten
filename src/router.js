import { createRouter, createWebHistory } from 'vue-router';
import KummerkastenPage from './components/pages/KummerkastenPage.vue';
import Info from './components/Home/Info.vue';
import Form from './components/Home/Form.vue';
import QR from './components/Home/QR.vue';

const routes = [{
        path: '/home' || '/',
        name: 'Home',
        component: KummerkastenPage
    },
    {
        path: '/info',
        name: 'Info',
        component: Info
    },
    {
        path: '/form',
        name: 'Form',
        component: Form
    },
    {
        path: '/qr',
        name: 'qr',
        component: QR
    }

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;