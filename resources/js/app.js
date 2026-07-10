import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Vue3Toastify from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(Vue3Toastify, {
        autoClose: 3000,
        // position: 'top-right',
      })
      .mount(el)
  },
})
