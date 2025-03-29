const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        main: './assets/js/main.js', // Archivo JavaScript principal
        style: './assets/sass/main.scss', // Archivo SCSS principal
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].dahliafeat.bundle.js', // Solo compila archivos JS aquí
    },
    module: {
        rules: [
            // Reglas para archivos JavaScript
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'],
                    },
                },
            },
            // Reglas para SCSS
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader, // Extrae CSS en un archivo separado
                    'css-loader',               // Traduce CSS a módulos CommonJS
                    'postcss-loader',           // Aplica Autoprefixer u otros plugins PostCSS
                    'sass-loader',              // Compila SCSS a CSS
                ],
            },
            {
                test: /\.svg$/,
                type: 'asset/resource', // Convierte los SVG en base64 para incluirlos en CSS
                generator: {
                    filename: 'icons/[name][ext]' // Coloca los SVG en build/icons/
                }
            }
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].dahliafeat.bundle.css', // Archivos CSS generados
        }),
    ],
    mode: 'development',
    watch: true,
    externals: {
        '@wordpress/i18n': ['wp', 'i18n'], // Indica que @wordpress/i18n ya está disponible globalmente
    },
    
};
