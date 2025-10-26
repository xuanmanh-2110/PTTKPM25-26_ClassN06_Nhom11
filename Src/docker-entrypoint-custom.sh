#!/bin/sh

# Chạy migrate và cache các file cấu hình, route, view cho Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Khởi động dịch vụ mặc định của container (giữ nguyên PID 1)
exec supervisord