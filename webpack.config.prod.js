const path = require('path');
const removeEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const webpackConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...webpackConfig,
  mode: 'production',
  context: path.resolve(__dirname, 'build'),
  entry: ['./main.js', './main.scss'],
  plugins: [
    ...webpackConfig.plugins,
    new removeEmptyScriptsPlugin({
      stage: removeEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
    }),
  ],
};
