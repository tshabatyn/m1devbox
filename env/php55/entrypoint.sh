#!/usr/bin/env bash

if [ ! -f /var/www/xhgui/vendor/autoload.php ] || [ ! -f /var/www/xhgui/composer.phar ]; then
    cd /var/www/xhgui && php install.php
fi

if [ ! -f /var/www/xhgui/config/config.php ]; then
    cp /var/www/env/xhgui/config/config.php /var/www/xhgui/config/config.php
fi

if [ ! -f /var/www/magento/app/etc/local.xml ]; then
    cp /var/www/env/magento/app/etc/local.xml /var/www/magento/app/etc/local.xml
fi

service ssh stop
service ssh start

php-fpm -R
