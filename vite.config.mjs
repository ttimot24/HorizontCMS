import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { createRequire } from 'module'
import path from 'path'

const require2 = createRequire(import.meta.url)
const vuePluginModule = require2('vite-plugin-vue2')

export default defineConfig({
  build: {
    outDir: 'resources/public',
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      output: {
        // Minden JS, CSS és asset ide kerül: resources/public/assets/
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]',
      }
    }
  },
  plugins: [
    vuePluginModule.createVuePlugin(
        {

            template: {

                transformAssetUrls: {

                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,

                },

            },

        }
    ),
    laravel({
      input: [
        'resources/vue/ts/main.ts',
        'resources/vue/ts/app.ts',
        'resources/vue/ts/pages.ts',
        'resources/vue/ts/dragndrop.js',
        'resources/vue/scss/horizontcms-next.scss',
      ],
      refresh: true,
    })
  ],
  resolve: {
    alias: {
      '@': path.resolve('./resources/vue/ts'),
    },
  },
})
