FROM php:7.4-apache
COPY ./ /var/www/html/

ENV INSTALLER_HASH='906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8'

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions zip pdo_mysql
    
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/    

RUN apt-get update && \
    apt-get install -y git zip cron	

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '${INSTALLER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    chown -R www-data /var/www/html
    
    
RUN php composer.phar install

RUN (crontab -l ; echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1")| crontab -

EXPOSE 80
