import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import sass from 'vite-plugin-sass';

export default defineConfig({
    plugins: [
        sass(),
        laravel({
            input: [
                'resources/js/app.js',
                // 'resources/front/sass/1140_flex.css',
                // 'resources/front/sass/all.scss',
                // 'resources/front/sass/layout.scss',
                // 'resources/front/sass/libs.scss',
                // 'resources/front/sass/media.scss',
                // 'resources/front/sass/reset.css',

            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
