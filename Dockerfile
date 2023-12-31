FROM php:8.2-apache
# Install additional PHP extensions
WORKDIR /var/www/html
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
    && apt-get install -y \
        git \
        zip \
        unzip \
        wget \
        gnupg2

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

RUN chmod -R 777 storage/

RUN a2enmod rewrite && service apache2 restart

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN composer install --prefer-dist
RUN touch .env
RUN echo "APP_KEY=" >> .env
RUN php artisan key:generate
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan config:cache
RUN wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash \
    && export NVM_DIR="/root/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install node && npm install && npm run build
