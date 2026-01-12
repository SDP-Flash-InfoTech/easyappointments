#!/bin/bash
set -e

# Ensure all required storage directories exist with proper permissions
mkdir -p /var/www/html/storage/sessions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/cache
mkdir -p /var/www/html/storage/uploads
mkdir -p /var/www/html/storage/backups

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Create PHP-FPM runtime directory
mkdir -p /run/php
chmod 755 /run/php

# Start supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
