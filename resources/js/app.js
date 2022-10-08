import './bootstrap';
import '../css/app.css'

import 'flowbite';
import Select2 from 'vue3-select2-component';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Salert from 'sweetalert2'
import mitt from 'mitt'

const emitter = mitt();
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .component('Select2', Select2)
            .component('SweetAlert', Salert)
            .provide('emitter', emitter)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
