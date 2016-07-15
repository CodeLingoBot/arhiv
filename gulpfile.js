'use strict';
require('es6-promise').polyfill();
var gulp = require('gulp');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');

/*** CSS TASKS ***/

gulp.task('watchCss', function() {
  gulp.watch('css/dev/*.css', ['minifyCss']);
});

gulp.task('concatCss', function() {
  return gulp.src('css/dev/*.css')
    .pipe(sourcemaps.init())
    .pipe(concat('style.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('css/dist'));
});

gulp.task('minifyCss', ['concatCss'], function() {
  return gulp.src('css/dist/style.css')
    .pipe(autoprefixer('last 2 version', 'ie 9'))
    .pipe(cleanCSS())
    .pipe(rename('style.min.css'))
    .pipe(gulp.dest('css/dist'));
});

/*** COMMON TASKS ***/

gulp.task('default', ['watchCss']);
