-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2022 at 09:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `psrs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `order` int(30) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `order`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Main', 0, 1, 0, '2022-06-01 09:32:45', '2022-06-01 10:06:49'),
(2, 'Category 101', 1, 1, 0, '2022-06-01 09:33:59', '2022-06-01 10:06:49'),
(3, 'Category 102', 2, 1, 0, '2022-06-01 09:34:33', '2022-06-01 09:34:33'),
(4, 'Category 103', 3, 1, 0, '2022-06-01 09:35:20', '2022-06-01 09:35:20'),
(5, 'Category 104', 4, 1, 0, '2022-06-01 09:35:27', '2022-06-01 10:07:27'),
(6, 'Category 105', 5, 1, 0, '2022-06-01 09:36:15', '2022-06-01 10:07:27'),
(7, 'Category 106', 6, 0, 0, '2022-06-01 10:07:43', '2022-06-01 10:07:43'),
(8, 'test - updated', 8, 1, 1, '2022-06-01 10:07:49', '2022-06-01 10:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `field_list`
--

CREATE TABLE `field_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `order` int(30) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `field_list`
--

INSERT INTO `field_list` (`id`, `category_id`, `name`, `order`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 1, 'Field #1', 0, 1, 0, '2022-06-01 10:25:42', '2022-06-01 11:07:41'),
(2, 2, 'Field #2', 1, 1, 0, '2022-06-01 10:26:17', '2022-06-01 10:26:17'),
(3, 2, 'Field #1', 0, 1, 0, '2022-06-01 10:27:09', '2022-06-01 10:39:55'),
(4, 2, 'Field #3', 2, 1, 0, '2022-06-01 10:27:29', '2022-06-01 10:39:55'),
(5, 1, 'Field #2', 1, 1, 0, '2022-06-01 10:27:40', '2022-06-01 11:07:41'),
(6, 1, 'Field #3', 2, 1, 0, '2022-06-01 10:27:47', '2022-06-01 11:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_list`
--

CREATE TABLE `inquiry_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text DEFAULT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inquiry_list`
--

INSERT INTO `inquiry_list` (`id`, `fullname`, `contact`, `email`, `subject`, `message`, `status`, `date_created`, `date_updated`) VALUES
(2, 'Mark Cooper', '09123456789', 'mcooper@sample.com', 'Sample Inquiry', 'This is a sample inquiry only', 1, '2022-05-26 14:13:47', '2022-05-26 14:14:12'),
(4, 'John Smith', '0978945645', 'jsmith@sample.com', 'Sample Inquiry #2', 'This is my sample question.', 0, '2022-05-26 15:32:54', '2022-05-26 15:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `thumbnail_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `code`, `name`, `description`, `thumbnail_path`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '6231214', 'PC Set #101', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla mattis aliquam est eget cursus. Aliquam magna tortor, dictum ut efficitur eu, sollicitudin sit amet elit. Phasellus sit amet posuere elit. In quis est eu libero bibendum aliquet. Suspendisse finibus mauris dui, sit amet tincidunt justo dapibus vitae.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'uploads/thumbnails/product_1.png?v=1654055623', 1, 0, '2022-06-01 11:53:43', '2022-06-01 11:53:43'),
(2, '123123', 'test', '&lt;p&gt;test&lt;/p&gt;', 'uploads/thumbnails/product_2.png?v=1654062747', 1, 0, '2022-06-01 13:52:27', '2022-06-01 13:52:27'),
(3, '8798546', 'Laptop #101', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Duis porta elit eu ex pharetra sodales. Sed mi augue, mollis at tempus et, euismod non augue. Mauris id diam est. Nulla tempus placerat elit non tincidunt. Duis lobortis urna vitae magna semper, tincidunt semper nunc dictum. Sed imperdiet ipsum ac nulla fermentum lobortis. Aliquam mattis massa vel dolor lobortis, eget vehicula nulla eleifend. Pellentesque nec aliquam mi.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'uploads/thumbnails/product_3.png?v=1654063238', 1, 0, '2022-06-01 14:00:37', '2022-06-01 14:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_meta`
--

CREATE TABLE `product_meta` (
  `product_id` int(30) NOT NULL,
  `field_id` int(30) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_meta`
--

INSERT INTO `product_meta` (`product_id`, `field_id`, `meta_value`) VALUES
(1, 1, 'Sed enim leo'),
(1, 5, 'luctus eget mollis non'),
(1, 6, 'malesuada nec sem'),
(1, 3, 'Duis purus turpis'),
(1, 2, 'vulputate vel lorem eu'),
(1, 4, 'dictum ultrices tellus'),
(2, 1, 'asd'),
(2, 5, 'qwe'),
(2, 6, 'zxc'),
(2, 3, 'agf'),
(2, 2, 'dad'),
(2, 4, 'dfg'),
(3, 1, 'Curabitur orci nunc'),
(3, 5, 'placerat quis nisl tristique'),
(3, 6, 'porttitor pulvinar ipsum'),
(3, 3, 'Vestibulum nec eleifend neque'),
(3, 2, 'Vestibulum rhoncus'),
(3, 4, 'nunc ut rutrum pharetra');

-- --------------------------------------------------------

--
-- Table structure for table `quote_list`
--

CREATE TABLE `quote_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `fullname` text NOT NULL,
  `email` text DEFAULT NULL,
  `contact` text NOT NULL,
  `origin` text NOT NULL,
  `destination` text NOT NULL,
  `schedule` date NOT NULL,
  `remarks` text NOT NULL,
  `admin_remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quote_list`
--

INSERT INTO `quote_list` (`id`, `code`, `fullname`, `email`, `contact`, `origin`, `destination`, `schedule`, `remarks`, `admin_remarks`, `status`, `date_created`, `date_updated`) VALUES
(2, '2022052600001', 'Mark Cooper', 'mcooper@sample.com', '09123456789', 'Sample Origin', 'Sample Destination', '2022-06-08', 'Nullam vitae ullamcorper metus. Praesent tempor nunc eu malesuada varius. Donec porta cursus purus, ac tincidunt nibh placerat congue. Nunc lorem nibh, volutpat ac tortor vitae, fermentum hendrerit dolor. Duis et nisl egestas velit faucibus interdum et ut arcu. Pellentesque porttitor neque ut neque consequat condimentum. Proin molestie fermentum mi ut molestie. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'Donec at ligula eu velit eleifend dignissim eu non lacus. Vivamus et blandit erat. Aliquam blandit orci eget congue finibus. Maecenas ornare mi risus. In hac habitasse platea dictumst. Nunc ac dictum elit. Cras sed rhoncus lacus, vitae pharetra dolor. Pellentesque a ante quis nisl blandit ultricies. Vivamus rhoncus blandit sapien eget dapibus. Nulla mollis sapien ut vestibulum tempus. Donec convallis hendrerit rhoncus.', 1, '2022-05-26 15:24:48', '2022-05-26 15:26:01'),
(3, '2022052600002', 'John Smith', 'jsmith@sample.com', '0978945645', 'Address 101', 'Address 102', '2022-06-07', 'Sample only', '', 0, '2022-05-26 15:32:20', '2022-05-26 15:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Product Show Room Site'),
(6, 'short_name', 'PSRS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1654045487'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1654045488'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@sample.com'),
(20, 'address', '7087 Henry St. Clifton Park, NY 12065');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-05-16 14:17:49'),
(7, 'John', 'D', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', 'uploads/avatars/7.png?v=1654065792', NULL, 2, '2022-05-26 11:04:16', '2022-06-01 14:43:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_list`
--
ALTER TABLE `field_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_meta`
--
ALTER TABLE `product_meta`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `quote_list`
--
ALTER TABLE `quote_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `field_list`
--
ALTER TABLE `field_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quote_list`
--
ALTER TABLE `quote_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `field_list`
--
ALTER TABLE `field_list`
  ADD CONSTRAINT `category_id_fk_fl` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product_meta`
--
ALTER TABLE `product_meta`
  ADD CONSTRAINT `field_id_fk_pm` FOREIGN KEY (`field_id`) REFERENCES `field_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_id_fk_pm` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
