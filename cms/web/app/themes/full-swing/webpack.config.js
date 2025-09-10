const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

module.exports = {
  mode: "development",
  devtool: "source-map",
  entry: {
    style: "./assets/scss/style.scss",
    main: "./assets/js/main.js",
  },

  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
            options: {
              url: false,
            },
          },
          {
            loader: "postcss-loader",
            options: {
              postcssOptions: {
                plugins: [["tailwindcss"], ["autoprefixer"]],
              },
            },
          },
          "sass-loader",
        ],
      },
    ],
  },
  resolve: {
    extensions: ["*", ".js"],
  },
  plugins: [
    new RemoveEmptyScriptsPlugin(),
    new MiniCssExtractPlugin({ filename: "../dist/[name].css" }),
    new BrowserSyncPlugin({
      host: "localhost",
      open: true,
      proxy: "https://mj-fullswing-cms.ddev.site",
    }),
  ],
  output: {
    path: path.resolve(__dirname, "./dist"),
    filename: "[name]-min.js",
  },
};
