-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 04:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` text DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `otp` int(11) DEFAULT NULL,
  `otp_verify` int(11) NOT NULL DEFAULT 0,
  `time` datetime DEFAULT NULL,
  `profile` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `email`, `password`, `phone`, `active`, `otp`, `otp_verify`, `time`, `profile`) VALUES
(1, 'admin', 'Admin123@45', '9360392849', 1, 496551, 3, '2023-01-03 13:54:36', 'white.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_img` varchar(300) NOT NULL,
  `size` text NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(20) NOT NULL,
  `color` text NOT NULL,
  `total` int(20) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'men'),
(2, 'women'),
(3, 'kid');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `address` varchar(200) NOT NULL,
  `delivery` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_img` varchar(100) NOT NULL,
  `size` text NOT NULL,
  `quantity` int(10) NOT NULL,
  `color` text NOT NULL,
  `price` int(20) NOT NULL,
  `time` datetime NOT NULL,
  `status` text NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `collection_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `category_id`, `collection_name`) VALUES
(1, 1, 'T-shirt'),
(2, 1, 'Shorts'),
(3, 1, 'Shirt'),
(4, 1, 'Pant'),
(5, 2, 'T-shirt'),
(6, 2, 'Pant'),
(7, 2, 'Kurthi'),
(8, 2, 'Chudithar Top'),
(9, 2, 'Chudithar Pant\r\n'),
(10, 3, 'T-shirt'),
(11, 3, 'Shorts');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(10) NOT NULL,
  `message` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mens`
--

CREATE TABLE `mens` (
  `product_id` int(11) NOT NULL,
  `category` text NOT NULL,
  `product_type` text NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_img` varchar(200) NOT NULL,
  `color` text NOT NULL,
  `mrp` int(20) NOT NULL,
  `price` int(20) NOT NULL,
  `description` varchar(300) NOT NULL,
  `information` varchar(300) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mens`
--

INSERT INTO `mens` (`product_id`, `category`, `product_type`, `product_name`, `product_img`, `color`, `mrp`, `price`, `description`, `information`, `active`) VALUES
(1, 'men', 'T-shirt', 'White t-shirt', 'white.jpeg ', 'White', 200, 190, 'Very nice', 'Good product', 1),
(3, 'women', 'T-shirt', 'White t-shirt', 'white-t-shirt.jpeg ', 'White', 300, 250, 'Good ', 'Nice ', 1),
(4, 'men', 'T-shirt', 'Black T-shirt', 'black.jpeg ', 'Black', 200, 150, 'Good ', 'Nice ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mens_size`
--

CREATE TABLE `mens_size` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category` text NOT NULL,
  `product_type` text NOT NULL,
  `size` text NOT NULL,
  `quantity` int(20) NOT NULL,
  `mrp` int(20) NOT NULL,
  `price` int(20) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mens_size`
--

INSERT INTO `mens_size` (`id`, `product_id`, `category`, `product_type`, `size`, `quantity`, `mrp`, `price`, `active`) VALUES
(1, 1, 'men', 'White t-shirt', 'X', 9, 200, 180, 1),
(2, 1, 'men', 'White t-shirt', 'XL', 5, 250, 200, 1),
(8, 3, 'women', 'T-shirt', 'XL', 10, 260, 230, 1),
(10, 3, 'women', 'T-shirt', 'M', 9, 180, 150, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(200) NOT NULL,
  `avatar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `rating` float NOT NULL,
  `name` text NOT NULL,
  `message` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subcribe`
--

CREATE TABLE `subcribe` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` text NOT NULL,
  `password` varchar(300) NOT NULL,
  `cofirm_password` varchar(300) NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `active_token` int(11) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes',
  `active_time` datetime DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0 COMMENT '0=inactive,1=active',
  `otp` int(11) DEFAULT NULL,
  `otp_verify` int(11) NOT NULL DEFAULT 0 COMMENT '0=not_send,1=send,2=expired,3=use',
  `otp_verify_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`phone`) USING HASH;

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mens`
--
ALTER TABLE `mens`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `mens_size`
--
ALTER TABLE `mens_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`,`phone`) USING HASH,
  ADD UNIQUE KEY `username_2` (`username`,`email`,`phone`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mens`
--
ALTER TABLE `mens`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mens_size`
--
ALTER TABLE `mens_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `subcribe`
--
ALTER TABLE `subcribe`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `mens_size`
--
ALTER TABLE `mens_size`
  ADD CONSTRAINT `mens_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `mens` (`product_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

--
-- Constraints for table `subcribe`
--
ALTER TABLE `subcribe`
  ADD CONSTRAINT `subcribe_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
