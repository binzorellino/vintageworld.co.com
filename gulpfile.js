'use strict';

// Project Variables.
var SASS_DIR  =  './sass/**/*.scss';
var DEST_DIR   =   './';

var JS_DIR = './javascripts/main.js';
var JS_DEST_DIR = './javascripts/';

var autoprefixerOptions  =  {
  browsers: ['last 2 versions', '> 5%', 'ie 8', 'Firefox ESR']
};


/**
 * Load Plugins.
 */

var gulp                      = require('gulp');
var sass                      = require('gulp-sass');
var sourcemaps                = require('gulp-sourcemaps');
var autoprefixer              = require('gulp-autoprefixer');
var notify                    = require('gulp-notify');
var lineec                    = require('gulp-line-ending-corrector');
var cleanCSS                  = require('gulp-clean-css');
var rename                    = require('gulp-rename');
var uglify                    = require('gulp-uglify');

/**
 * Task: 'sass'.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 */

gulp.task('sass', function () {
  return gulp.src( SASS_DIR )

    .pipe( sass( {
      errLogToConsole: true,
      outputStyle: 'compact',
      precision: 10
    } ) )
    .on('error', console.error.bind(console))

    .pipe( autoprefixer( autoprefixerOptions ) )

    .pipe( cleanCSS( {debug: true}, function(details) {
      console.log(details.name + ': ' + details.stats.originalSize);
      console.log(details.name + ': ' + details.stats.minifiedSize);
    } ) )

    .pipe( lineec() )

    .pipe( gulp.dest( DEST_DIR ) )

    .pipe( notify( { message: 'TASK: "sass" Completed! 💯', onLast: true } ) );
});


/**
 * Task: 'scripts'.
 *
 * Minifies JS.
 */
gulp.task( 'scripts', function() {
  gulp.src( JS_DIR )
    .pipe(rename('main.min.js'))
    .pipe(uglify())
    .pipe( gulp.dest( JS_DEST_DIR ) )
    .pipe( notify( { message: 'TASK: "scripts" Completed! 💯', onLast: true } ) );
});


/**
  * Watch Tasks.
  *
  * Watches for file changes and runs specific tasks.
  */

gulp.task('watch', function() {
  return gulp
    .watch(SASS_DIR, ['sass'])
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});


gulp.task('watch-js', function() {
  return gulp
    .watch(JS_DIR, ['scripts'])
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});



/**
  * Default Tasks.
  */

gulp.task('default', ['sass', 'scripts', 'watch', 'watch-js']);
