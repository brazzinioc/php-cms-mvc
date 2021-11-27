FROM php:7.4.24-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update --fix-missing && apt-get install -y 
RUN apt-get install nodejs -y \
    npm build-essential -y \
    libpng-dev -y \
    libjpeg62-turbo-dev -y \ 
    libfreetype6-dev -y \ 
    locales -y \ 
    zip -y \ 
    jpegoptim -y \ 
    optipng -y \ 
    pngquant -y \ 
    gifsicle -y \ 
    vim -y \ 
    unzip -y \ 
    curl -y \ 
    git -y \ 
    libpq-dev -y

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY ./src/ /var/www

RUN chown -R www:www /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 8000
CMD ["php-fpm"]