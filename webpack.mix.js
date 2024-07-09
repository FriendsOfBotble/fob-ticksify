const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `platform/plugins/${directory}`
const dist = `public/vendor/core/plugins/${directory}`

mix
    .sass(`${source}/resources/sass/ticksify.scss`, `${dist}/css`)
    .sass(`${source}/resources/sass/front-ticksify.scss`, `${dist}/css`)
    .js(`${source}/resources/js/front-ticksify.js`, `${dist}/js`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/css/ticksify.css`, `${source}/public/css`)
        .copy(`${dist}/css/front-ticksify.css`, `${source}/public/css`)
        .copy(`${dist}/js/front-ticksify.js`, `${source}/public/js`)
}
