module.exports = function(grunt) {

  grunt.initConfig({

    // Watches for changes and runs tasks
    // Livereload is setup for the 35729 port by default
    watch: {
      sass: {
        files: ['library/scss/**/*.scss'],
        tasks: ['sass:dev'],
        options: {
          livereload: 35729
        }
      },
      php: {
        files: ['**/*.php'],
        options: {
          livereload: 35729
        }
      }
    },

    // Sass object
    sass: {
      dev: {
        files: [
          {
            src: ['**/*.scss', '!**/_*.scss'],
            cwd: 'library/scss',
            dest: 'library/css',
            ext: '.css',
            expand: true
          }
        ],
        options: {
          style: 'compressed',
          compass: true
        }
      }
    }

  });

  // Default task
  grunt.registerTask('default', ['watch']);

  // Load up tasks
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

};