-- =====================================================
-- E-Commerce Marketplace - Platform Admin
-- Database: ecommerce_store
-- Compatible with phpMyAdmin / XAMPP (MySQL/MariaDB)
-- =====================================================

CREATE DATABASE IF NOT EXISTS `ecommerce_store`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ecommerce_store`;

-- ----------------------------
-- Users (admins, customers, sellers, delivery managers)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','seller','customer','delivery') NOT NULL DEFAULT 'customer',
  `status` ENUM('active','inactive','suspended','pending') NOT NULL DEFAULT 'active',
  `phone` VARCHAR(30) DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Sellers (extra info + approval state)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `sellers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `shop_name` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `commission_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  `approval_status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_suspended` TINYINT(1) NOT NULL DEFAULT 0,
  `banner` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Categories (parent-child)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(120) NOT NULL,
  `parent_id` INT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Products
-- ----------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `seller_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `name` VARCHAR(200) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `stock` INT NOT NULL DEFAULT 0,
  `image` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('active','removed') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`seller_id`) REFERENCES `sellers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Orders
-- ----------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT UNSIGNED NOT NULL,
  `seller_id` INT UNSIGNED NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `status` ENUM('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`seller_id`) REFERENCES `sellers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Order items
-- ----------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Disputes
-- ----------------------------
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `customer_id` INT UNSIGNED NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT,
  `admin_notes` TEXT,
  `status` ENUM('open','resolved') NOT NULL DEFAULT 'open',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Coupons (platform-wide)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `discount_percent` DECIMAL(5,2) NOT NULL DEFAULT 0,
  `valid_until` DATE DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Announcements
-- ----------------------------
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `body` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Activity log
-- ----------------------------
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `actor` VARCHAR(120) NOT NULL,
  `action` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- SEED DATA
-- =====================================================

-- Default Admin -> email: admin@shop.com  password: admin123
INSERT INTO `users` (`name`,`email`,`password`,`role`,`status`) VALUES
('Platform Admin','admin@shop.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','admin','active'),
('John Customer','john@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','customer','active'),
('Mary Buyer','mary@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','customer','active'),
('Dave Delivery','dave@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','delivery','active'),
('Alice Seller','alice@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','seller','active'),
('Bob Seller','bob@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','seller','active'),
('Pending Seller','pend@mail.com','$2b$10$.pysFTTcr5mur40AA3rzGOElUTsgmsZ/nTo0VaU6FWeLG44C7lnGK','seller','pending');

-- Sellers
INSERT INTO `sellers` (`user_id`,`shop_name`,`description`,`commission_rate`,`approval_status`) VALUES
(5,'Alice Boutique','Fashion items',10.00,'approved'),
(6,'Bob Electronics','Phones & gadgets',12.50,'approved'),
(7,'New Shop','Awaiting approval',10.00,'pending');

-- Categories
INSERT INTO `categories` (`name`,`parent_id`) VALUES
('Fashion',NULL),('Electronics',NULL),('Home',NULL),
('Men',1),('Women',1),('Mobiles',2),('Laptops',2);

-- Products
INSERT INTO `products` (`seller_id`,`category_id`,`name`,`description`,`price`,`stock`,`is_featured`) VALUES
(1,4,'Cotton T-Shirt','Soft cotton tee',15.00,100,1),
(1,5,'Summer Dress','Light summer dress',29.99,50,0),
(2,6,'Smartphone X','6.5" display, 128GB',299.00,30,1),
(2,7,'Ultrabook 14','i5, 16GB RAM',799.00,15,0);

-- Orders
INSERT INTO `orders` (`customer_id`,`seller_id`,`total_amount`,`status`,`created_at`) VALUES
(2,1,44.99,'delivered',NOW()),
(3,2,299.00,'processing',NOW()),
(2,2,799.00,'pending',NOW() - INTERVAL 5 DAY),
(3,1,15.00,'delivered',NOW() - INTERVAL 10 DAY);

-- Order items
INSERT INTO `order_items` (`order_id`,`product_id`,`quantity`,`price`) VALUES
(1,1,1,15.00),(1,2,1,29.99),(2,3,1,299.00),(3,4,1,799.00),(4,1,1,15.00);

-- Dispute
INSERT INTO `disputes` (`order_id`,`customer_id`,`subject`,`message`,`status`) VALUES
(2,3,'Late delivery','Order is taking too long','open');

-- Coupons
INSERT INTO `coupons` (`code`,`discount_percent`,`valid_until`,`is_active`) VALUES
('WELCOME10',10.00,'2026-12-31',1),
('SUMMER20',20.00,'2026-09-30',1);

-- Announcements
INSERT INTO `announcements` (`title`,`body`) VALUES
('Welcome!','Welcome to our marketplace platform.');

-- Activity
INSERT INTO `activity_log` (`actor`,`action`) VALUES
('admin@shop.com','Logged in'),
('admin@shop.com','Approved seller Alice Boutique'),
('admin@shop.com','Created coupon WELCOME10');
