<p align="center"><img src="https://github.com/ttimot24/HorizontCMS/blob/master/resources/logo.png" height="200"></p>

<h1 align="center">HorizontCMS</h1>

[![Laravel 6](https://img.shields.io/badge/Laravel-8-orange.svg)](http://laravel.com)
[![Build Status](https://travis-ci.com/ttimot24/HorizontCMS.svg?branch=master)](https://travis-ci.com/ttimot24/HorizontCMS)
[![Github All Releases](https://img.shields.io/github/downloads/ttimot24/horizontcms/total.svg)]()
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d645b6be9b6a42a8b6189cc32ea8f546)](https://www.codacy.com/app/ttimot24/HorizontCMS?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ttimot24/HorizontCMS&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/d645b6be9b6a42a8b6189cc32ea8f546)](https://www.codacy.com/app/ttimot24/HorizontCMS?utm_source=github.com&utm_medium=referral&utm_content=ttimot24/HorizontCMS&utm_campaign=Badge_Coverage)

HorizontCMS is an open-source, responsive Content Management System (CMS) built on Laravel 8, VueJs 2.6 and Bootstrap 3.4 which you can use to build you next generation websites and blogs.

This lightweight CMS platform provides end-users with the tools to extend and build sustainable web presence with one click which makes it easy to learn for users, simple to code for developers


### Latest version: [v1.0.0-beta.2](https://github.com/ttimot24/HorizontCMS/releases/tag/v1.0.0-beta.2)

### Try out

Frontend: [http://horizontcms.herokuapp.com/](https://horizontcms.herokuapp.com/)

Backend: [http://horizontcms.herokuapp.com/admin](https://horizontcms.herokuapp.com/admin)

> Username & password: admin/admin

### Installation
#### Browser

After downloading and copying the files to the server, navigate to the app root folder and run ```composer install```. Then head to your domain. HorizontCMS can recognize if not installed yet, and redirects you to the installer. Follow the instructions, add the required credentials and you're done.

#### Console 

  1. Download the CMS
  2. Navigate to the app root folder and run ```composer install```
  3. Run ```php artisan horizontcms:install```
  4. Enter the required database and administrator informations.
  5. You're finished.

##### Migration information
  Incremented migrations will be in use after v1.0 is released. Until then migration files might be modified.

#### Install manually from scratch

  [Website For Students Tutorial](https://websiteforstudents.com/how-to-install-horizontcms-on-ubuntu-18-04-16-04-with-apache2/)
  
#### Docker
```docker build -t hcms . ```

```
version: '3'

services:
  hcms_db:
    image: mysql:5.7
    restart: always
    environment:
      MYSQL_DATABASE: 'hcms_database'
      MYSQL_USER: 'hcms_website'
      # You can use whatever password you like
      MYSQL_PASSWORD: 'website789'
      # Password for root access
      MYSQL_ROOT_PASSWORD: 'password'
    ports:
      - '3306:3306'

  hcms_migration:
    image: hcms:latest
    depends_on: 
        - hcms_db
    command: sh -c 'php artisan migrate --no-interaction --force && php artisan db:seed --no-interaction --force && php artisan --version && php artisan hcms:user --create-admin --name=Administrator --email=admin@admin.com --username=admin --password=admin1'
    environment:
        DB_HOST: 'hcms_db'
        DB_CONNECTION: 'mysql'
        DB_USERNAME: 'hcms_website'
        DB_PASSWORD: 'website789'
        DB_DATABASE: 'hcms_database'
        DB_TABLE_PREFIX: 'hcms_'
        
  hcms_admin_user:
    image: hcms:latest
    depends_on: 
        - hcms_migration
    command: sh -c 'php artisan hcms:user --create-admin --name=Administrator --email=admin@admin.com --username=admin --password=admin1'
    environment:
        INSTALLED: 'true'
        DB_HOST: 'hcms_db'
        DB_CONNECTION: 'mysql'
        DB_USERNAME: 'hcms_website'
        DB_PASSWORD: 'website789'
        DB_DATABASE: 'hcms_database'
        DB_TABLE_PREFIX: 'hcms_'

  hcms_web:
    image: hcms:latest
    depends_on: 
        - hcms_migration
    environment:
        INSTALLED: 'true'
        DB_HOST: 'hcms_db'
        DB_CONNECTION: 'mysql'
        DB_USERNAME: 'hcms_website'
        DB_PASSWORD: 'website789'
        DB_DATABASE: 'hcms_database'
        DB_TABLE_PREFIX: 'hcms_'
    ports:
      - '8099:80'

volumes:
      - hcms-db:/var/lib/mysql

volumes:
  hcms-db:

networks:
    default:
        name: hcms-network
```
  
  
#### Revert to Views V1
By default the CMS using the V2 version of the views on frontend, which is based on Bootstrap 4.5.3. However the previous V1 frontend is available, which was built on Bootstrap 3.4.3.

  1. Remove Bootstrap 4.5.3 related css and js from ```config/horizontcms.php```
  2. Uncomment Bootstrap 3.4.3 related css and js in the same file
  3. Replace the trailing v2 to v1 in ```config/views.php```

### Sample plugin

  [GoogleMaps](https://github.com/ttimot24/GoogleMaps)

### Contributing
  - Create a Theme or Plugin
  - Create translation
  - Help in the docs.
  - Write tests
  - Report issues, send pull requests
  - Tell what you think!
  
Any help is appreciated!

### Donation
If this project makes your website development easier, you can buy me a coffe. :)

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/donate?hosted_button_id=73CV4FU4TNM3U)

##

Project by Timot Tarjani [(@ttimot24)](https://github.com/ttimot24)
