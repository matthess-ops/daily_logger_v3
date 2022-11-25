const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.webpackConfig({
    devtool: 'eval-source-map'
});

 mix.js('resources/js/app.js', 'public/js')
 .js('resources/js/graphactivities.js', 'public/js')
 .js('resources/js/dailyquestionsgraph.js', 'public/js')
 .js('resources/js/checkHourBoxes.js', 'public/js')

 .js('resources/js/mentordailyquestionsgraph.js', 'public/js')
 .js('resources/js/indexDailyActivitiesGraph.js', 'public/js')
 .js('resources/js/graphfrontend.js', 'public/js')
 .js('resources/js/graphfrontendMentor.js', 'public/js')

 .js('resources/js/dayActivitiesGraph.js', 'public/js')
 .js('resources/js/weekActivitiesGraph.js', 'public/js')
 .js('resources/js/dayQuestionsGraph.js', 'public/js')
 .js('resources/js/weekQuestionsGraph.js', 'public/js')
 .js('resources/js/dayQuestionsGraphMentor.js', 'public/js')
 .js('resources/js/weekQuestionsGraphMentor.js', 'public/js')



 .js('resources/js/testremarks.js', 'public/js')




 .sass('resources/sass/app.scss', 'public/css')
 .sourceMaps()
 .browserSync('127.0.0.1:8000');
