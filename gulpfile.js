// Include gulp
var gulp = require( 'gulp' ); 

// Include Our Plugins
var browserify = require( 'browserify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var sass = require( 'gulp-ruby-sass' );
var uglify = require( 'gulp-uglify' );

// Compile Our Sass
gulp.task( 'sass', function() {
    return gulp.src( 'sass/*.sass' )
        .pipe( sass( { 'sourcemap=none': true } ) )
        .on( 'error', function ( err ) { console.log( err.message ); } )
        .pipe( gulp.dest( './public/css' ) );
});

gulp.task( 'browserify', function() {
    return browserify( './javascript/main.js')
        .bundle()
        .on( 'error', function ( err ) {
            console.log( err.toString() );
            this.emit( 'end' );
        })
        // Pass desired output filename to vinyl-source-stream
        .pipe( source( 'bundle.min.js' ) )
        .pipe( buffer() )
        // Uglify that thing
        .pipe( uglify() )
        // Start piping stream to tasks!
        .pipe( gulp.dest( './public/js' ) );
});

// Watch Files For Changes
gulp.task( 'watch', function() {
    gulp.watch( 'javascript/*.js', [ 'browserify' ] );
    gulp.watch( 'sass/*.sass', [ 'sass' ] );
});

// Default Task
gulp.task( 'default', [ 'sass', 'browserify', 'watch' ] );
