-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2023 at 06:30 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mending_hems`
--

-- --------------------------------------------------------

--
-- Table structure for table `activate`
--

DROP TABLE IF EXISTS `activate`;
CREATE TABLE IF NOT EXISTS `activate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `user_id` int NOT NULL,
  `variant` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `submit_fabrics` int NOT NULL DEFAULT '0',
  `profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `variants` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customize`
--

DROP TABLE IF EXISTS `customize`;
CREATE TABLE IF NOT EXISTS `customize` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `map` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customize`
--

INSERT INTO `customize` (`id`, `product_id`, `map`) VALUES
(1, 5, '{\n  \"fabric\": {\n    \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4697.png\",\n    \"data\": [\n      {\n        \"name\": \"cotton\",\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4374.png\",\n        \"data\": \"https://source.unsplash.com/500x500/?cotton\",\n        \"price\": 14\n      },\n      {\n        \"name\": \"wool\",\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4701.png\",\n        \"data\": \"https://source.unsplash.com/500x500/?wool\",\n        \"price\": 17\n      }\n    ]\n  },\n  \"options\": {\n    \"sleeve\": {\n      \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/1.svg\",\n      \"data\": [\n        {\n          \"name\": \"long sleeves\",\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/1.svg\",\n          \"data\": \"http://localhost/mending-hems/images/long-slevees.png\",\n          \"price\": 45\n        },\n        {\n          \"name\": \"short sleeves\",\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/2.svg\",\n          \"data\": \"http://localhost/mending-hems/images/short-slevees.png\",\n          \"price\": 9\n        }\n      ]\n    },\n    \"pocket\": {\n      \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/pocketPlacement/0.svg\",\n      \"data\": [\n        {\n          \"name\": \"no pockets\",\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/pocketPlacement/0.svg\",\n          \"data\": \"http://localhost/mending-hems/images/short-slevees.png\",\n          \"price\": 7\n        },\n        {\n          \"name\": \"left pocket\",\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/pocketPlacement/1.svg\",\n          \"data\": \"http://localhost/mending-hems/images/left-pocket.png\",\n          \"price\": 4\n        },\n        {\n          \"name\": \"both pocket\",\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/pocketPlacement/3.svg\",\n          \"data\": \"http://localhost/mending-hems/images/both-pocket.png\",\n          \"price\": 23\n        }\n      ]\n    }\n  }\n}'),
(5, 4, '{\r\n  \"fabric\": {\r\n    \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4697.png\",\r\n    \"data\": [\r\n      {\r\n        \"name\": \"cotton\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4374.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/107489/FabricPatterns0118_1_350.jpg\",\r\n        \"price\": 45\r\n      },\r\n      {\r\n        \"name\": \"wool\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4375.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/106452/FabricPatterns0117_350.jpg\",\r\n        \"price\": 75\r\n      },\r\n      {\r\n        \"name\": \"chiffon\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4376.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/40583/FabricPatterns0109_350.jpg\",\r\n        \"price\": 56\r\n      }\r\n    ]\r\n  },\r\n  \"options\": {\r\n    \"sleeve\": {\r\n      \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/1.svg\",\r\n      \"data\": [\r\n        {\r\n          \"name\": \"long sleeves\",\r\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/1.svg\",\r\n          \"data\": \"https://cdn.shopify.com/s/files/1/2382/1249/products/under-armour-t-shirts-xs-white-under-armour-ladies-long-sleeve-locker-t-shirt-2-0-10842272563223_2048x2048.jpg?v=1611143610\",\r\n          \"price\": 45\r\n        },\r\n        {\r\n          \"name\": \"short sleeves\",\r\n          \"icon\": \"https://cdn.tailorstore.com/ui/emerald/choices/26/sleeve/2.svg\",\r\n          \"data\": \"https://cdn.shopify.com/s/files/1/0985/8624/products/1_39f042bc-ee29-47e6-9061-b120a20b97e7_grande.png?v=1644419908\",\r\n          \"price\": 99\r\n        }\r\n      ]\r\n    },\r\n    \"pants\": {\r\n      \"icon\": \"https://www.nicepng.com/png/detail/538-5385918_clip-black-and-white-download-costura-e-roupas.png\",\r\n      \"data\": [\r\n        {\r\n          \"name\": \"short\",\r\n          \"icon\": \"https://www.seekpng.com/png/detail/73-739090_jeans-clipart-transparent-pants-clipart.png\",\r\n          \"data\": \"https://m.media-amazon.com/images/I/61Bahgd15DL._UX569_.jpg\",\r\n          \"price\": 70\r\n        },\r\n        {\r\n          \"name\": \"cargo\",\r\n          \"icon\": \"https://us.123rf.com/450wm/nikiteev/nikiteev1808/nikiteev180800067/111849293-vector-single-cartoon-illustration-green-jogger-trousers-on-white-background.jpg?ver=6\",\r\n          \"data\": \"https://rukminim1.flixcart.com/image/612/612/xif0q/cargo/u/x/9/28-sb2-hyooo-original-imag4vx7tumf7zzz-bb.jpeg?q=70\",\r\n          \"price\": 40\r\n        },\r\n        {\r\n          \"name\": \"jeans\",\r\n          \"icon\": \"https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/39334/pants-clipart-xl.png\",\r\n          \"data\": \"https://static.fibre2fashion.com/MemberResources/LeadResources/1/2019/4/Seller/19161744/Images/19161744_0_ladies-denim-jeans-pants.jpg\",\r\n          \"price\": 23\r\n        }\r\n      ]\r\n    }\r\n  }\r\n}'),
(6, 2, '{\r\n  \"fabric\": {\r\n    \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4697.png\",\r\n    \"data\": [\r\n      {\r\n        \"name\": \"cotton\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4374.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/107489/FabricPatterns0118_1_350.jpg\",\r\n        \"price\": 45\r\n      },\r\n      {\r\n        \"name\": \"wool\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4375.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/106452/FabricPatterns0117_350.jpg\",\r\n        \"price\": 75\r\n      },\r\n      {\r\n        \"name\": \"chiffon\",\r\n        \"icon\": \"https://rnd.tailorstore.com/MTIwfDEyMHw5MHxmZmZmZmY,/render/shirt/normal/icons/swatch/4376.png\",\r\n        \"data\": \"https://www.textures.com/system/gallery/photos/Fabric/Patterned%20Fabric/40583/FabricPatterns0109_350.jpg\",\r\n        \"price\": 56\r\n      }\r\n    ]\r\n  },\r\n  \"options\": {\r\n    \"suits\" : {\r\n      \"icon\" : \"https://www.esilai.com/image/cache/data/esilai/a-line-from-bust-280x280.jpg\",\r\n      \"data\" : [\r\n        {\r\n          \"name\" : \"A line suit\",\r\n          \"icon\" : \"https://www.esilai.com/image/cache/data/esilai/a-line-from-bust-280x280.jpg\",\r\n          \"data\" : \"https://www.esilai.com/image/cache/data/esilai/a-line-from-bust-280x280.jpg\",\r\n          \"price\" : 45.7\r\n        },\r\n        {\r\n          \"name\" : \"Anarkali suit\",\r\n          \"icon\" : \"https://www.esilai.com/image/cache/data/esilai/anarkali-gathered-280x280.jpg\",\r\n          \"data\" : \"https://www.esilai.com/image/cache/data/esilai/anarkali-gathered-280x280.jpg\",\r\n          \"price\" : 165.85\r\n        },\r\n        {\r\n          \"name\" : \"Angrakha suit\",\r\n          \"icon\" : \"https://www.esilai.com/image/cache/data/esilai/angrakha-280x280.jpg\",\r\n          \"data\" : \"https://www.esilai.com/image/cache/data/esilai/angrakha-280x280.jpg\",\r\n          \"price\" : 265\r\n        }\r\n      ]\r\n    },\r\n    \"Front Neck Design\": {\r\n      \"icon\": \"http://www.esilai.com/image/cache/data/esilai/assymetrical-with-cords-front-280x280.jpg\",\r\n      \"data\": [\r\n        {\r\n          \"name\": \"Assymetrical With Cords\",\r\n          \"icon\": \"http://www.esilai.com/image/cache/data/esilai/assymetrical-with-cords-front-280x280.jpg\",\r\n          \"data\": \"http://www.esilai.com/image/cache/data/esilai/assymetrical-with-cords-front-280x280.jpg\",\r\n          \"price\": 75\r\n        },\r\n        {\r\n          \"name\": \"Axe With U\",\r\n          \"icon\": \"http://www.esilai.com/image/cache/data/esilai/axe-with-u-front-280x280.jpg\",\r\n          \"data\": \"http://www.esilai.com/image/cache/data/esilai/axe-with-u-front-280x280.jpg\",\r\n          \"price\": 99\r\n        }\r\n      ]\r\n    },\r\n    \"sleeves\": {\r\n      \"icon\": \"http://www.esilai.com/image/cache/data/esilai/batwing-280x280.jpg\",\r\n      \"data\": [\r\n        {\r\n          \"name\": \"Batwing\",\r\n          \"icon\": \"http://www.esilai.com/image/cache/data/esilai/batwing-280x280.jpg\",\r\n          \"data\": \"http://www.esilai.com/image/cache/data/esilai/batwing-280x280.jpg\",\r\n          \"price\": 70\r\n        },\r\n        {\r\n          \"name\": \"Bell\",\r\n          \"icon\": \"http://www.esilai.com/image/cache/data/esilai/bell-280x280.jpg\",\r\n          \"data\": \"http://www.esilai.com/image/cache/data/esilai/bell-280x280.jpg\",\r\n          \"price\": 40\r\n        },\r\n        {\r\n          \"name\": \"Bishop\",\r\n          \"icon\": \"http://www.esilai.com/image/cache/data/esilai/bishop-280x280.jpg\",\r\n          \"data\": \"http://www.esilai.com/image/cache/data/esilai/bishop-280x280.jpg\",\r\n          \"price\": 23\r\n        }\r\n      ]\r\n    }\r\n  }\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(20) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `card_expiry` varchar(20) NOT NULL,
  `card_cv2` varchar(10) NOT NULL,
  `card_holder_name` varchar(25) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` int NOT NULL,
  `total` varchar(10) NOT NULL,
  `cart` text NOT NULL,
  `publisher` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `email`, `card_number`, `card_expiry`, `card_cv2`, `card_holder_name`, `address`, `state`, `zip_code`, `total`, `cart`, `publisher`, `quantity`, `price`, `product_id`) VALUES
(10, 1, '', '', '', '', '', '', '', 0, '1,353.72', '', 2, 2, 978, 6),
(11, 1, '', '', '', '', '', '', '', 0, '1,353.72', '{\"fabric\":{\"name\":\"cotton\",\"price\":14},\"options.sleeve\":{\"name\":\"short sleeves\",\"price\":9},\"options.pocket\":{\"name\":\"left pocket\",\"price\":4}}', 2, 1, 189, 5),
(12, 3, '', '', '', '', '', '', '', 0, '223.02', '{\"options.pocket\":{\"name\":\"left pocket\",\"price\":4},\"options.sleeve\":{\"name\":\"long sleeves\",\"price\":45}}', 2, 1, 189, 5),
(19, 1, '', '', '', '', '', '', '', 0, '419.23', '', 8, 1, 189, 5),
(20, 1, '', '', '', '', '', '', '', 0, '1,216.84', '', 8, 2, 378, 5),
(21, 1, '', '', '', '', '', '', '', 0, '1,216.84', '', 8, 1, 489, 6),
(25, 1, '', '', '', '', '', '', '', 0, '989.00', '', 2, 1, 182, 11),
(26, 1, '', '', '', '', '', '', '', 0, '67.79', '{\"fabric\":{\"name\":\"wool\",\"price\":75},\"options.sleeve\":{\"name\":\"short sleeves\",\"price\":99},\"options.pants\":{\"name\":\"jeans\",\"price\":23}}', 2, 1, 59, 4);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `summary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`id`, `user_id`, `order_id`, `summary`) VALUES
(3, 1, 26, '{\"total\":\"67.79\",\"products\":[{\"image\":\"http://localhost/mending-hems/images/s1.jpg\",\"product_name\":\"Product 4\",\"quantity\":\"1\"}]}'),
(2, 1, 25, '{\"total\":\"989.00\",\"products\":[{\"image\":\"http://localhost/mending-hems/images/pn-1.png\",\"product_name\":\"Harbour Grey Power-Stretch Pants\",\"quantity\":\"1\"},{\"image\":\"http://localhost/mending-hems/images/p2.png\",\"product_name\":\"Hand Stiched Casual Tuxedo\",\"quantity\":\"1\"},{\"image\":\"http://localhost/mending-hems/images/6716468.png\",\"product_name\":\"blue shirt\",\"quantity\":\"1\"}]}');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `publisher` int DEFAULT NULL,
  `sizes` varchar(255) DEFAULT NULL,
  `attributes` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text,
  `accept_fabrics` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `publisher` (`publisher`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `price`, `images`, `publisher`, `sizes`, `attributes`, `active`, `name`, `category`, `description`, `accept_fabrics`) VALUES
(1, '19.99', 'http://localhost/mending-hems/images/product-1.png,http://localhost/mending-hems/images/product-1.png,http://localhost/mending-hems/images/product-2.png,http://localhost/mending-hems/images/product-3.png', 2, 'SM,MD', '{\"color\": \"Red\", \"material\": \"Cotton\"}', 1, 'Product 1', 'salwar', 'This is a description for Product 1', 0),
(2, '29.99', 'https://source.unsplash.com/random,https://source.unsplash.com/random', 2, 'LG', '{\"color\": \"Green\", \"material\": \"Polyester\"}', 1, 'Product 2', 'suit', 'This is a description for Product 2', 0),
(3, '49.99', 'http://localhost/mending-hems/images/product-1.png,http://localhost/mending-hems/images/product-2.png,http://localhost/mending-hems/images/product-2.png,http://localhost/mending-hems/images/product-3.png', 1, 'SM,MD,LG', '{\"color\": \"Blue\", \"material\": \"Wool\"}', 1, 'White Solid Color Wool Suit', 'blouse', 'This is a description for Product 3', 0),
(4, '59.99', 'http://localhost/mending-hems/images/s1.jpg,http://localhost/mending-hems/images/blouse.png,http://localhost/mending-hems/images/s6.png', 2, 'SM,XL,XXL', '{\"color\": \"Yellow\", \"material\": \"Linen\"}', 1, 'Product 4', 'salwar', 'This is a description for Product 4', 0),
(5, '189.00', 'http://localhost/mending-hems/images/p2.png,http://localhost/mending-hems/images/p3.png,http://localhost/mending-hems/images/p4.png', 2, 'SM,MD,XL,XXL', '{\"color\" : [\"brown\",\"black\",\"white\"]}', 1, 'Hand Stiched Casual Tuxedo', 'suit', 'a fully hand made blazer with multiple colors available along various customizable options.', 1),
(6, '489.00', 'http://localhost/mending-hems/images/pn-1.png,http://localhost/mending-hems/images/pn-2.png,http://localhost/mending-hems/images/pn-3.png', 2, 'SM,MD,XL,XXL', '{\"color\" : [\"brown\",\"black\",\"white\"]}', 1, 'Harbour Grey Power-Stretch Pants', 'pants', 'We get our customers fit right on the first order 90%+ of the times. \r\n\r\nIf it does not fit you, don’t worry, we pick up your pants and alter them for free within 14 days. No questions asked! ', 1),
(11, '182.00', 'http://localhost/mending-hems/images/6716468.png', 2, 'SM,MD,XL', '{}', 1, 'blue shirt', 'shirt', 'A cool blue casual shirt for all genders , good quality.                ', 1);

--
-- Triggers `products`
--
DROP TRIGGER IF EXISTS `delete_product_from_cart`;
DELIMITER $$
CREATE TRIGGER `delete_product_from_cart` AFTER DELETE ON `products` FOR EACH ROW BEGIN
    DELETE FROM cart WHERE product_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(255) NOT NULL,
  `profile_data` json NOT NULL,
  `gender` char(10) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `profile_name`, `profile_data`, `gender`, `user_id`) VALUES
(1, 'personal-1', '{\"height\": \"180\", \"hip-size\": \"147\", \"leg-size\": \"180\", \"neck-size\": \"32\", \"arm-length\": \"185\", \"chest-size\": \"123\", \"waist-size\": \"156\", \"wrist-size\": \"170\", \"shirt-length\": \"145\", \"shoulder-width\": \"156\"}', 'M', 1),
(2, 'friend-1', '{\"height\": \"180\", \"hip-size\": \"147\", \"leg-size\": \"180\", \"neck-size\": \"32\", \"arm-length\": \"185\", \"chest-size\": \"123\", \"waist-size\": \"156\", \"wrist-size\": \"170\", \"shirt-length\": \"145\", \"shoulder-width\": \"156\"}', 'F', 1),
(3, 'new-cool-profile', '{\"neck\": \"67\", \"chest\": \"77\", \"waist\": \"56\", \"wrist\": \"65\", \"hip_size\": \"87\", \"arm_length\": \"87\", \"leg_length\": \"45\", \"shirt_length\": \"89\", \"shoulder_width\": \"45\"}', 'M', 3),
(4, 'good-dress', '{\"arm\": \"87\", \"hips\": \"78\", \"neck\": \"78\", \"waist\": \"78\", \"dress_length\": \"9\", \"neck_opening\": \"78\", \"bust_distance\": \"78\", \"sleeve_length\": \"78\", \"shoulder_length\": \"87\"}', 'F', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `type` enum('admin','tailor','guest','') NOT NULL DEFAULT 'guest',
  `active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `type`, `active`) VALUES
(1, 'togid49953', 'togid49953@crtsec.com', '34567890', 'password', 'guest', 1),
(2, 'trends', 'trends@tailors.com', '34567890', 'password', 'tailor', 1),
(3, 'titil93527', 'titil93527@crtsec.com', '356789', '12345', 'guest', 0),
(8, 'ditazowu', 'ditazowu@brand-app.biz', '23456789', '12345', 'tailor', 1),
(10, 'admin', 'admin@hems.com', '348998987', 'password', 'admin', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
