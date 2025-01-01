var gulp = require('gulp');
var runSequence = require('run-sequence');
var replace = require('gulp-replace');
var injectPartials = require('gulp-inject-partials');
var inject = require('gulp-inject');

/* Main Injection function Sequence */
gulp.task('inject', function() {
  runSequence('injectPartial' , 'replacePath');
});

/* Inject partials from partials folder */
gulp.task('injectPartial', function () {
  return gulp.src("./**/*.html", { base: "./" })
    .pipe(injectPartials())
    .pipe(gulp.dest("."));
});

/* Redirect internal paths to root */
gulp.task('replacePath', function(){
  gulp.src('pages/*/*.html', { base: "./" })
    .pipe(replace('src="assets/', 'src="../../assets/'))
    .pipe(replace('href="pages/', 'href="../../pages/'))
    .pipe(replace('href="index.html"', 'href="../../index.html"'))
    .pipe(gulp.dest('.'));
  gulp.src('pages/*.html', { base: "./" })
    .pipe(replace('src="assets/', 'src="../assets/'))
    .pipe(replace('"pages/', '"../pages/'))
    .pipe(replace('href="index.html"', 'href="../index.html"'))
    .pipe(gulp.dest('.'));
});
