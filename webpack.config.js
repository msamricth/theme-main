const path = require('path');
const removeEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const webpackConfig = require('@wordpress/scripts/config/webpack.config');

// Extend the @wordpress webpack config and add the entry points.
module.exports = {
  ...webpackConfig,
  ...{
    mode: 'production',
    devServer: {
      static: {
        directory: path.join(__dirname, 'assets'),
      },
      client: {
        overlay: false,
      },
      allowedHosts: ['sandbox.local'],
      hot: false,
      compress: true,
      devMiddleware: {
        writeToDisk: true,
      },
      transportMode: 'ws', // Add this line to disable the WebSocket
    },
    context: path.resolve(__dirname, 'assets'),
    entry: ['./main.js', './main.scss'],
    plugins: [
      ...webpackConfig.plugins,
      new removeEmptyScriptsPlugin({
        stage: removeEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
      }),
    ],
  },
};
