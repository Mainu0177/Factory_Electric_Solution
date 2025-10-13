Inertia installation for server side
Install composer inertia.js => composer require inertiajs/inertia-laravel
include this code in views folder = views>app.blade.php=>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/app.js')
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
middleware install command=> php artisan inertia:middleware
Register middleware=> in bootstrap/app.php>
use App\Http\Middleware\HandleInertiaRequests;

->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        HandleInertiaRequests::class,
    ]);
})

Inertia installation for Client side
installation command=> npm install @inertiajs/vue3

using route=> import resources/js/app.js => import { router } from '@inertiajs/vue3'

Configure vite command => npm i @vitejs/plugin-vue
import vite.config.js =>
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
// import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        // tailwindcss(),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
    },
});

Install vue => npm i vue
import resources/js/app.js =>
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
Vue js front end structure inside resources/js/
Components,Pages,Utility

How to set Routing progress Like vue js => npm i nprogress
resources/view/app.blade.php
<link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css')}}" />
Add Route Start End of @app.js
Added resources/js/app.js
import NProgress from 'nprogress'

router.on('start', () => {
    NProgress.start()
})

router.on('finish', () =>{
    NProgress.done()
})

1. Toast Notifications: @meforma/vue-toaster
npm i @meforma/vue-toaster
Use Case

import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({
    position: "top-right",
});

3. Data Table: vue3-easy-data-table
npm i vue3-easy-data-table
Import resources/js/app.js
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

setup({ el, App, props, plugin }) {
	const app = createApp({ render: () => h(App, props) })
	app.use(plugin)
	app.component('EasyDataTable', Vue3EasyDataTable)
	app.mount(el)
},

8. CSS Framework: bootstrap
npm i bootstrap
resources/js/app.js

import 'bootstrap/dist/css/bootstrap.min.css'
