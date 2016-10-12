FROM php:5.5-fpm
MAINTAINER Taras Shabatyn <tshabatyn@magento.com>

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libicu-dev \
    libxslt-dev \
    vim \
    mysql-client \
    openssh-server \
    libgringotts-dev \
    curl \
    libcurl4-openssl-dev \
    msmtp

ARG php_ext

RUN docker-php-ext-install -j$(nproc) $php_ext
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-mhash \
    && docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./etc/php/conf.d/development-php.ini $PHP_INI_DIR/php.ini

#we need it for xhprof
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && pecl install xhprof-beta \
    && docker-php-ext-enable xhprof \
    && pecl install mongodb && docker-php-ext-enable mongodb \
    && sed -i 's%auto_prepend_file =%auto_prepend_file = "/var/www/xhgui/external/header.php"%g' /usr/local/etc/php/php.ini
#we need it for xhprof

COPY ./etc/php/php-fpm.d/development-www.conf /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/www-data/root/g' /usr/local/etc/php-fpm.d/www.conf

RUN sed -i 's/UMASK\s*022/UMASK\t002/' /etc/login.defs
RUN echo 'umask 002' >> /etc/profile
RUN echo 'alias ll="ls -lA"' >>/root/.bashrc

RUN echo 'root:root' | chpasswd
RUN sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

WORKDIR /var/www/magento

RUN echo "xdebug.remote_enable=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=\"PHPSTORM\"" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level=1000" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.show_local_vars=0" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.var_display_max_data=10000" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.var_display_max_depth=20" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=\"10.254.254.254\"" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.show_exception_trace=0" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.remote_handler=\"dbgp\"" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.profiler_enable_trigger=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.profiler_output_dir = "/var/www/magento/var/tmp"" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

ADD entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm", "-R"]
