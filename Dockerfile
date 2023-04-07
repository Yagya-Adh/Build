FROM php:8.1.0-apache

# Install required packages
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip gd

COPY ./apache2.conf /etc/apache2/apache2.conf

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Install TCPDF
RUN mkdir -p /var/www/tcpdf && \
    curl -SL https://github.com/tecnickcom/tcpdf/archive/refs/tags/6.4.1.tar.gz \
    | tar -xzC /var/www/tcpdf --strip-components=1

# Set permissions for TCPDF
RUN chown -R www-data:www-data /var/www/tcpdf && \
    chmod -R 755 /var/www/tcpdf

EXPOSE 80



