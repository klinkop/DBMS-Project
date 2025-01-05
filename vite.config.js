import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/main.css',
                'resources/css/material-dashboard.css',
                'resources/js/material-dashboard.min.js',
                'resources/css/nucleo-icons.css',
                'resources/css/nucleo-svg.css'
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // Ensure this matches where you want your build files
    },
});
