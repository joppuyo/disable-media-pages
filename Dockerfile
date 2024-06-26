# https://github.com/conetix/docker-wordpress-wp-cli/blob/master/Dockerfile

ARG wp_docker_tag

FROM wordpress:$wp_docker_tag

ARG XDEBUG_VERSION

# Add sudo in order to run wp-cli as the www-data user
RUN apt-get update && apt-get install -y sudo less mariadb-client

RUN pecl install $XDEBUG_VERSION && docker-php-ext-enable xdebug

# Add WP-CLI
RUN curl -o /bin/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
COPY wp-su.sh /bin/wp
RUN chmod +x /bin/wp-cli.phar /bin/wp

# PDO for Codeception
RUN docker-php-ext-install \
    pdo_mysql

# Zip for PHP 8.1
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

# Cleanup
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
