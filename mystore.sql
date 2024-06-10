-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 08, 2024 at 02:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mystore`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(8, 'Converse'),
(9, 'Nike'),
(10, 'Vans'),
(11, 'Timberland'),
(12, 'No name'),
(13, 'Jonathan D');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `cart_quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Sandals'),
(2, 'High Top Basketball'),
(3, 'Low Top Basketball'),
(4, 'Boots'),
(5, 'Sneakers'),
(6, 'Running Shoes'),
(7, 'Skate Shoes');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `order_status`) VALUES
(31, 2, 335587793, 1, 1, 'pending'),
(32, 2, 335587793, 6, 1, 'pending'),
(33, 2, 335587793, 10, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `cardname` varchar(255) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expmonth` varchar(20) NOT NULL,
  `expyear` varchar(4) NOT NULL,
  `cvv` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(250) NOT NULL,
  `product_description` text NOT NULL,
  `product_keyword` varchar(250) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image1` longblob NOT NULL,
  `product_image2` longblob NOT NULL,
  `product_image3` longblob NOT NULL,
  `product_price` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keyword`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`) VALUES
(1, 'Blue running shoes', 'These shoes were built to last for a long period of time and also feel comfortable while running.', 'Blue, running, runners, featured, unisex', 6, 12, 0x6963652d636f666665652d776974682d776869707065642d637265616d5f3134343632372d333830312e6a7067, 0x706169722d747261696e6572735f3134343632372d333832352e6a7067, 0x706169722d747261696e6572735f3134343632372d333830332e6a7067, 800, '2024-05-20 18:14:59', 'true'),
(2, 'Converse UCLA Blue', 'Classic converse made to represent University of Cali', 'UCLA, blue, converse, all star, chuck taylor, unisex', 2, 8, 0x55434c41312e6a7067, 0x55434c41322e6a7067, 0x55434c41342e6a7067, 1500, '2024-05-20 18:14:13', 'true'),
(3, 'Converse Black Chuck 70', 'The new classic and iconic black chuck 70. Walk around with style.', 'converse, black, chuck 70, unisex, life, style', 2, 8, 0x433730422d4d61696e2e6a7067, 0x43373042312e6a7067, 0x43373042322e6a7067, 1500, '2024-05-20 18:04:20', 'true'),
(4, 'Timberland', 'Timberland boots are a renowned brand of footwear known for their durability, functionality, and iconic style. ', 'boots, black, timberland, life, style, featured, men', 4, 11, 0x74696d6265726c616e642e77656270, 0x6f726967696e616c2e6a7067, 0x6f726967696e616c202831292e6a7067, 4000, '2024-05-20 18:14:44', 'true'),
(5, 'White sandals', 'Recycled sandals are eco-friendly footwear made from repurposed materials such as recycled rubber, plastic bottles, and reclaimed textiles. ', 'recycled, no name, featured, white, sandals, women', 1, 12, 0x73616e64616c732e77656270, 0x3230303032375f322e77656270, 0x3230303032375f332e77656270, 200, '2024-05-20 18:14:32', 'true'),
(6, 'Black Leather Sandals For Men', 'Leather sandals for men are stylish and versatile footwear known for their comfort, durability, and classic appeal. ', 'black, leather, sandals, men, featured, unisex, summer', 1, 12, 0x626c61636b2073616e64616c732e77656270, 0x626c61636b73616e64616c73322e77656270, 0x696d6167652e77656270, 600, '2024-05-20 18:22:41', 'true'),
(7, 'Blue JD Sandals', 'These sandals feature bold, contemporary designs that emphasize individuality and trendsetting style.', 'blue, sandals, life, style, punk, unisex, featured', 1, 13, 0x4a4430374e2d4a4f4e415448414e2d442d4255434b4c452d53414e44414c2d4e4156592d4a4a41434b2d56332e77656270, 0x4a4430374e2d4a4f4e415448414e2d442d4255434b4c452d53414e44414c2d4e4156592d4a4a41434b2d56332d313530783135302e6a7067, 0x41313734382d4a442d4e4156592d4a41434b322d363030783630302e6a7067, 450, '2024-05-20 18:26:39', 'true'),
(8, 'Nike Air Max Plus', 'The Nike Air Max Plus is a standout sneaker known for its striking design, exceptional comfort, and innovative Air technology. First introduced in 1998, the Air Max Plus features the iconic Tuned Air system, providing targeted support and cushioning for a smooth ride. ', 'air, max, black, men, nike,  running shoe, sneaker', 6, 9, 0x414d50496d616765312e77656270, 0x414d50496d6167652d4d61696e2e77656270, 0x414d50496d616765332e77656270, 3500, '2024-05-20 18:45:20', 'true'),
(9, 'Nike Air Jordan 1', ' The Nike Air Jordan 1 is an elevated version of the classic Air Jordan 1, offering enhanced features and contemporary updates while maintaining the iconic silhouette that debuted in 1985. ', 'air, jordan, nike, sneaker, life, style, unisex', 5, 9, 0x4169724a6f7264616e312d4d61696e2e77656270, 0x4169724a6f7264616e315f496d616765322e77656270, 0x4169724a6f7264616e315f496d616765332e77656270, 2500, '2024-05-20 18:48:52', 'true'),
(10, 'Nike White Air Force 1', 'The Nike Air Force 1 Plus is an upgraded take on the iconic Air Force 1, enhancing the classic design with modern features and premium materials. This sneaker retains the timeless silhouette that has made the Air Force 1 a staple since its debut in 1982, including the distinctive low-top profile, perforated toe box, and sturdy rubber outsole with pivot points for traction and durability.', 'white, nike, unisex, force, air, sneaker', 5, 9, 0x416972496d616765312e77656270, 0x416972496d6167652d4d61696e2e77656270, 0x416972496d616765332e706e67, 1800, '2024-05-20 18:53:45', 'true'),
(11, 'Nike Black Slides', ' The Nike Black Sandals Plus offer a blend of comfort, style, and durability, making them an ideal choice for both casual and active wear. ', 'black, men, nike, sandals, comfort', 1, 9, 0x536c696465496d6167652d4d61696e2e77656270, 0x536c696465496d616765322e706e67, 0x536c696465496d616765332e706e67, 600, '2024-05-20 18:57:01', 'true'),
(14, 'Vans Old Skool', 'The Vans Old Skool, a classic staple in the Vans lineup, is a womens sneaker that seamlessly blends style, comfort, and durability. Recognizable by its iconic side stripe, the Old Skool features a low-top silhouette crafted from durable canvas and suede uppers, providing a perfect balance of robustness and style. The shoe is equipped with a padded collar for extra support and flexibility, making it suitable for all-day wear.', 'old, skool, women, vans, skate, life, style', 7, 10, 0x4f6c64536b6f6f6c2d4d61696e2e6a7067, 0x4f6c64536b6f6f6c496d616765312e6a7067, 0x4f6c64536b6f6f6c496d616765332e6a7067, 900, '2024-05-20 19:10:01', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_user`
--

CREATE TABLE `site_user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `cpassword` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_user`
--

INSERT INTO `site_user` (`user_id`, `first_name`, `last_name`, `email_address`, `phone_number`, `pwd`, `cpassword`, `user_ip`) VALUES
(2, 'Ofentse', 'Masekwameng', 'unknow@gmail.com', '2468121416', '$2y$10$ZdTQTnRDY9JIbLQ2SL5KLuf0UwhriaMnsvh259gubnewmbY0gCy3e', '$2y$10$BD4YEBTvhs82tgE/KEhcieoZY13HcFWWtoi3QnIaLjsMCZY4vsHo6', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`address_id`, `user_id`, `street`, `city`, `state`, `country`, `postal_code`) VALUES
(2, 2, '', 'Joburg', 'Gauteng', 'South Africa', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_product` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_product`, `order_date`, `order_status`) VALUES
(35, 2, 3264, 335587793, 3, '2024-06-07 20:59:38', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `website_reviews`
--

CREATE TABLE `website_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_reviews`
--

INSERT INTO `website_reviews` (`review_id`, `user_id`, `rating`, `review_text`, `review_date`) VALUES
(1, 2, 3, 'Trash site', '2024-06-08 00:01:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_id` (`category_id`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `site_user`
--
ALTER TABLE `site_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_address` (`email_address`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `website_reviews`
--
ALTER TABLE `website_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_user`
--
ALTER TABLE `site_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `website_reviews`
--
ALTER TABLE `website_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`);

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`);

--
-- Constraints for table `user_location`
--
ALTER TABLE `user_location`
  ADD CONSTRAINT `user_location_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`);

--
-- Constraints for table `website_reviews`
--
ALTER TABLE `website_reviews`
  ADD CONSTRAINT `website_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
