FROM php:8.0-apache
COPY ./ /var/www/html/

ENV INSTALLER_HASH='e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02'

RUN apt-get update && \
    apt-get install -y git zip cron	npm nodejs

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Apache configuration
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions zip pdo_mysql &&  \  
    a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '${INSTALLER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    chown -R www-data /var/www/html && \
    php composer.phar install

RUN chown -R root /var/www/html && chmod -R 777 /var/www/html && chmod -R 777 /var/www/html/storage

# NPM install
RUN npm install --global cross-env && npm install --global webpack && npm ci && npm run dev

RUN (crontab -l ; echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1")| crontab -

EXPOSE 80
