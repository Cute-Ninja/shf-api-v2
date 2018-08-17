var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .addEntry('fonts/materialize-icons', './assets/fonts/materialize-icons.woff2')

    .addEntry('js/app', './assets/js/app.jsx')
    .addEntry('js/admin-dashboard', './assets/js/pages/admin/dashboard.jsx')
    .addEntry('js/admin-user', './assets/js/pages/admin/user.jsx')

    .addEntry('js/front-dashboard', './assets/js/pages/front/dashboard.jsx')
    .addEntry('js/front-workouts', './assets/js/pages/front/workouts.jsx')

    .addEntry('images/login-background', './assets/img/login/login-background.jpg')

    .addStyleEntry('css/app', './assets/css/common-app.css')
    .addStyleEntry('css/front', './assets/css/front-app.css')
    .addStyleEntry('css/admin', './assets/css/admin-app.css')

    .enableReactPreset()
    .enableVersioning()
;

module.exports = Encore.getWebpackConfig();
