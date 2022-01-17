FROM php:7.3-apache
COPY ./ /var/www/html/

ENV INSTALLER_HASH='906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8'

#RUN apt-get update && \
#    apt-get install -y software-properties-common && \
#    add-apt-repository ppa:ondrej/php && \
#    apt-get update && \
#    apt-get install -y php7.3-zip

RUN apt-get update && \
    apt-get install -y git	

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '${INSTALLER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"
    
    
RUN php composer.phar install --ignore-platform-req=ext-zip


EXPOSE 80
