var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .addEntry('fonts/materialize-icons', './assets/fonts/materialize-icons.woff2')

    .addEntry('js/app', './assets/js/app.jsx')
    .addEntry('js/admin-dashboard', './assets/js/pages/admin/dashboard.jsx')
    .addEntry('js/admin-users', './assets/js/pages/admin/users.jsx')
    .addEntry('js/admin-workouts', './assets/js/pages/admin/workouts.jsx')
    .addEntry('js/admin-workout', './assets/js/pages/admin/workout.jsx')

    .addEntry('js/front-dashboard', './assets/js/pages/front/dashboard.jsx')
    .addEntry('js/front-profile', './assets/js/pages/front/profile.jsx')
    .addEntry('js/front-settings', './assets/js/pages/front/settings.jsx')
    .addEntry('js/front-workouts', './assets/js/pages/front/workouts.jsx')
    .addEntry('js/front-workout', './assets/js/pages/front/workout.jsx')

    .addEntry('js/visitor-registration', './assets/js/pages/visitor/registration.jsx')
    .addEntry('js/visitor-registration-confirmation', './assets/js/pages/visitor/registrationConfirmation.jsx')

    .addEntry('images/login-background', './assets/img/login/login-background.jpg')

    .addStyleEntry('css/visitor', './assets/css/visitor-app.css')
    .addStyleEntry('css/front', './assets/css/front-app.css')
    .addStyleEntry('css/admin', './assets/css/admin-app.css')

    .enableReactPreset()
    .enableVersioning()
;

module.exports = Encore.getWebpackConfig();
