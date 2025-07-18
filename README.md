# 🛒 ModernShop E-Commerce Platform

A complete, modern e-commerce platform built with PHP using MVC architecture. Features a responsive design, comprehensive admin panel, and full shopping cart functionality.

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## ✨ Features

### 🛍️ **Customer Features**

- **Modern Responsive Design** - Mobile-first, professional UI
- **Product Catalog** - Advanced search, filtering, and pagination
- **Shopping Cart** - Session-based cart with quantity management
- **User Authentication** - Registration, login, profile management
- **Order Management** - Complete order history and tracking
- **Wishlist System** - Save favorite products
- **User Dashboard** - Profile, addresses, order history

### ⚙️ **Admin Features**

- **Admin Dashboard** - Comprehensive statistics and overview
- **Product Management** - CRUD operations with image support
- **Category Management** - Hierarchical category system
- **Order Processing** - Order status management
- **User Management** - Customer account administration
- **Inventory Tracking** - Stock management and alerts

### 🔧 **Technical Features**

- **MVC Architecture** - Clean, maintainable code structure
- **PSR-4 Autoloading** - Modern PHP standards
- **Database Abstraction** - PDO-based database layer
- **CSRF Protection** - Security against cross-site attacks
- **Responsive Design** - Works on all devices
- **SEO Friendly** - Clean URLs and meta tags

## 🚀 Quick Start

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) with mod_rewrite
- GD extension (optional, for image generation)

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/mtauseef997/E-commerce.git
   cd E-commerce
   ```

2. **Configure database settings**

   - Copy `config/config.example.php` to `config/config.php`
   - Update database credentials in `config/config.php`

3. **Set up the database**

   - Visit `http://your-domain/setup.php`
   - Click "Start Setup" to create tables and sample data

4. **Generate placeholder images**

   - Visit `http://your-domain/generate_placeholders.php`
   - This creates sample product images

5. **Access your store**
   - **Frontend**: `http://your-domain/`
   - **Admin Panel**: `http://your-domain/admin`

### Default Login Credentials

**Admin Account:**

- Email: `admin@modernshop.com`
- Password: `password`

**Test User Account:**

- Email: `john@example.com`
- Password: `password`

## 📁 Project Structure

```
e-commerce/
├── app/
│   ├── Controllers/     # Application controllers
│   ├── Core/           # Core framework classes
│   ├── Models/         # Database models
│   └── Views/          # View templates
├── config/             # Configuration files
├── database/           # Database schema and migrations
├── public/             # Public assets (CSS, JS, images)
├── routes/             # Route definitions
├── setup.php           # Database setup script
└── index.php           # Application entry point
```

## 🎯 Usage

### For Customers

1. Browse products on the homepage
2. Use search and filters to find products
3. Add items to cart and proceed to checkout
4. Create an account to track orders
5. Manage profile and addresses

### For Administrators

1. Login to admin panel at `/admin`
2. Manage products, categories, and orders
3. View sales statistics and reports
4. Handle customer inquiries and support

## 🛠️ Development

### Running Tests

```bash
# Visit the test page to verify functionality
http://your-domain/test_functionality.php
```

### Database Schema

The application uses the following main tables:

- `users` - Customer and admin accounts
- `products` - Product catalog
- `categories` - Product categories
- `orders` - Customer orders
- `order_items` - Order line items
- `user_addresses` - Customer addresses
- `reviews` - Product reviews
- `wishlist` - Customer wishlists

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Built with modern PHP practices
- Responsive design inspired by modern e-commerce platforms
- Icons provided by Font Awesome
- Fonts by Google Fonts

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/mtauseef997/E-commerce/issues) page
2. Create a new issue with detailed information
3. Contact the maintainer

---

**Made with ❤️ by [mtauseef997](https://github.com/mtauseef997)**
