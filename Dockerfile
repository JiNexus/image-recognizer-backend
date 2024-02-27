FROM php:8.2-apache

# Install required packages
RUN apt update \ 
    && apt install -y git \ 
                      libfreetype6-dev \
                      libjpeg-dev \
                      libpng-dev \
                      libffi-dev \
                      libgmp-dev \
                      libicu-dev \
                      libxslt-dev \
                      libzip-dev \
                      zlib1g-dev \
                      libblas-dev \
                      liblapacke-dev \
                      libopenblas-dev \
                      libgfortran-12-dev \
    && apt autoclean

# Install PHP extensions
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install calendar \
    && docker-php-ext-install exif \
    && docker-php-ext-install ffi \
    && docker-php-ext-install gd \
    && docker-php-ext-install gettext \
    && docker-php-ext-install gmp \
    && docker-php-ext-install intl \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install shmop \
    && docker-php-ext-install sysvmsg \
    && docker-php-ext-install sysvsem \
    && docker-php-ext-install sysvshm \
    && docker-php-ext-install xsl \
    && docker-php-ext-install zip

# Install the Tensor extension via PECL
RUN pecl install tensor

# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Enable Apache modules
RUN a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
    && mv /var/www/html /var/www/public \
    && echo 'ServerName localhost' >> /etc/apache2/apache2.conf \
    && curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www