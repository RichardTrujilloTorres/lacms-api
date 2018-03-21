FROM eboraas/apache:stretch

RUN apt-get update && apt-get -y install php7.0 php7.0-mysql libapache2-mod-php7.0 && apt-get clean && rm -r /var/lib/apt/lists/*
 #RUN /usr/sbin/a2dismod 'mpm_*' && /usr/sbin/a2enmod mpm_prefork


RUN apt-get update && apt-get -y install git curl php7.0-mcrypt php7.0-json php7.0-curl && apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN /usr/sbin/a2enmod rewrite


RUN /usr/bin/curl -sS https://getcomposer.org/installer |/usr/bin/php
RUN /bin/mv composer.phar /usr/local/bin/composer


# @todo
# pull from repo



# copy project into destination folder
COPY . /var/www/lumen

# set permissions
RUN /bin/chown -R www-data:www-data /var/www/lumen/storage /var/www/lumen/bootstrap/cache /var/www/lumen/storage/logs

RUN /bin/chmod -R 777  /var/www/lumen/storage/*
# RUN /bin/chown -R www-data:www-data /var/www/lumen
# RUN find /var/www/lumen -type f -exec chmod 644 {} \;
# RUN find /var/www/lumen -type d -exec chmod 755 {} \;




EXPOSE 80
EXPOSE 443

# migrations
# RUN cd /var/www/lumen && php artisan migrate # connection refused

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]


