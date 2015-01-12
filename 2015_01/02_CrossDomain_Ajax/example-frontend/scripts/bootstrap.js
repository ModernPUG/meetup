requirejs.config({
    baseUrl: "./scripts",
    paths: {
        jquery: "../vendor/jquery/dist/jquery.min",
        underscore: "../vendor/underscore/underscore-min",
        backbone: "../vendor/backbone/backbone",
    }
});
requirejs(['./app']);
