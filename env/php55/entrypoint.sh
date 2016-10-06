#!/usr/bin/env bash

if [ ! -f /var/www/xhgui/vendor/autoload.php ]; then
    cd /var/www/xhgui && php install.php
fi

if [ ! -f /var/www/xhgui/composer.phar ]; then
    cd /var/www/xhgui && php install.php
fi

if [ ! -f /var/www/xhgui/config/config.php ]; then
    cp /var/www/env/xhgui/config/config.php /var/www/xhgui/config/config.php
fi

php-fpm -R
