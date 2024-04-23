# Image Recognizer - Backend

*A Birth Is Built Not Born*

This API can be used to access data or services from remote systems,
integrate software applications, or develop third-party software products
that extend the functionality of existing applications.

## System Requirements

* PHP 8.2 or later
* Docker 20.10.8 or later

## Getting Started

Start your new JobSurreal API project with a Git Clone:

```bash
$ git clone https://github.com/JiNexus/image-recognizer-backend.git.
```

Run composer to install the needed packages:

```bash
$ composer install
```

## Start a Web Server

> ### Using Docker (Recommended)
> After installing the packages, go to the `<project-path>`
> and run docker-compose:
>
> Development
> ```bash
> $ docker-compose -f .docker/development/docker-compose.yml up --build
> ```
> Production
> ```bash
> $ docker-compose -f .docker/production/docker-compose.yml up --build
> ```

> ### Using Composer
> Start PHP's built-in web server to verify installation:
>
> ```bash
> $ composer run --timeout=0 serve
> ```

> ### Linux users
>
> On PHP versions prior to 7.1.14 and 7.2.2, this command might not work as
> expected due to a bug in PHP that only affects linux environments. In such
> scenarios, you will need to start the [built-in web
> server](http://php.net/manual/en/features.commandline.webserver.php) yourself,
> using the following command:
>
> ```bash
> $ php -S 0.0.0.0:8080 -t public/ public/index.php
> ```

You can then browse to http://localhost:8080.

> ### Setting a timeout
>
> Composer commands time out after 300 seconds (5 minutes). On Linux-based
> systems, the `php -S` command that `composer serve` spawns continues running
> as a background process, but on other systems halts when the timeout occurs.
>
> As such, we recommend running the `serve` script using a timeout. This can
> be done by using `composer run` to execute the `serve` script, with a
> `--timeout` option. When set to `0`, as in the previous example, no timeout
> will be used, and it will run until you cancel the process (usually via
> `Ctrl-C`). Alternately, you can specify a finite timeout; as an example,
> the following will extend the timeout to a full day:
>
> ```bash
> $ composer run --timeout=86400 serve
> ```

## Troubleshooting

If the installer fails during the ``composer create-project`` phase, please go
through the following list before opening a new issue. Most issues we have seen
so far can be solved by `self-update` and `clear-cache`.

1. Be sure to work with the latest version of composer by running `composer self-update`.
2. Try clearing Composer's cache by running `composer clear-cache`.

If neither of the above help, you might face more serious issues:

* Info about the [zlib_decode error](https://github.com/composer/composer/issues/4121).
* Info and solutions for [composer degraded mode](https://getcomposer.org/doc/articles/troubleshooting.md#degraded-mode).

## Application Development Mode Tool

This skeleton comes with [laminas-development-mode](https://github.com/laminas/laminas-development-mode).
It provides a composer script to allow you to enable and disable development mode.

### To enable development mode

**Note:** Do NOT run development mode on your production server!

```bash
$ composer development-enable
```

**Note:** Enabling development mode will also clear your configuration cache, to
allow safely updating dependencies and ensuring any new configuration is picked
up by your application.

### To disable development mode

```bash
$ composer development-disable
```

### Development mode status

```bash
$ composer development-status
```

## Configuration caching

By default, the skeleton will create a configuration cache in
`data/config-cache.php`. When in development mode, the configuration cache is
disabled, and switching in and out of development mode will remove the
configuration cache.

You may need to clear the configuration cache in production when deploying if
you deploy to the same directory. You may do so using the following:

```bash
$ composer clear-config-cache
```

You may also change the location of the configuration cache itself by editing
the `config/config.php` file and changing the `config_cache_path` entry of the
local `$cacheConfig` variable.

## Setting up the Database

> Create the database for the project, database name should be `image_recognizer`:
> 
> ```bash
> $ CREATE DATABASE `image_recognizer` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> ```
>
> Create the user with the designated password:
> 
> ```bash
> $ CREATE USER 'image_recognizer'@'localhost' IDENTIFIED BY '1234567';
> ```
>
> Grant Privileges:
> 
> ```bash
> $ GRANT ALL PRIVILEGES ON `image_recognizer`.* TO 'image_recognizer'@'localhost';
> ```
>
> Flush Privileges:
> 
> ```bash
> $ FLUSH PRIVILEGES;
> ```
>
> Create all the tables: 
> 
> ```bash
> $ php vendor/bin/doctrine-migrations migrations:migrate
> ```
> 
> Populate your database:
> ```bash
> $ php ./vendor/bin/laminas data-fixtures:load
> ```

## Doctrine Commands
This project is using a [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html) as a Data Mapper

To list all available in Doctrine, run: 
```bash
$ php vendor/bin/doctrine
```

To validate the mapping files: 
```bash
$ php vendor/bin/doctrine orm:validate-schema
```

To see all the Doctrine Migrations available commands: 

```bash
$ php vendor/bin/doctrine-migrations
```

To generate a migration by comparing your current database to your mapping information: 

```bash
$ php vendor/bin/doctrine-migrations migrations:diff
```

To execute a migration to a specified version or the latest available version: 

```bash
$ php vendor/bin/doctrine-migrations migrations:migrate
```

## Additional Commands

To list all available commands in [laminas-cli](https://docs.laminas.dev/laminas-cli/intro/#list), run:

```bash
$ php ./vendor/bin/laminas
```
To load data fixtures to your database: 

```bash 
$ php ./vendor/bin/laminas data-fixtures:load
```
To load data images from Unsplash to your database and local storage:

```bash 
$ php ./vendor/bin/laminas data-image-import:load
```

## Setting up .env

Rename the `.env.dist` file to `.env` and add the necessary value in each variable
