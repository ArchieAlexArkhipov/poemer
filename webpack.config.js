const path = require('path');
const webpack = require( 'webpack' );
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ReplaceHashInFileWebpackPlugin = require('replace-hash-in-file-webpack-plugin');
var SpritesmithPlugin = require('webpack-spritesmith');


const PATHS = {
  source: path.join(__dirname, 'frontend/assets'),
  build: path.join(__dirname, 'frontend/web'),
  template: path.join(__dirname, 'frontend/views/layouts'),
};

module.exports = (env, argv) => {
  let config = {
    production: argv.mode === 'production'
  };

  return {
    mode: 'development',
    entry: [
      PATHS.source + '/app.js',
      // PATHS.source + '/js/site.js',
      // PATHS.source + '/css/site.css',
    ],
    output: {
      path: PATHS.build,
      // filename: config.production ? 'bundle.min.js?[hash]' : 'bundle.js?[hash]'
      filename: 'bundle.js?[hash]'
    },
    module: {
      rules: [
        {
          test: /\.less$/,
          use: ['style-loader', 'css-loader', 'less-loader'],
        },
        {
          test: /\.m?js$/,
          exclude: /(node_modules|bower_components)/,
          use: ['babel-loader'],
        },
        {
          test: /\.css$/,
          use: ['style-loader', 'css-loader'],
        },

        {
          test: /\.(gif|png)$/,
          use: ['file-loader?name=i/[hash].[ext]'],
        },
        {
          test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
          use: ['file-loader'],
        },

      ]
    },
    plugins: [
      new MiniCssExtractPlugin(),
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery'
      }),
      // new HtmlWebpackPlugin({
      //   inject: false,
      //   hash: true,
      //   template: PATHS.template + '/main.php', // шаблон
      //   // filename: PATHS.template + '/main.php', // название выходного файла
      // }),
      new ReplaceHashInFileWebpackPlugin([{
        dir: 'dist',
        files: [PATHS.template + '/main.php'],
        rules: [{
          search: /bundle.js\?[a-zA-Z0-9]*/,
          replace: 'bundle.js?' + new Date().getTime()
        }]
      }]),

      new SpritesmithPlugin({
        src: {
          cwd: path.resolve(__dirname, 'frontend/assets/imgPNG'),
          glob: '*.png'
        },
        target: {
          image: path.resolve(__dirname, 'frontend/web/assets/sprite/sprite.png'),
          css: path.resolve(__dirname, 'frontend/web/assets/sprite/sprite.less')
        },
      }),

    ]
  };
};
