FROM php:7.4-apache
COPY ./ /var/www/html/

ENV INSTALLER_HASH='55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae'

RUN apt-get update && \
    apt-get install -y git zip cron	npm nodejs

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions zip pdo_mysql &&  \  
    a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '${INSTALLER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    chown -R www-data /var/www/html && \
    php composer.phar install

RUN chmod -R 777 /var/www/html && chmod -R 777 /var/www/html/storage

RUN npm install -g n && n latest && npm install -g npm && apt-get purge npm && npm run dev

RUN (crontab -l ; echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1")| crontab -

EXPOSE 80
