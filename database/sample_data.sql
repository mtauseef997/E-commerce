-- Sample Data for E-Commerce Application
USE ecommerce_db;

-- Insert sample users
INSERT IGNORE INTO users (username, email, password, first_name, last_name, phone, role, status) VALUES
('admin', 'admin@modernshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', '+1234567890', 'admin', 'active'),
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', '+1234567891', 'user', 'active'),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith', '+1234567892', 'user', 'active'),
('mike_wilson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Wilson', '+1234567893', 'user', 'active');

-- Insert sample categories
INSERT IGNORE INTO categories (name, slug, description, status) VALUES
('Electronics', 'electronics', 'Electronic devices and gadgets', 'active'),
('Clothing', 'clothing', 'Fashion and apparel', 'active'),
('Home & Garden', 'home-garden', 'Home improvement and garden supplies', 'active'),
('Sports & Outdoors', 'sports-outdoors', 'Sports equipment and outdoor gear', 'active'),
('Books', 'books', 'Books and educational materials', 'active'),
('Health & Beauty', 'health-beauty', 'Health and beauty products', 'active');

-- Insert sample products
INSERT IGNORE INTO products (name, slug, description, short_description, sku, price, sale_price, stock_quantity, category_id, featured, status, weight, dimensions) VALUES
-- Electronics
('Wireless Bluetooth Headphones', 'wireless-bluetooth-headphones', 'High-quality wireless headphones with noise cancellation and long battery life. Perfect for music lovers and professionals.', 'Premium wireless headphones with noise cancellation', 'WBH-001', 199.99, 149.99, 50, 1, 1, 'active', 0.5, '8x7x3 inches'),
('Smartphone 128GB', 'smartphone-128gb', 'Latest smartphone with advanced camera system, fast processor, and all-day battery life.', 'Latest smartphone with 128GB storage', 'SP-128-001', 699.99, NULL, 25, 1, 1, 'active', 0.4, '6x3x0.3 inches'),
('Laptop 15.6 inch', 'laptop-15-6-inch', 'Powerful laptop perfect for work and entertainment with fast SSD and excellent display.', 'High-performance 15.6" laptop', 'LP-156-001', 899.99, 799.99, 15, 1, 1, 'active', 4.5, '14x10x0.8 inches'),
('Wireless Mouse', 'wireless-mouse', 'Ergonomic wireless mouse with precision tracking and long battery life.', 'Ergonomic wireless mouse', 'WM-001', 29.99, NULL, 100, 1, 0, 'active', 0.2, '4x2x1 inches'),

-- Clothing
('Men\'s Cotton T-Shirt', 'mens-cotton-t-shirt', 'Comfortable 100% cotton t-shirt available in multiple colors and sizes.', 'Comfortable 100% cotton t-shirt', 'MCT-001', 24.99, 19.99, 200, 2, 1, 'active', 0.3, 'Various sizes'),
('Women\'s Denim Jeans', 'womens-denim-jeans', 'Classic fit denim jeans made from premium denim fabric.', 'Classic fit denim jeans', 'WDJ-001', 79.99, NULL, 75, 2, 0, 'active', 0.8, 'Various sizes'),
('Unisex Hoodie', 'unisex-hoodie', 'Warm and comfortable hoodie perfect for casual wear.', 'Warm and comfortable hoodie', 'UH-001', 49.99, 39.99, 60, 2, 1, 'active', 0.6, 'Various sizes'),

-- Home & Garden
('Coffee Maker', 'coffee-maker', 'Programmable coffee maker with thermal carafe and auto-shutoff feature.', 'Programmable coffee maker', 'CM-001', 89.99, NULL, 30, 3, 0, 'active', 3.2, '12x8x14 inches'),
('Garden Tool Set', 'garden-tool-set', 'Complete garden tool set with durable tools for all your gardening needs.', 'Complete garden tool set', 'GTS-001', 59.99, 49.99, 40, 3, 0, 'active', 2.5, '24x8x4 inches'),
('LED Desk Lamp', 'led-desk-lamp', 'Adjustable LED desk lamp with multiple brightness levels and USB charging port.', 'Adjustable LED desk lamp', 'LDL-001', 39.99, NULL, 80, 3, 0, 'active', 1.2, '18x6x6 inches'),

-- Sports & Outdoors
('Yoga Mat', 'yoga-mat', 'Non-slip yoga mat perfect for yoga, pilates, and other exercises.', 'Non-slip yoga mat', 'YM-001', 34.99, 24.99, 120, 4, 1, 'active', 2.0, '72x24x0.25 inches'),
('Water Bottle', 'water-bottle', 'Insulated stainless steel water bottle that keeps drinks cold for 24 hours.', 'Insulated stainless steel water bottle', 'WB-001', 19.99, NULL, 150, 4, 0, 'active', 0.5, '10x3x3 inches'),
('Running Shoes', 'running-shoes', 'Lightweight running shoes with excellent cushioning and support.', 'Lightweight running shoes', 'RS-001', 129.99, 99.99, 45, 4, 1, 'active', 1.2, 'Various sizes'),

-- Books
('Programming Guide', 'programming-guide', 'Comprehensive guide to modern programming languages and best practices.', 'Comprehensive programming guide', 'PG-001', 49.99, NULL, 85, 5, 0, 'active', 1.5, '9x7x2 inches'),
('Cookbook Collection', 'cookbook-collection', 'Collection of delicious recipes from around the world.', 'Collection of world recipes', 'CC-001', 29.99, 24.99, 60, 5, 0, 'active', 2.0, '10x8x1.5 inches'),

-- Health & Beauty
('Skincare Set', 'skincare-set', 'Complete skincare routine set with cleanser, toner, and moisturizer.', 'Complete skincare routine set', 'SS-001', 79.99, 59.99, 35, 6, 1, 'active', 0.8, '8x6x4 inches'),
('Electric Toothbrush', 'electric-toothbrush', 'Rechargeable electric toothbrush with multiple cleaning modes.', 'Rechargeable electric toothbrush', 'ET-001', 89.99, NULL, 55, 6, 0, 'active', 0.3, '9x2x2 inches');

-- Insert sample product images
INSERT IGNORE INTO product_images (product_id, image_path, alt_text, is_primary) VALUES
(1, 'headphones-1.jpg', 'Wireless Bluetooth Headphones', 1),
(2, 'smartphone-1.jpg', 'Smartphone 128GB', 1),
(3, 'laptop-1.jpg', 'Laptop 15.6 inch', 1),
(4, 'mouse-1.jpg', 'Wireless Mouse', 1),
(5, 'tshirt-1.jpg', 'Men\'s Cotton T-Shirt', 1),
(6, 'jeans-1.jpg', 'Women\'s Denim Jeans', 1),
(7, 'hoodie-1.jpg', 'Unisex Hoodie', 1),
(8, 'coffee-maker-1.jpg', 'Coffee Maker', 1),
(9, 'garden-tools-1.jpg', 'Garden Tool Set', 1),
(10, 'desk-lamp-1.jpg', 'LED Desk Lamp', 1),
(11, 'yoga-mat-1.jpg', 'Yoga Mat', 1),
(12, 'water-bottle-1.jpg', 'Water Bottle', 1),
(13, 'running-shoes-1.jpg', 'Running Shoes', 1),
(14, 'programming-book-1.jpg', 'Programming Guide', 1),
(15, 'cookbook-1.jpg', 'Cookbook Collection', 1),
(16, 'skincare-1.jpg', 'Skincare Set', 1),
(17, 'toothbrush-1.jpg', 'Electric Toothbrush', 1);

-- Insert sample reviews
INSERT IGNORE INTO product_reviews (product_id, user_id, rating, title, comment, status) VALUES
(1, 2, 5, 'Excellent headphones!', 'Great sound quality and comfortable to wear for long periods.', 'approved'),
(1, 3, 4, 'Good value', 'Nice headphones for the price, battery life is impressive.', 'approved'),
(2, 2, 5, 'Amazing phone', 'Fast, reliable, and great camera quality.', 'approved'),
(3, 4, 4, 'Solid laptop', 'Good performance for work and light gaming.', 'approved'),
(5, 3, 5, 'Perfect fit', 'Comfortable t-shirt, great quality cotton.', 'approved'),
(11, 2, 5, 'Best yoga mat', 'Non-slip surface works great, perfect thickness.', 'approved'),
(13, 4, 4, 'Comfortable shoes', 'Great for daily runs, good cushioning.', 'approved'),
(16, 3, 5, 'Love this set', 'My skin feels amazing after using these products.', 'approved');

-- Insert sample addresses
INSERT IGNORE INTO user_addresses (user_id, type, first_name, last_name, company, address_line_1, address_line_2, city, state, postal_code, country, phone, is_default) VALUES
(2, 'billing', 'John', 'Doe', '', '123 Main St', 'Apt 4B', 'New York', 'NY', '10001', 'US', '+1234567891', 1),
(2, 'shipping', 'John', 'Doe', '', '123 Main St', 'Apt 4B', 'New York', 'NY', '10001', 'US', '+1234567891', 1),
(3, 'billing', 'Jane', 'Smith', 'ABC Company', '456 Oak Ave', '', 'Los Angeles', 'CA', '90210', 'US', '+1234567892', 1),
(4, 'billing', 'Mike', 'Wilson', '', '789 Pine St', 'Suite 100', 'Chicago', 'IL', '60601', 'US', '+1234567893', 1);

-- Insert sample orders
INSERT IGNORE INTO orders (user_id, order_number, status, total_amount, subtotal, tax_amount, shipping_amount, discount_amount, payment_method, payment_status, billing_address, shipping_address, notes) VALUES
(2, 'ORD-2024-001', 'delivered', 179.98, 149.98, 12.00, 10.00, 0.00, 'credit_card', 'paid', 
'{"first_name":"John","last_name":"Doe","address_line_1":"123 Main St","city":"New York","state":"NY","postal_code":"10001","country":"US"}',
'{"first_name":"John","last_name":"Doe","address_line_1":"123 Main St","city":"New York","state":"NY","postal_code":"10001","country":"US"}',
'Please deliver to front door'),

(3, 'ORD-2024-002', 'processing', 109.98, 99.98, 8.00, 0.00, 0.00, 'paypal', 'paid',
'{"first_name":"Jane","last_name":"Smith","address_line_1":"456 Oak Ave","city":"Los Angeles","state":"CA","postal_code":"90210","country":"US"}',
'{"first_name":"Jane","last_name":"Smith","address_line_1":"456 Oak Ave","city":"Los Angeles","state":"CA","postal_code":"90210","country":"US"}',
'');

-- Insert sample order items
INSERT IGNORE INTO order_items (order_id, product_id, product_name, product_sku, quantity, price, total) VALUES
(1, 1, 'Wireless Bluetooth Headphones', 'WBH-001', 1, 149.99, 149.99),
(2, 13, 'Running Shoes', 'RS-001', 1, 99.99, 99.99);

-- Insert sample wishlist items
INSERT IGNORE INTO wishlist (user_id, product_id) VALUES
(2, 3),
(2, 11),
(3, 1),
(3, 16),
(4, 2),
(4, 5);
