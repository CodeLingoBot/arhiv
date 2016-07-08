'use strict';
require('es6-promise').polyfill();
var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');

/*** CSS TASKS ***/

gulp.task('watchCss', function() {
  gulp.watch('css/dev/*.css', ['uglifyCss']);
});

gulp.task('concatCss', function() {
  return gulp.src('css/dev/*.css')
    .pipe(concat('style.css'))
    .pipe(gulp.dest('css/dist'));
});

gulp.task('uglifyCss', ['concatCss'], function() {
  return gulp.src('css/dist/style.css')
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9'))
    .pipe(minifyCSS())
    .pipe(rename('style.min.css'))
    .pipe(gulp.dest('css/dist'));
});

/*** COMMON TASKS ***/

gulp.task('default', ['watchCss']);
