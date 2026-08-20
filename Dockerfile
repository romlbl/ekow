FROM php:8.2-apache

RUN a2enmod rewrite

COPY . /var/www/html/

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo '<Directory /var/www/html/public>\n\
    DirectoryIndex main.php index.php\n\
    AllowOverride All\n\
</Directory>' > /etc/apache2/conf-available/directoryindex.conf \
    && a2enconf directoryindex

EXPOSE 80