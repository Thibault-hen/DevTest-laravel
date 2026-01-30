import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig, loadEnv } from 'vite';

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  const isDocker = env.VITE_DOCKER === 'true';
  return {
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './resources/js'),
      },
    },
    plugins: [
      laravel({
        input: ['resources/js/app.ts'],
        ssr: 'resources/js/ssr.ts',
        refresh: true,
      }),
      tailwindcss(),
      wayfinder({
        formVariants: true,
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
    server: {
      host: '0.0.0.0',
      port: 5173,
      strictPort: true,
      hmr: isDocker
        ? {
            host: 'localhost',
            port: 5173,
          }
        : true,
      watch: {
        usePolling: true,
        ignored: ['**/node_modules/**', '**/vendor/**'],
      },
    },
  };
});
