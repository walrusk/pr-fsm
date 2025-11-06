FROM php:8.3-cli

# Xdebug
RUN apt-get update && apt-get install -y --no-install-recommends \
      git unzip zip $PHPIZE_DEPS \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Coverage-only defaults (override with env if needed)
RUN printf "xdebug.mode=coverage\nxdebug.start_with_request=off\n" \
  > /usr/local/etc/php/conf.d/99-xdebug.ini

WORKDIR /app
