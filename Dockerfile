FROM php:7-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libxslt-dev \
    curl \
    cron \
    unzip \
    openssl \
    libssl-dev \
    libcurl4-openssl-dev

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN docker-php-ext-install \
    mbstring \
    xsl \
    bcmath \
    zip

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -y nodejs

RUN a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

COPY docker-app-entrypoint /usr/local/bin/

ENTRYPOINT ["docker-app-entrypoint"]

CMD ["apache2-foreground"]
