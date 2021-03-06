# Code Kata: Spiral Generator

## Kata Subject

The code kata subject can be found [at this link](https://www.codewars.com/kata/make-a-spiral).

## Usage

Install dependencies (requires PHP > 7.1)
```
$ composer install
```

You can run spiral generator using
```
$ bin/spiral-generator <width> <height> <way>
```

Parameters:
- **width**: width of the spiral (integer, > 5)
- **height**: height of the spiral (integer, > 5)
- **way**: drawing way of the spiral (string, 'clockwise' or 'anticlockwise', default is 'clockwise')

## Docker usage

Install dependencies with dockerized composer
```
$ docker run --rm --interactive --tty --volume $PWD:/app composer install
```

You can run spiral generator using dockerized fpm-7.1
```
$ docker run -it --rm --name spiral-generator -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.1-cli php bin/spiral-generator <width> <height> <way>
```