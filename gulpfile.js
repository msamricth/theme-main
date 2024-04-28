const gulp = require( 'gulp' ),
	fancylog = require( 'fancy-log' ),
	browserSync = require( 'browser-sync' ),
	server = browserSync.create(),
	minify = require('gulp-minify'),
	dev_url = 'https://glt.local/';


/**
 * Define all source paths
 */

var paths = {
	styles: {
		src: './assets/*.scss',
		dest: './build'
	},
	script: {
		src: './assets/*.js',
		dest: './build'
	},
	editorScript: {
		src: './assets/js/editor.js',
		dest: './build'
	},
	scripts: {
		src: './assets/scripts/*.js',
		dest: './build/js'
	},
	theFold: {
		src: './assets/scripts/thefold/*.js',
		inc: './assets/scripts/thefold/src/*.js'
	}

};


/**
 * Webpack compilation: http://webpack.js.org, https://github.com/shama/webpack-stream#usage-with-gulp-watch
 * 
 * build_js()
 */

function build_js() {
	const compiler = require( 'webpack' ),
		webpackStream = require( 'webpack-stream' );

	return gulp.src( paths.script.src )
		.pipe(
			webpackStream( {
				config: require( './webpack.config.js' )
			},
				compiler
			)
		)
		.pipe(
			gulp.dest( paths.script.dest )
			//.pipe(minify())
		)
}
function build_editor_js() {
	const compiler = require('webpack');
	const webpackStream = require('webpack-stream');

	return gulp.src(paths.editorScript.src)
		.pipe(
			webpackStream({
				mode: 'production',
				entry: {
					editor: './assets/js/editor.js', // Include the new entry point for editor.js
				},
				output: {
					filename: 'editor.js',
				},
				module: {
					rules: [
						{
							test: /\.js$/,
							exclude: /node_modules/,
							use: {
								loader: 'babel-loader',
								options: {
									presets: ['@babel/preset-env'],
								},
							},
						},
					],
				},
			})
		)
		//.pipe(minify())
		.pipe(gulp.dest(paths.editorScript.dest));
}
/**
 * SASS-CSS compilation: https://www.npmjs.com/package/gulp-sass
 * 
 * build_css()
 */

function build_css() {
	const sass = require( 'gulp-sass' )( require( 'sass' ) ),
		postcss = require( 'gulp-postcss' ),
		sourcemaps = require( 'gulp-sourcemaps' ),
		autoprefixer = require( 'autoprefixer' ),
		cssnano = require( 'cssnano' );

	const plugins = [
		autoprefixer(),
		cssnano(),
	];

	return gulp.src( paths.styles.src )
		.pipe(
			sourcemaps.init()
		)
		.pipe(
			sass()
				.on( 'error', sass.logError )
		)
		.pipe(
			postcss( plugins )
		)
		.pipe(
			sourcemaps.write( './' )
		)
		.pipe(
			gulp.dest( paths.styles.dest )
		)
		/*.pipe(
			server.stream() // Browser Reload
		)*/;
}

/**
 * Watch task: Webpack + SASS
 * 
 * $ gulp watch
 */

gulp.task( 'watch',
	function () {
		// Modify "dev_url" constant and uncomment "server.init()" to use browser sync
	//server.init({
		//	proxy: dev_url,
		//} );
		gulp.watch( [ paths.script.src, paths.scripts.src, paths.theFold.src, paths.theFold.inc], build_js );
		gulp.watch( [ paths.script.src, paths.editorScript.src, paths.scripts.src, paths.theFold.src, paths.theFold.inc], build_editor_js );
		gulp.watch( [ paths.styles.src, './assets/scss/*.scss' ], build_css );
	}
);