module.exports = function(grunt) {
    grunt.initConfig({
        phpunit: {
            classes: {
                expand: true,
                cwd: ['app/tests/']
            },
            options: {
                bin: 'vendor/bin/phpunit',
                bootstrap: 'bootstrap/autoload.php',
                colors: true,
                followOutput: true
            }
        },

        phpspec: {
            app: {
                specs: 'app/spec/'
            },
            options: {
                prefix: 'bin/'
            }
        },

        watch: {
            setup: {
                files: ['app/database/**/*.php'],
                tasks: ['exec:update_database']
            },
            scripts: {
                files: [
                    'app/tests/**/*.php',
                    'app/Blocks/**/*.php'
                ],
                tasks: ['phpunit']
            },
            // phpspec: {
            //     files: [
            //         'app/spec/**/*.php',
            //         'app/Blocks/**/*.php'
            //     ],
            //     tasks: ['exec:phpspec']
            // }
        },

        exec: {
            phpspec: "clear && vendor/bin/phpspec run -n --ansi",
            update_database: 'php artisan migrate:refresh --seed --database="setup" --env="testing" --force'
            // production: 'php artisan migrate --seed --force'
        }

    });

    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpspec');
    grunt.loadNpmTasks('grunt-exec');

    // grunt.registerTask('setupdatabase', ['exec']);
};
