FROM php:8.1-cli

ENV APP_ROOT /var/www/html
ENV APP_TIMEZONE Asia/Ho_Chi_Minh

WORKDIR ${APP_ROOT}

#Set TimeZone
ENV TZ=${APP_TIMEZONE}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|max_execution_time = 30|max_execution_time = 300|g" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|memory_limit = 128M|memory_limit = 2G|g" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|post_max_size = 8M|post_max_size = 128M|g" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|max_upload_filesize = 2M|max_upload_filesize = 128M|g" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|upload_max_filesize = 2M|upload_max_filesize = 128M|g" "$PHP_INI_DIR/php.ini"
RUN echo "opcache.optimization_level=0" >> "$PHP_INI_DIR/php.ini"

# Add Production Dependencies
RUN apt-get update -y
RUN apt-get install -y \
    bash \
    libpq-dev \
    zlib1g-dev \
    libzip-dev \
    libbz2-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libgd-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libavif-dev \
    libxpm-dev \
    libonig-dev \
    libmcrypt-dev \
    jpegoptim optipng pngquant gifsicle \
    nano

# Configure & Install Extension
RUN docker-php-ext-configure \
    opcache --enable-opcache

RUN docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-xpm --with-freetype --with-avif

RUN docker-php-ext-install \
    opcache \
    pdo_pgsql \
    pdo_mysql \
    mysqli \
    pgsql \
    pdo \
    -j$(nproc) gd \
    xml \
    intl \
    sockets \
    bz2 \
    pcntl \
    bcmath \
    exif \
    zip \
    soap \
    curl

# Install Mongodb Redis
RUN pecl install mongodb redis \
    && docker-php-ext-enable mongodb redis.so

COPY dockerize/start.sh /usr/local/bin/start

#Run the command on container startup
RUN chmod u+x /usr/local/bin/start

# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

# Install PHP DI
COPY . .
#RUN cp .env.example .env
RUN composer install


EXPOSE 8000
CMD ["/usr/local/bin/start"]
