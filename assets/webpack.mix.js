let mix = require("laravel-mix");

mix.disableSuccessNotifications();
mix.setPublicPath(".");
mix.setResourceRoot(".");
mix.webpackConfig({
  externals: {
    jquery: "jQuery",
  },
});
mix.options({
  postCss: [require("autoprefixer")],
  fileLoaderDirs: {
    fonts: "../fonts",
  },
});

mix.babelConfig({
  plugins: ["@babel/plugin-syntax-dynamic-import"],
});

mix
  .js("src/js/app.js", "dist")
  .sass("src/scss/app.scss", "dist")
  .sass("src/scss/editor.scss", "dist")
  .options({
    processCssUrls: false,
    postCss: [require("tailwindcss")],
  });

const proxyServer = process.env.BASE_URL ? process.env.BASE_URL : "localhost";
mix.browserSync({
  proxy: proxyServer,
  open: false,
  files: ["../templates/**/*.php"],
});

mix.webpackConfig(require("./webpack.config"));

if (mix.inProduction()) {
  mix.version();
}
