FROM php:8.3-apache
COPY ./ /var/www/html/

RUN rm -rf /var/www/html/plugins/*

RUN apt-get update && \
    apt-get install -y git zip cron	npm nodejs libzip-dev

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Apache configuration
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions zip pdo_mysql pdo_pgsql pdo_sqlite pdo_sqlsrv mongodb &&  \
   # pecl install mongodb && \  
    a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    chown -R www-data /var/www/html && \
    php composer.phar install

RUN chown -R root /var/www/html && chmod -R 777 /var/www/html && chmod -R 777 /var/www/html/storage

# NPM install
RUN npm install --global cross-env && npm install --global webpack && npm ci --force && npm run dev && rm -rf /var/www/html/node_modules

RUN (crontab -l ; echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1")| crontab -

EXPOSE 80
