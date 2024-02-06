const path = require('path'),
  webpack = require('webpack');

module.exports = {
  context: path.resolve(__dirname, 'assets'),
  entry: {
    main: './main.js'
  },
  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'build'),
  },
  /* Uncomment if jQuery support is needed
  externals: {
    jquery: 'jQuery'
  },
  plugins: [
    new webpack.ProvidePlugin( {
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
    } ),
  ],*/
  devtool: 'source-map',
  watch: true,
};