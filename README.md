# Artist
## Ecommerce for sale of portraits

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/shabayekdes/artist)

Artist is open source application e-commerce for sale of portraits it's come with REST API and admin panel which it has control entire application


## Features

- Easy to use control panel
- There are many ways to pay with different payment medthods
- I will add more features later ... Loading

## Tech

Artist uses a number of open source projects to work properly:

- [Laravel](https://laravel.com/) - PHP framework!
- [Laravel Voyager](https://voyager.devdojo.com/) - Package for admin panel
- [Laravel Passport](https://laravel.com/docs/master/passport) - A full OAuth2 server implementation

## Installation

Clone from [public repository](https://github.com/shabayekdes/laravel-artist)

```sh
git clone https://github.com/shabayekdes/laravel-artist.git
```

Artist requires [Composer](https://getcomposer.org/) to run.

Install the dependencies and devDependencies and start the server.

```sh
cd artist
composer install
```

Generate key and run migraton

```sh
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Install passport keys.
```sh
php artisan passport install
```

Open .env file and change

> APP_NAME={project name}
> APP_URL={domain}


And Enjoy 🥳 

## License

MIT

**Free Software, Hell Yeah!**
