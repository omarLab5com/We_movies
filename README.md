WeMovies test Application
========================

The "WeMovies application" is a web application written in Symfony.

Requirements
------------

  * PHP 7.2.5 or higher;

Assets
-----

Puts the file with the routes in the proper location 
```bash
$ cd we_movies/
$ php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
```

Install dependencies front
```bash
$ cd we_movies/
$ npm install
$ npm run dev
```

Usage
-----

There's no need to configure anything to run the application. If you have
[installed Symfony][1] binary, run this command:

```bash
$ cd we_movies/
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][2] like Nginx or
Apache to run the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd we_movies/
$ ./bin/phpunit
```

[1]: https://symfony.com/download
[2]: https://symfony.com/doc/current/setup/web_server_configuration.html