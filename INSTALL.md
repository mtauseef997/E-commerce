# Installation Instructions

## Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx with mod_rewrite enabled
- Composer (optional)

## Installation Steps

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/modernshop.git
cd modernshop
```

### 2. Configure Database
```bash
cp config/config.example.php config/config.php
```
Edit `config/config.php` with your database credentials.

### 3. Import Database
Import the database schema:
```bash
mysql -u username -p database_name < database/schema.sql
```

### 4. Import Sample Data (Optional)
```bash
mysql -u username -p database_name < database/sample_data.sql
```

### 5. Set Permissions
```bash
chmod -R 755 public/uploads/
chmod -R 755 public/images/
```

### 6. Configure Web Server
Point your web server document root to the project directory and ensure mod_rewrite is enabled.

### 7. Access Application
Visit your domain to access the application.

## Default Admin Account
- Email: admin@modernshop.com
- Password: password

**Important**: Change the default admin password after first login!

## Production Deployment
1. Set `APP_DEBUG` to `false` in config.php
2. Configure proper database credentials
3. Set up SSL certificate
4. Configure email settings for notifications
5. Set up regular database backups
