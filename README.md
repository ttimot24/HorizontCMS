<p align="center"><img src="https://github.com/ttimot24/HorizontCMS/blob/master/resources/logo.png" height="200"></p>

<h1 align="center">HorizontCMS</h1>

[![Laravel 5.6](https://img.shields.io/badge/Laravel-5.6-orange.svg)](http://laravel.com)
[![Build Status](https://travis-ci.org/ttimot24/HorizontCMS.svg?branch=master)](https://travis-ci.org/ttimot24/HorizontCMS)
[![Github All Releases](https://img.shields.io/github/downloads/ttimot24/horizontcms/total.svg)]()
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d645b6be9b6a42a8b6189cc32ea8f546)](https://www.codacy.com/app/ttimot24/HorizontCMS?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ttimot24/HorizontCMS&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/d645b6be9b6a42a8b6189cc32ea8f546)](https://www.codacy.com/app/ttimot24/HorizontCMS?utm_source=github.com&utm_medium=referral&utm_content=ttimot24/HorizontCMS&utm_campaign=Badge_Coverage)

Lightweight CMS built on Laravel 5.6. The core system can be simply extended by themes and plugins with one click. Easy to learn for users, simple to code for developers.


### Latest version: [v1.0.0-alpha.8](https://github.com/ttimot24/HorizontCMS/releases/tag/v1.0.0-alpha.8)

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

##

Project by Timot Tarjani [(@ttimot24)](https://github.com/ttimot24)
