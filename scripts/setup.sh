#!/bin/bash
cd ..
cp .env.example .env
php artisan key:generate
php artisan config:clear
cd scripts
