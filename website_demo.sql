-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 03, 2026 lúc 01:01 PM
-- Phiên bản máy phục vụ: 10.11.16-MariaDB
-- Phiên bản PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `website_demo`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_binhluan`
--

CREATE TABLE `tbl_binhluan` (
  `idbinhluan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_taikhoan` varchar(255) NOT NULL,
  `thoigian` date NOT NULL,
  `binhluan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `category_id`, `brand_name`) VALUES
(1, 1, 'Áo'),
(2, 1, 'Quần'),
(3, 1, 'Giầy'),
(4, 2, 'Áo'),
(5, 2, 'Quần'),
(6, 2, 'Giầy'),
(8, 3, 'Áo'),
(9, 3, 'Quần'),
(10, 3, 'Giầy'),
(11, 4, 'Mũ'),
(12, 4, 'Kính'),
(13, 4, 'Khác');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_ma` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `cart_size` varchar(10) NOT NULL,
  `cart_sl` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(1, 'NAM'),
(2, 'NỮ'),
(3, 'TRẺ EM'),
(4, 'PHỤ KIỆN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_chitietdonhang`
--

CREATE TABLE `tbl_chitietdonhang` (
  `idchitiet` int(11) NOT NULL,
  `donhang_id` int(11) NOT NULL,
  `idvoucher` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_ma` varchar(255) NOT NULL,
  `cart_size` varchar(10) NOT NULL,
  `product_soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_donhang`
--

CREATE TABLE `tbl_donhang` (
  `donhang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `sdt` varchar(15) NOT NULL,
  `tinh_Tp` varchar(255) NOT NULL,
  `quan_huyen` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sotien` int(11) NOT NULL,
  `thoigian` date NOT NULL,
  `tinhtrang` varchar(255) NOT NULL DEFAULT 'Chờ duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_ma` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_soluong` int(11) NOT NULL,
  `product_daban` int(11) NOT NULL DEFAULT 0,
  `product_desc` varchar(5000) NOT NULL,
  `product_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `product_ma`, `category_id`, `brand_id`, `product_price`, `product_soluong`, `product_daban`, `product_desc`, `product_img`) VALUES
(1, 'Áo', '9527', 1, 1, 25000, 0, 0, 'áo', 'ao1.webp'),
(2, 'áo 3 lỗ', '12345', 1, 1, 27000, 269, 31, 'áo 3 lỗ', 'ao3.webp'),
(3, 'áo thun', '888', 1, 1, 27000, 293, 7, 'quần', 'ao2.webp'),
(5, 'quần1', '1998', 1, 2, 35000, 300, 0, 'quần', 'quan1.webp'),
(6, 'quần2', '999', 1, 2, 28000, 300, 0, 'quần', 'quan2.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_sao`
--

CREATE TABLE `tbl_sao` (
  `idsao` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_taikhoan` varchar(255) NOT NULL,
  `user_matkhau` varchar(255) NOT NULL,
  `user_sdt` varchar(15) NOT NULL,
  `user_quyen` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_voucher`
--

CREATE TABLE `tbl_voucher` (
  `idvoucher` int(11) NOT NULL,
  `tenvoucher` varchar(255) NOT NULL,
  `loaigiam` varchar(255) NOT NULL,
  `giagiam` int(11) NOT NULL,
  `slvoucher` int(11) NOT NULL,
  `luotdung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  ADD PRIMARY KEY (`idbinhluan`),
  ADD KEY `fk_binhluan_user` (`user_id`),
  ADD KEY `fk_binhluan_product` (`product_id`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`),
  ADD KEY `fk_brand_category` (`category_id`);

--
-- Chỉ mục cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_product` (`product_id`),
  ADD KEY `fk_cart_user` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  ADD PRIMARY KEY (`idchitiet`),
  ADD KEY `fk_chitiet_donhang` (`donhang_id`),
  ADD KEY `fk_chitiet_voucher` (`idvoucher`);

--
-- Chỉ mục cho bảng `tbl_donhang`
--
ALTER TABLE `tbl_donhang`
  ADD PRIMARY KEY (`donhang_id`),
  ADD KEY `fk_donhang_user` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `fk_product_category` (`category_id`),
  ADD KEY `fk_product_brand` (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_sao`
--
ALTER TABLE `tbl_sao`
  ADD PRIMARY KEY (`idsao`),
  ADD KEY `fk_sao_user` (`user_id`),
  ADD KEY `fk_sao_product` (`product_id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  ADD PRIMARY KEY (`idvoucher`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  MODIFY `idbinhluan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  MODIFY `idchitiet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_donhang`
--
ALTER TABLE `tbl_donhang`
  MODIFY `donhang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_sao`
--
ALTER TABLE `tbl_sao`
  MODIFY `idsao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  MODIFY `idvoucher` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  ADD CONSTRAINT `fk_binhluan_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_binhluan_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD CONSTRAINT `fk_brand_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  ADD CONSTRAINT `fk_chitiet_donhang` FOREIGN KEY (`donhang_id`) REFERENCES `tbl_donhang` (`donhang_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_chitiet_voucher` FOREIGN KEY (`idvoucher`) REFERENCES `tbl_voucher` (`idvoucher`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `tbl_donhang`
--
ALTER TABLE `tbl_donhang`
  ADD CONSTRAINT `fk_donhang_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `tbl_brand` (`brand_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `tbl_sao`
--
ALTER TABLE `tbl_sao`
  ADD CONSTRAINT `fk_sao_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sao_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
