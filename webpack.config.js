const path = require('path');
const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

const sassLoaders = ['style-loader', 'css-loader', 'sass-loader'];

module.exports = {
  entry: {
    'Layout': './templates/layout.js',
    'Admin/admin': './templates/Admin/admin.js',
  },
  output: {
    path: path.resolve(__dirname, 'public/assets'),
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue': 'vue/dist/vue.esm.js',
      '@components': path.resolve(__dirname, 'vue/components/'),
    }
  },
  performance: {
    maxEntrypointSize: 1024000,
    maxAssetSize: 1024000
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader',
        ],
      },
      {
        test: /\.vue$/i,
        loader: 'vue-loader',
        options: {
          esModule: true,
          cacheBusting: false,
          optimizeSSR: false,
          loaders: {
            css: `vue-style-loader${sassLoaders.map(e => `!${e}`).join('')}`,
            scss: `vue-style-loader${sassLoaders.map(e => `!${e}`).join('')}`,
            sass: `vue-style-loader${sassLoaders.map(e => `!${e}`).join('')}`,
          }
        }
      },
    ],
  },
  optimization: {
    minimizer: [
      new OptimizeCSSAssetsPlugin({}),
      new TerserPlugin({
        parallel: true,
        terserOptions: {
          ecma: 6,
        },
      }),
    ],
    splitChunks: {
      cacheGroups: {
        common: {
          test: /node_modules/,
          name: 'vendors',
          chunks: 'all',
        },
      },
    },
  },
  plugins: [
    new CleanWebpackPlugin(),
    new ManifestPlugin(),
    new MiniCssExtractPlugin({
      ignoreOrder: false
    }),
    new VueLoaderPlugin(),
  ],
  watchOptions: {
    ignored: ['./node_modules/']
  },
  mode: 'development'
};
