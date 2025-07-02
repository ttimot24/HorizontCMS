import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { createRequire } from 'module'
import path from 'path'

const require2 = createRequire(import.meta.url)
const vuePluginModule = require2('vite-plugin-vue2')

export default defineConfig({
  build: {
    outDir: 'resources/public',
  //  assetsDir: 'resources/assets',
  },
  plugins: [
    vuePluginModule.createVuePlugin(),
    laravel({
      input: [
        'resources/vue/ts/main.ts',
        'resources/vue/ts/app.ts',
        'resources/vue/ts/pages.ts',
        'resources/vue/ts/dragndrop.js',
        'resources/vue/sass/horizontcms-next.scss',
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
