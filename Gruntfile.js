module.exports = function(grunt) {
  require('jit-grunt')(grunt);
  
  grunt.initConfig({
    less: {
      development: {
        options: {
          paths: ["../less"],
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "assets/css/styles.css": "assets/less/styles.less" // destination file and source file
        }
      }
    },
    watch: {
      styles: {
        files: ['assets/less/*'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', ['less', 'watch']);
};