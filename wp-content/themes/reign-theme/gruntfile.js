'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    // Ref. https://npmjs.org/package/load-grunt-tasks
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
        // watch for changes and trigger sass, uglify and livereload
        watch: {
            sass: {
                files: ['assets/css/sass/*.{scss,sass}'],
                tasks: ['sass', 'cssmin', 'autoprefixer']
            },
            js: {
                files: '<%= uglify.frontend.src %>',
                tasks: ['uglify']
            },
            css: {
                files: ['assets/css/*.css', '!assets/css/*.min.css'], // Watch CSS files except minified ones
                tasks: ['cssmin'] // Run cssmin when CSS files change
            }
        },
        // sass
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'assets/css/main.css': 'assets/css/sass/main.scss',
                    'assets/css/legacy-main.css': 'assets/css/sass/legacy-main.scss',
                    'assets/css/nouveau-main.css': 'assets/css/sass/nouveau-main.scss',
                    'assets/css/bb-platform-main.css': 'assets/css/sass/bb-platform-main.scss',
                    'assets/css/bbpress-main.css': 'assets/css/sass/bbpress-main.scss',
                    'assets/css/woocommerce-main.css': 'assets/css/sass/woocommerce-main.scss',
                    'assets/css/edd-main.css': 'assets/css/sass/edd-main.scss',
                    'assets/css/peepso-main.css': 'assets/css/sass/peepso-main.scss',
                    'assets/css/eventscalendar-main.css': 'assets/css/sass/eventscalendar-main.scss',
                    'assets/css/youzify-main.css': 'assets/css/sass/youzify-main.scss',
                    'assets/css/directorist-main.css': 'assets/css/sass/directorist-main.scss',
                    'assets/css/wpforo-main.css': 'assets/css/sass/wpforo-main.scss',
                    'assets/css/dokan-main.css': 'assets/css/sass/dokan-main.scss'
                }
            }
        },
        /*
         * CSS minify
         * Compress and Minify CSS files
         * Ref. https://github.com/gruntjs/grunt-contrib-cssmin
         */
        cssmin: {
            target: {
                options: {
                    sourceMap: false // Disable source maps and remove the sourceMappingURL comment
                },
                files: [{
                    expand: true,
                    cwd: 'assets/css', // Source directory for CSS files
                    src: ['*.css', '!*.min.css', '!*.min.css.map'], // Minify all .css files except already minified ones
                    dest: 'assets/css', // Destination directory for minified CSS
                    ext: '.min.css' // Output file extension
                }]
            }
        },
        // rtlcss
        rtlcss: {
            myTask: {
                // task options
                options: {
                    // generate source maps
                    map: { inline: false },
                    // rtlcss options
                    opts: {
                        clean: false
                    },
                    // rtlcss plugins
                    plugins: [],
                    // save unmodified files
                    saveUnmodified: true
                },
                expand: true,
                cwd: 'assets/css',
                dest: 'assets/css-rtl',
                src: ['*.css']
            }
        },
        // autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: true
            },
            files: {
                expand: true,
                flatten: true,
                src: 'assets/css/*.css',
                dest: 'assets/css/'
            }
        },
        // uglify to concat, minify, and make source maps
        uglify: {
            options: {
                banner: '/*! \n * Reign JavaScript Library \n * @package Reign \n */',
                map: false
            },
            frontend: {
                src: [
                    'assets/js/vendors/slick.min.js',
                    'assets/js/vendors/fitvids.js',
                    'assets/js/vendors/more-menu.js',
                    'assets/js/vendors/sticky-sidebar.min.js',
                    'assets/js/vendors/sticky-kit.min.js',
                    'assets/js/vendors/jquery.cookie.js',
                    'assets/js/vendors/jquery.doubletaptogo.min.js',
                    'assets/js/vendors/mscrollbar.min.js',
                    'assets/js/main.js'
                ],
                dest: 'assets/js/main.min.js'
            },
            extra_plugins: {
                files: {
                    'assets/js/reign-edd.min.js': ['assets/js/reign-edd.js'],
                    'assets/js/reign-peepso.min.js': ['assets/js/reign-peepso.js'],
                    'assets/js/reign-bbpress.min.js': ['assets/js/reign-bbpress.js'],
                    'assets/js/reign-buddypress.min.js': ['assets/js/reign-buddypress.js'],
                    'assets/js/reign-woocommerce.min.js': ['assets/js/reign-woocommerce.js'],
                }
            }
        },
        // Check text domain
        checktextdomain: {
            options: {
                text_domain: ['reign', 'reign-theme', 'kirki', 'tgmpa', 'buddypress', 'bbpress', 'reigntm', 'paid-memberships-pro', 'woocommerce', 'easy-digital-downloads', 'superminimal', 'jobmate', 'megamenu'], //Specify allowed domain(s)
                keywords: [ //List keyword specifications
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            target: {
                files: [{
                    src: [
                        '*.php',
                        '**/*.php',
                        '!node_modules/**',
                        '!options/framework/**',
                        '!tests/**'
                    ], //all php
                    expand: true
                }]
            }
        },
        // Generate POT files.
        makepot: {
            options: {
                type: 'wp-theme',
                domainPath: 'languages',
                potHeaders: { // Headers to add to the generated POT file.
                    poedit: true, // Includes common Poedit headers.
                    'Last-Translator': 'Reign',
                    'Language-Team': 'Reign',
                    'report-msgid-bugs-to': '',
                    'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                },
                updateTimestamp: true // Whether the POT-Creation-Date should be updated without other changes.
            },
            frontend: {
                options: {
                    potFilename: 'reign.pot', // Name of the POT file.
                    exclude: ['node_modules/*', 'options/framework/*'], // List of files or directories to ignore.
                }
            }
        }

    });

    grunt.registerTask('default', ['sass', 'cssmin', 'rtlcss', 'autoprefixer', 'uglify', 'checktextdomain', 'makepot', 'watch']);
};