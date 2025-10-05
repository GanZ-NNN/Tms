import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style.css',
                'resources/css/home.css',
                'resources/css/admin.css',
                'resources/js/app.js',
                'resources/js/main.js',
                'resources/js/config.js',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
});
