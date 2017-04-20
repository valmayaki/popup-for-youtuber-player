/**
 * gulp file used to generate plugin zip
 *
 */

var gulp = require('gulp'), zip = require("gulp-zip");
var pkg = require('./package.json');
gulp.task('zip', function() {
	var archiveName = pkg.name + '_v' + pkg.version + '.zip';

	gulp.src("src/**/*")
		.pipe(zip(archiveName))
		.pipe(gulp.dest("dist"));
});	