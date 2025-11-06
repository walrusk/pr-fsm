#!/usr/bin/env bash

cd "$(dirname "$0")"
cd .. # project root

docker run --rm \
  -v "$PWD":/app \
  -w /app \
  -e XDEBUG_MODE=coverage \
  php-test \
  sh -c "composer install --no-interaction && php vendor/bin/phpunit"
