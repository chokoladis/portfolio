import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/profile.scss',
                'resources/scss/search.scss',
                'resources/scss/workers.scss',
                'resources/scss/works.scss',
                'resources/scss/admin/app.scss',
                'resources/scss/admin/menu.scss',
                'resources/scss/admin/workers.scss',
                'resources/scss/admin/works.scss',
                'resources/js/app.js',
                'resources/js/profile.js',
                'resources/js/workers.js',
                'resources/js/works.js',
                'resources/js/admin/app.js',
                'resources/js/admin/works.js',
            ],
            refresh: true,
        }),
    ],
});
