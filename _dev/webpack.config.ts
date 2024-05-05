import path from 'path';
import webpack from 'webpack';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
import 'webpack-dev-server';

const config: webpack.Configuration = {
    mode: 'production',
    entry: [
        './src/js/index.ts',
        './src/css/styles.css'
    ],
    output: {
        path: path.resolve(__dirname, '../views/js'),
        filename: 'app.bundle.js',
        cssFilename: 'test.css',
        chunkFilename: '[id].js',
    },
    resolve: {
        modules: [path.resolve(__dirname, 'src/downloaded_libs'), 'node_modules'],
        extensions: ['.ts']
    },
    optimization: {
        minimizer: [
            new CssMinimizerPlugin()
        ]
    },
    module: {
        rules: [
            {
                test: /\.(sa|sc|c)ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "postcss-loader"
                  ],
            },
            { test: /\.ts$/, loader: 'ts-loader', exclude: /node_modules/ }
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '../css/[name].css',
        })
    ]
}

export default config;
