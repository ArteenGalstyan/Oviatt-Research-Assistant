#!/bin/bash
cd ..
chmod -R 777 storage/
cp .env.example .env
php artisan key:generate
php artisan config:clear
cd scripts
