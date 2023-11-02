import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/main.scss',
                'resources/sass/oneui/themes/amethyst.scss',
                'resources/sass/oneui/themes/city.scss',
                'resources/sass/oneui/themes/flat.scss',
                'resources/sass/oneui/themes/modern.scss',
                'resources/sass/oneui/themes/smooth.scss',
                'resources/js/oneui/app.js',
                'resources/js/app.js',
                'resources/js/pages/datatables.js',
                'resources/js/pages/slick.js',
            ],
            refresh: true,
        }),
    ],
});
