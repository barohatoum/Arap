'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function() {
	gulp.src('./resources/scss/app.scss')
		.pipe(sass.sync().on('error', sass.logError))
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(gulp.dest('./assets/css/'));
});

gulp.task('sass:watch', function() {
	gulp.watch('./resources/scss/app.scss', ['sass']);
});
