FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/mycrm/

# Instalar dependências do Laravel
WORKDIR /var/www/mycrm

# Instalar a extensão zip
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js e npm
RUN apt-get update && \
    apt-get install -y nodejs npm

# Instalar a extensão PDO MySQL e o cliente MySQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Configurar o VirtualHost do Apache
#COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

#COPY . .
COPY . /var/www/mycrm

#Copy existing application directory permissions
COPY --chown=www:www . /var/www/mycrm

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]

