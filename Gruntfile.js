module.exports = function(grunt) {

  require('load-grunt-tasks')(grunt);



  grunt.initConfig({
  	pkg: grunt.file.readJSON("package.json"),
    compress: {
      main: {
        options: {
          archive: 'horizontcms.v<%= pkg.version %>_by_timot.zip',
          pretty: true
        },
        expand: true,
        cwd: './',
        src: ['**/*',
        	  '!core/config.php',
        	  '!node_modules',
        	  '!vendor',
        	  '!storage/images/backgrounds/*',
        	  '!storage/images/blogposts/*',
        	  '!storage/images/gallery/*',
        	  '!storage/images/header_images/*',
        	  '!storage/images/logos/*',
        	  '!storage/images/pages/*',
        	  '!storage/images/users/*,'
        	  ],
        dest: '/'
      }
    }
  });

  grunt.registerTask('default', ['compress']);

};