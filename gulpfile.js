var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var run = require('gulp-run');
var notify = require('gulp-notify');
/**other task*/
var minifycss = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var sass = require('gulp-ruby-sass');

gulp.task('test',function(){
  gulp.src('app/spec/**/*.php')
        .pipe(phpspec('', {notify:true}))
        .on('error', notify.onError({
                title: 'Sorry',
                message: 'test failed...'
        }))
        .pipe(notify({
                title: 'Success',
                message: 'All tests have returned green'
        }));
});

gulp.task('watch',function(){
        gulp.watch(['app/**/*.php','src/**/*.php'],['test']);
//        gulp.watch('src/css/*.css',['css']);
});

//gulp.task('css',function(){
//        return gulp.src('src/css/main.css')
/*              .pipe(sass({style: 'compresssed'}))*/
//                .pipe(autoprefixer({
//                        browsers: ['last 15 versions']
//                }))
//                .pipe(minifycss())
//                .pipe(gulp.dest('src/css/min'))
//});

gulp.task('default', ['test','watch']);

