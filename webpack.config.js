const path = require('path'),
  webpack = require('webpack'),
  fs = require('fs');

module.exports = {
  context: path.resolve(__dirname, 'assets'),
  entry: fs.readdirSync(path.resolve(__dirname, 'assets')).reduce((entries, file) => {
    if (file.endsWith('.js')) {
      const name = path.basename(file, '.js'); // Use the base name of the file as the entry name
      entries[name] = `./${file}`;
    }
    return entries;
  }, {}),
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
