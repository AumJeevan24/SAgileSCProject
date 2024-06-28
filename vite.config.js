const { defineConfig } = await import("vite")
const laravel = await import('laravel-vite-plugin');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        watch: {
            usePolling: true
        }
    },
});
