# Due to layout of this project, the dockerfile will be moved up two directories and run during
# the build. Thus when performing any ADD commands, remember that this is "where you are"

FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteract
RUN apt-get update && apt-get dist-upgrade -y

# Install PHP 8
RUN apt-get install -y software-properties-common apt-transport-https \
  && add-apt-repository ppa:ondrej/php -y;

# Install the relevant packages, php8.0-gd required for qr-code generation.
RUN apt-get update && apt-get install vim apache2 curl libapache2-mod-php8.0 \
    php8.0-cli php8.0-xml php8.0-mbstring php8.0-curl php8.0-gd php8.0-pgsql php8.0-imagick php8.0-soap php8.0-zip -y

# Remove any  php7.* stuff to prevent composer getting confused.
RUN apt-get remove php7.* -y && apt-get autoremove -y

# Install composer
RUN apt-get update \
  && apt-get install curl -y \
  && curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/bin/composer \
  && chmod +x /usr/bin/composer

# Enable the php mod we just installed
RUN a2enmod php8.0
RUN a2enmod rewrite

# expose port 80 and 443 (ssl) for the web requests
EXPOSE 80

# Manually set the apache environment variables in order to get apache to work immediately.
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_RUN_DIR=/var/run/apache2

# It appears that the new apache requires these env vars as well
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

# Turn on display errors. We will disable them based on environment
RUN sed -i 's;display_errors = .*;display_errors = On;' /etc/php/8.0/apache2/php.ini && \
    sed -i 's;display_errors = .*;display_errors = On;' /etc/php/8.0/apache2/php.ini

# Install the cron service to tie up the container's foreground process
RUN apt-get install cron -y

# Add the site's code to the container.
# We could mount it with volume, but by having it in the container, deployment is easier.
COPY --chown=root:www-data site /var/www/site

# Install PHP packages
RUN cd /var/www/site \
  && composer install \
  && chown --recursive root:www-data /var/www/site/vendor \
  && chmod 750 -R /var/www/site/vendor

# Set ssl certificates path as a volume.
VOLUME /etc/apache2/ssl

# Update our apache sites available with the config we created
ADD docker/apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Configure apache to work with ssl.
#RUN a2enmod ssl
#ADD docker/apache-ssl-config.conf /etc/apache2/sites-available/default-ssl.conf
#RUN a2ensite default-ssl

# Use the crontab file.
# The crontab file was already added when we added "project"
#RUN crontab /var/www/my-site/project/docker/crons.conf

# Set permissions
RUN chown root:www-data /var/www
RUN chmod 750 -R /var/www

# Add the startup script to the container
COPY docker/startup.sh /root/startup.sh

# Change the workdir to /var/www/site so that when devs enter the container, they are at the site
WORKDIR /var/www/site

# Execute the containers startup script which will start many processes/services
# The startup file was already added when we added "project"
CMD ["/bin/bash", "/root/startup.sh"]
