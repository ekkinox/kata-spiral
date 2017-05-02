# Code Kata: Spiral Generator

## Kata Subject

The code kata subject can be found [at this link](https://www.codewars.com/kata/make-a-spiral).

## Usage

Install dependencies
```
$ composer install>
```

You can run spiral generator using
```
$ bin/spiral-generator <width> <height>
```

## Docker usage

Install dependencies with dockerized composer
```
$ docker run --rm --interactive --tty --volume $PWD:/app composer install
```

You can run spiral generator using dockerized fpm-7.1
```
$ docker run -it --rm --name spiral-generator -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.1-cli php bin/spiral-generator <width> <height>
```