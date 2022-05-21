require('./bootstrap');

import 'flowbite'
import './index.css'
import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import moment from 'moment'
// import Echo from 'laravel-echo'
// import Pusher from "pusher-js"

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: "f2b137cb07ca05e3200f",
//     cluster: "ap1",
//     encrypted: true
// });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#6c2bd9' });
moment.locale('id')

document.addEventListener("dom-reload", function() {
  Tooltip.start();
});
