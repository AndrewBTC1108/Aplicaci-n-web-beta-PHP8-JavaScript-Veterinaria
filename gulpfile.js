const { src, dest, watch, series } = require('gulp');

// Compilar CSS
const sass = require('gulp-sass')(require('sass'));
const purgecss = require('gulp-purgecss');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss')
const cssnano = require('cssnano');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const webpack = require('webpack-stream');
const path = require('path');

// Imagenes
const imagemin = require('gulp-imagemin');

//javascript
const terser = require('gulp-terser-js');

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
}

function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/css'));
}

function javascript() {
    return src('src/js/app.js')
        .pipe(webpack({
            entry: './src/js/app.js',
            output: {
                filename: 'bundle.js',
                path: path.resolve(__dirname, 'public/build/js')
            },
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        exclude: /node_modules/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            mode: 'production'
        }))
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('./public/build/js'))
}

function cssbuild(done) {
    src('build/css/app.css')
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(purgecss({
            content: ['index.html', 'base.html', 'blog.html', 'entrada.html', 'nosotros.html', 'producto.html', 'tienda.html']
        }))
        .pipe(dest('public/build/css'))

    done();
}

function dev(done) {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    done();
}

function imagenes(done) {
    src('src/img/**/*')
        .pipe(imagemin({ optimizationLevel: 3 }))
        .pipe(dest('public/build/img'))
    done();
}

exports.css = css;
exports.dev = dev;
exports.js = javascript;
exports.imagenes = imagenes;
exports.default = series(imagenes, css, javascript, dev);
exports.build = series(cssbuild);