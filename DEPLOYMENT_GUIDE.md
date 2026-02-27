# WordPress + Mediascope Theme Deployment Guide

## Overview

This guide will help you deploy the Mediascope WordPress theme to your server.

## Server Information

- **IP Address**: 43.157.81.215
- **Username**: ubuntu
- **Password**: w.xG32ED!8wQiAU

## Option 1: Automated Installation (Recommended)

### Step 1: Connect to Your Server

```bash
ssh ubuntu@43.157.81.215
# Password: w.xG32ED!8wQiAU
```

### Step 2: Upload Installation Script

Upload the `install-wordpress.sh` script to your server:

```bash
# From your local machine
scp install-wordpress.sh ubuntu@43.157.81.215:/tmp/
```

### Step 3: Run Installation Script

```bash
# On the server
cd /tmp
chmod +x install-wordpress.sh
./install-wordpress.sh
```

This script will:
- Install Apache, MySQL, and PHP
- Create a MySQL database for WordPress
- Download and configure WordPress
- Install the Mediascope theme

### Step 4: Complete WordPress Setup

1. Open your browser and go to: `http://43.157.81.215`
2. Follow the WordPress setup wizard
3. Create your admin account
4. Log in to WordPress admin

### Step 5: Activate Theme

1. Go to **Appearance > Themes**
2. Find "Mediascope Clone" and click "Activate"
3. Go to **Appearance > Customize** to configure the theme

## Option 2: Manual Installation

### Step 1: Install LAMP Stack

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache
sudo apt install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

# Install MySQL
sudo apt install -y mysql-server
sudo systemctl enable mysql
sudo systemctl start mysql

# Install PHP
sudo apt install -y php libapache2-mod-php php-mysql php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip

# Restart Apache
sudo systemctl restart apache2
```

### Step 2: Create MySQL Database

```bash
sudo mysql
```

```sql
CREATE DATABASE wordpress DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE USER 'wordpressuser'@'localhost' IDENTIFIED BY 'your_password_here';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpressuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 3: Download WordPress

```bash
cd /tmp
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
sudo rm -f latest.tar.gz
```

### Step 4: Configure WordPress

```bash
cd /tmp/wordpress
cp wp-config-sample.php wp-config.php

# Edit wp-config.php with your database credentials
sudo nano wp-config.php
```

Update these lines:
```php
define('DB_NAME', 'wordpress');
define('DB_USER', 'wordpressuser');
define('DB_PASSWORD', 'your_password_here');
```

Generate security keys:
```bash
curl -s https://api.wordpress.org/secret-key/1.1/salt/
```

Copy the output and replace the corresponding lines in wp-config.php.

### Step 5: Install WordPress

```bash
sudo rm -rf /var/www/html/*
sudo cp -r /tmp/wordpress/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

### Step 6: Configure Apache

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Step 7: Upload Theme

Upload `mediascope-theme.zip` to your server:

```bash
# From your local machine
scp mediascope-theme.zip ubuntu@43.157.81.215:/tmp/
```

Extract and install:

```bash
sudo unzip /tmp/mediascope-theme.zip -d /var/www/html/wp-content/themes/
sudo chown -R www-data:www-data /var/www/html/wp-content/themes/mediascope-theme
```

### Step 8: Complete Setup

1. Open browser: `http://43.157.81.215`
2. Complete WordPress installation
3. Log in to admin
4. Go to **Appearance > Themes**
5. Activate "Mediascope Clone"

## Theme Configuration

### 1. Set Up Menus

Go to **Appearance > Menus**:

**Primary Menu**:
- About
- Media
- Solutions
- Insights
- Case Study
- Contact

**Footer Menu 1 - Quick Links**:
- About Us
- Media
- Solutions
- Case Studies

**Footer Menu 2 - Resources**:
- Insights
- Blog
- Careers
- Contact

**Footer Menu 3 - Legal**:
- Privacy Policy
- Terms of Service
- Cookie Policy

### 2. Customize Theme

Go to **Appearance > Customize**:

#### Hero Section
- Title: "Connecting Brands To The World"
- Subtitle: "Media. Culture. Impact."
- Button: "Success Stories"
- Upload hero background image

#### About Section
- Title: "Reaching Audiences that Matter"
- Subtitle: "From C-suite Leaders To Trendsetters, Wherever They Are"
- Add about content

#### Social Links
- Facebook URL
- Twitter URL
- LinkedIn URL
- Instagram URL

### 3. Add Content

#### Case Studies
1. Go to **Case Studies > Add New**
2. Add title, description, and featured image
3. Publish

#### Team Members
1. Go to **Team Members > Add New**
2. Add name, position, bio, and photo
3. Publish

#### Blog Posts
1. Go to **Posts > Add New**
2. Add title, content, and featured image
3. Assign to "Insights" category
4. Publish

## Troubleshooting

### Permission Issues

```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

### Apache Not Starting

```bash
sudo systemctl status apache2
sudo apache2ctl configtest
```

### Database Connection Error

1. Verify database credentials in wp-config.php
2. Check MySQL is running: `sudo systemctl status mysql`
3. Test connection: `mysql -u wordpressuser -p`

### Theme Not Showing

1. Check theme files are in correct location
2. Verify file permissions
3. Check for PHP errors in Apache logs: `sudo tail -f /var/log/apache2/error.log`

## Security Recommendations

1. **Change default passwords**: Update all default passwords
2. **Enable SSL**: Install Let's Encrypt certificate
3. **Update regularly**: Keep WordPress and plugins updated
4. **Install security plugin**: Consider Wordfence or Sucuri
5. **Backup regularly**: Set up automated backups

## SSL Certificate (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-apache
sudo certbot --apache -d yourdomain.com
```

## Backup Script

Create a backup script:

```bash
sudo tee /usr/local/bin/backup-wordpress.sh > /dev/null <<'EOF'
#!/bin/bash
BACKUP_DIR="/backups/$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u root wordpress > $BACKUP_DIR/database.sql

# Backup files
tar -czf $BACKUP_DIR/files.tar.gz /var/www/html

echo "Backup completed: $BACKUP_DIR"
EOF

sudo chmod +x /usr/local/bin/backup-wordpress.sh
```

## Support

For issues or questions:
1. Check WordPress documentation: https://wordpress.org/documentation/
2. Review theme README.md
3. Contact your developer

---

**Note**: Since the server was not accessible from our environment, please follow this guide to complete the installation on your server.