[![Codeship Status for Cute-Ninja/shf-api-v2](https://app.codeship.com/projects/9b300fc0-8446-0136-bf62-06294081aa1e/status?branch=master)](https://app.codeship.com/projects/302274)
[![Maintainability](https://api.codeclimate.com/v1/badges/e5ee67d500a690cf8dbc/maintainability)](https://codeclimate.com/github/Cute-Ninja/shf-api-v2/maintainability)
[![Coverage Status](https://coveralls.io/repos/github/Cute-Ninja/shf-api-v2/badge.svg?branch=master)](https://coveralls.io/github/Cute-Ninja/shf-api-v2?branch=master)


Super Hero Factory
=======================

## Introduction
The purpose of Super Hero Factory (SHF) is to provide a fun and motivating set of tools to help people to have a more healthy lifestyle. 
Exercising regularly, hydrating and eating properly, as well as sleeping enougth are the keys to a long life !

## Installation
```
composer install
make dev_reset_db
```

## Configuration

## Unit & Functionnal tests
```
./vendor/bin/paratest -p8 --exclude-group=alterDB
./vendor/bin/phpunit -c phpunit.xml --group=alterDB 
```

