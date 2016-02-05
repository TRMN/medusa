// Include gulp
var gulp = require( 'gulp' );

// Include Our Plugins
var browserify = require( 'browserify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var uglify = require( 'gulp-uglify' );
var sass = require('gulp-sass');
 
gulp.task('sass', function () {
  return gulp.src('./scss/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css'));
});
 
gulp.task('sass:watch', function () {
  gulp.watch('./sass/**/*.scss', ['sass']);
});

gulp.task( 'browserify', function() {
    return browserify( './javascript/main.js')
        .bundle()
        .on( 'error', function ( err ) {
            console.log( err.toString() );
            this.emit( 'end' );
        })
        // Pass desired output filename to vinyl-source-stream
        .pipe( source( 'bundle.js' ) )
        .pipe( buffer() )
        // Uglify that thing
        //.pipe( uglify() )
        // Start piping stream to tasks!
        .pipe( gulp.dest( './public/js' ) );
});

// Watch Files For Changes
gulp.task( 'watch', function() {
    gulp.watch( 'javascript/*.js', [ 'browserify' ] );
});

// Default Task
gulp.task( 'default', [ 'browserify', 'watch' ] );
