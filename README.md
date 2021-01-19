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

Frontend: [https://horizontcms.herokuapp.com/](https://horizontcms.herokuapp.com/)

Backend: [https://horizontcms.herokuapp.com/admin](https://horizontcms.herokuapp.com/admin)

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
