# Use official PHP CLI image
FROM php:8.4-cli-alpine

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install dependencies
RUN composer install

# Default command
CMD ["vendor/bin/phpunit --testdox" ]
