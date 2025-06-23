const CracoLessPlugin = require('craco-less');

module.exports = {
  plugins: [
    { plugin: CracoLessPlugin }
  ],
  devServer: {
    watchFiles: {
      paths: ['src/**/*', 'public/**/*'],
      options: {
        usePolling: true,
        interval: 1000,
      },
    },
    port: 3000,
    host: '0.0.0.0',
    allowedHosts: 'all',
    client: {
      overlay: true,
    },
  }
};