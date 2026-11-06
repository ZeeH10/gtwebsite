import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                // Wide, heavy display face: echoes the extended "FELLOWSHIP" lettering in the logo
                bunny('Unbounded', { weights: [600, 800] }),
                bunny('Archivo', { weights: [400, 500, 600, 700] }),
                bunny('Source Serif 4', { weights: [400], styles: ['italic'] }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
