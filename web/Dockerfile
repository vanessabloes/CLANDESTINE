FROM php:7.3.1-apache

# Support running on heroku
COPY ./docker/run-apache2.sh /usr/local/bin/
CMD [ "sh", "/usr/local/bin/run-apache2.sh" ]

# Enable mod_rewrite
RUN a2enmod rewrite

# Add nodejs apt source
RUN curl -sL https://deb.nodesource.com/setup_12.x  | bash -

# Add yarn apt source
RUN curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update -y && apt-get install -y git zip unzip libpng-dev libjpeg-dev nodejs yarn

RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install gd pdo pdo_mysql exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug - comment out if not needed
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Copy the php ini files
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

ADD ./www /var/www
WORKDIR /var/www

# Run composer install
# Locally you'll need to run "docker-compose exec web composer install" as well,
# as the result of this command will be overwritten by the volume mounting
RUN composer install

# Run yarn && yarn build
# Locally you'll need to run "docker-compose exec web npm install" and "docker-compose exec web npm run build" as well,
# as the result of this command will be overwritten by the volume mounting
RUN yarn && yarn build