import { defineConfig } from 'vite';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';

export default defineConfig({
  css: {
    postcss: {
      plugins: [
        autoprefixer(),
        cssnano({ preset: 'default' })
      ]
    }
  },
  build: {
    outDir: '../views',
    rollupOptions: {
      input: {
        main: 'src/js/index.ts',
        styles: 'src/css/styles.css'
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name?.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'assets/[name][extname]';
        }
      }
    },
    target: 'es2018',
  }
});
