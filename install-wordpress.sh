#!/bin/bash

# WordPress Installation Script for Ubuntu
# This script installs WordPress with Apache, MySQL, and PHP

set -e

echo "======================================"
echo "WordPress Installation Script"
echo "======================================"
echo ""

# Update system
echo "Updating system packages..."
sudo apt update && sudo apt upgrade -y

# Install Apache
echo "Installing Apache..."
sudo apt install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

# Install MySQL
echo "Installing MySQL..."
sudo apt install -y mysql-server
sudo systemctl enable mysql
sudo systemctl start mysql

# Install PHP and required extensions
echo "Installing PHP and extensions..."
sudo apt install -y php libapache2-mod-php php-mysql php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip

# Restart Apache
echo "Restarting Apache..."
sudo systemctl restart apache2

# Create MySQL database and user
echo ""
echo "======================================"
echo "MySQL Configuration"
echo "======================================"
echo ""

DB_NAME="wordpress"
DB_USER="wordpressuser"
DB_PASS=$(openssl rand -base64 12)

echo "Creating MySQL database and user..."
sudo mysql -e "CREATE DATABASE ${DB_NAME} DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
sudo mysql -e "CREATE USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
sudo mysql -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

echo ""
echo "MySQL Database: ${DB_NAME}"
echo "MySQL Username: ${DB_USER}"
echo "MySQL Password: ${DB_PASS}"
echo ""

# Download WordPress
echo "Downloading WordPress..."
cd /tmp
wget -q https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
sudo rm -f latest.tar.gz

# Configure WordPress
echo "Configuring WordPress..."
cd /tmp/wordpress
cp wp-config-sample.php wp-config.php

# Update wp-config.php with database credentials
sed -i "s/database_name_here/${DB_NAME}/g" wp-config.php
sed -i "s/username_here/${DB_USER}/g" wp-config.php
sed -i "s/password_here/${DB_PASS}/g" wp-config.php

# Generate WordPress salts
echo "Generating WordPress security keys..."
SALT=$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
STRING='put your unique phrase here'
printf '%s\n' "g/$STRING/d" a "$SALT" . w | ed -s wp-config.php

# Move WordPress to web root
echo "Installing WordPress to web server..."
sudo rm -rf /var/www/html/*
sudo cp -r /tmp/wordpress/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

# Create .htaccess file
echo "Creating .htaccess..."
sudo tee /var/www/html/.htaccess > /dev/null <<EOF
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF

sudo chown www-data:www-data /var/www/html/.htaccess

# Enable Apache modules
echo "Enabling Apache modules..."
sudo a2enmod rewrite
sudo a2enmod ssl

# Update Apache configuration
echo "Configuring Apache..."
sudo tee /etc/apache2/sites-available/wordpress.conf > /dev/null <<EOF
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

sudo a2ensite wordpress.conf
sudo a2dissite 000-default.conf

# Restart Apache
sudo systemctl restart apache2

# Clean up
rm -rf /tmp/wordpress

# Install theme
echo ""
echo "======================================"
echo "Installing Mediascope Theme"
echo "======================================"
echo ""

if [ -d "/mnt/okcomputer/output/mediascope-theme" ]; then
    echo "Copying theme files..."
    sudo mkdir -p /var/www/html/wp-content/themes/mediascope-theme
    sudo cp -r /mnt/okcomputer/output/mediascope-theme/* /var/www/html/wp-content/themes/mediascope-theme/
    sudo chown -R www-data:www-data /var/www/html/wp-content/themes/mediascope-theme
    echo "Theme installed successfully!"
else
    echo "Theme folder not found. Please manually upload the theme via WordPress admin."
fi

echo ""
echo "======================================"
echo "Installation Complete!"
echo "======================================"
echo ""
echo "WordPress has been installed successfully!"
echo ""
echo "Website URL: http://$(curl -s ifconfig.me)"
echo ""
echo "Database Information:"
echo "  Database Name: ${DB_NAME}"
echo "  Username: ${DB_USER}"
echo "  Password: ${DB_PASS}"
echo ""
echo "Next Steps:"
echo "1. Open your browser and go to: http://$(curl -s ifconfig.me)"
echo "2. Complete the WordPress setup wizard"
echo "3. Log in to WordPress admin"
echo "4. Go to Appearance > Themes and activate 'Mediascope Clone'"
echo "5. Go to Appearance > Customize to configure the theme"
echo ""
echo "======================================"
