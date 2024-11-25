const mix = require('laravel-mix');

// Cấu hình biên dịch file JavaScript
mix.js('resources/js/post.js', 'public/js') // Biên dịch file post.js
   .sass('resources/sass/app.scss', 'public/css') // Biên dịch SCSS (nếu cần)
   .setPublicPath('public'); // Đặt đường dẫn đầu ra
