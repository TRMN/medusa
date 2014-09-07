// Include gulp
var gulp = require( 'gulp' ); 

// Include Our Plugins
var sass = require( 'gulp-ruby-sass' );
var uglify = require( 'gulp-uglify' );
var rename = require( 'gulp-rename' );

// Compile Our Sass
gulp.task( 'sass', function() {
    return gulp.src( 'sass/*.sass' )
        .pipe( sass() )
        .pipe( gulp.dest( 'public/css' ) );
});

gulp.task( 'bootstrap', function() {
    gulp.src( 'bower_components/jquery/dist/jquery.min.js' )
        .pipe( gulp.dest( 'public/js' ) );
    gulp.src( 'bower_components/bootstrap/dist/css/bootstrap.min.css' )
        .pipe( gulp.dest( 'public/css' ) );
    return gulp.src( 'bower_components/bootstrap/dist/js/bootstrap.min.js' )
        .pipe( gulp.dest( 'public/js' ) );
});

// Minify JS
gulp.task( 'js', function() {
    return gulp.src( 'js/*.js')
        .pipe( gulp.dest( 'public/js' ) )
        .pipe( rename( 'main.min.js' ) )
        .pipe( uglify() )
        .pipe( gulp.dest( 'public/js' ) );
});

// Watch Files For Changes
gulp.task( 'watch', function() {
    gulp.watch( 'js/*.js', [ 'js' ] );
    gulp.watch( 'sass/*.sass', [ 'sass' ] );
});

// Default Task
gulp.task( 'default', [ 'sass', 'js', 'bootstrap', 'watch' ] );
