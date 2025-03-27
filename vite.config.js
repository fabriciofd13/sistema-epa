import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        })
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
    },
    resolve: {
        alias: {
            'admin-lte': '/node_modules/admin-lte'
        }
    }
});
