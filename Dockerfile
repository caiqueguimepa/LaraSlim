FROM php:8.4-apache

# 1. Instalar dependências (comandos corrigidos)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo pdo_mysql

# 2. Instalar Composer (comando corrigido)
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 3. Configurar Apache
COPY ./public/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 4. Configurar diretório de trabalho
WORKDIR /var/www/html

# 5. Copiar aplicação (do contexto atual)
COPY . .

# 6. Ajustar permissões (comandos corrigidos)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]