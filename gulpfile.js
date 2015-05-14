var elixir = require('laravel-elixir');

elixir(function (mix) {
    var jsLibs = {
        'pace': ['public/bower_components/pace/pace.js'],
        'jquery': ['public/bower_components/jquery/dist/jquery.js'],
        'bootstrap': ['public/bower_components/bootstrap/dist/js/bootstrap.js'],
        'amaranjs': ['public/bower_components/amaranjs/dist/js/jquery.amaran.js'],
        'bootbox': ['public/bower_components/bootbox/bootbox.js'],
        'bootstrap_breakpoints': ['public/bower_components/bootstrap-breakpoints/src/bootstrap-breakpoints.js'],
        'bootstrap_progressbar': ['public/bower_components/bootstrap-progressbar/bootstrap-progressbar.js'],
        'bootstrap_switch': ['public/bower_components/bootstrap-switch/dist/js/bootstrap-switch.js'],
        'bower_jvectormap_2': ['public/bower_components/bower-jvectormap-2/jquery-jvectormap-2.0.0.min.js', 'public/bower_components/bower-jvectormap-2/jquery-jvectormap-world-mill-en.js'],
        'count_up': ['public/bower_components/countUp.js/countUp.js'],
        'fastclick': ['public/bower_components/fastclick/lib/fastclick.js'],
        'humane_js': ['public/bower_components/humane-js/humane.js'],
        'jquery_easy_pie_chart': ['public/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.js'],
        'easy_pie_chart': ['public/bower_components/jquery.easy-pie-chart/dist/easypiechart.js'],
        'jquery_easing': ['public/bower_components/jquery-easing/jquery.easing.js'],
        'jquery_flot': ['public/bower_components/jquery-flot/jquery.flot.js', 'public/bower_components/jquery-flot/jquery.flot.pie.js', 'public/bower_components/jquery-flot/jquery.flot.resize.js'],
        'jquery_ui': ['public/bower_components/jquery-ui/jquery-ui.js'],
        'nanoscroller': ['public/bower_components/nanoscroller/bin/javascripts/jquery.nanoscroller.js'],
        'notifyjs': ['public/bower_components/notifyjs/dist/notify.js'],
        'skycons_html5': ['public/bower_components/skycons-html5/skycons.js'],
        'transitionize': ['public/bower_components/transitionize/dist/transitionize.js'],
        'switchery': ['public/bower_components/switchery/dist/switchery.js']
    };

    var jsMaps = {
        'auth/*': ['pace'],
        'admin-demo/*': ['pace', 'jquery', 'bootstrap', 'bootstrap_breakpoints', 'amaranjs', ['resources/assets/javascripts/admin-demo.js']],
        'admin-demo/dashboard': [
            'jquery_easing', 'jquery_easy_pie_chart', 'bower_jvectormap_2', 'skycons_html5', 'count_up', 'nanoscroller', 'bootstrap_switch', 'switchery',
            'bootstrap_progressbar', 'jquery_flot', ['resources/assets/javascripts/admin-demo/dashboard.js']
        ]
    };

    mix
        .scripts(resolveJsMapToActualFilePaths('auth'), 'public/javascripts/auth.js', './')
        .scripts(resolveJsMapToActualFilePaths('admin-demo/dashboard'), 'public/javascripts/admin-demo/dashboard.js', './')
        .version(['public/javascripts/auth.js', 'public/javascripts/admin-demo/dashboard.js']);

    function resolveJsMapToActualFilePaths(requestPath) {
        var outputList = [];
        var explodedRequestPath = requestPath.split('/');
        if (explodedRequestPath.length > 1 && jsMaps.hasOwnProperty(explodedRequestPath[0] + '/*')) {
            outputList.push.apply(outputList, jsMaps[explodedRequestPath[0] + '/*']);
        } else if (explodedRequestPath.length == 1 || !jsMaps.hasOwnProperty(requestPath)) {
            outputList = jsMaps[explodedRequestPath[0] + '/*']
        }
        if (jsMaps.hasOwnProperty(requestPath)) {
            outputList.push.apply(outputList, jsMaps[requestPath]);
        }

        var resolvedList = [];
        for (var item in outputList) {
            if (jsLibs.hasOwnProperty(outputList[item])) {
                resolvedList.push.apply(resolvedList, jsLibs[outputList[item]]);
            } else {
                resolvedList.push.apply(resolvedList, outputList[item]);
            }
        }

        return resolvedList;
    }
});
