<?php
    session_start();

    // Kiểm tra nếu người dùng yêu cầu đăng xuất
    if (isset($_GET['logout'])) {
        session_destroy(); // Hủy session (đăng xuất người dùng)
        header('Location: index.php'); // Chuyển hướng về trang chính mà không có user_id trong URL
        exit();
    }
    
    include "./class/class_top.php";
    // include "./admin/database.php"; // Đảm bảo bạn đã include lớp Database
    $logged_in = isset($_SESSION['user_id']);
    $user_taikhoan = $logged_in ? $_SESSION['user_taikhoan'] : null;
    // $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null; // lấy user_id từ url
    // Khởi tạo kết nối cơ sở dữ liệu
    $db = new Database(); // Tạo đối tượng Database
    $brand = new brand;
    $show_brand = $brand->show_brand();

    
?>
<?php
$messages = [
    'not_admin' => 'Bạn cần quyền admin để vào quản lý.',
    'not_logged_in' => 'Bạn cần đăng nhập trước.'
];

if (isset($_GET['error']) && isset($messages[$_GET['error']])) {
    echo "<script>alert('{$messages[$_GET['error']]}');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/0673e6ca43.js" crossorigin="anonymous"></script>
    <title>Website buôn bán quần áo</title>
</head>
<body>
    <header>
        <div class="logo">
            <!-- filepath: d:\xampp\htdocs\DEMO\giaodien\slider_top.php -->
<a href="index.php"><img src="img/logo.svg"></a>
        </div>
        <div class="menu">
                        <?php
                    // Giả sử $show_product là kết quả từ câu truy vấn đã lấy được dữ liệu từ cơ sở dữ liệu.
                    $categories = []; // Mảng để nhóm các brand theo category.

                    // Kiểm tra và xử lý dữ liệu
                    if ($show_brand) {
                        // Lặp qua từng kết quả
                        while ($result = $show_brand->fetch_assoc()) {
                            // Lấy category_name, brand_name, category_id và brand_id từ mỗi dòng kết quả
                            $category_id = $result['category_id']; // ID của category
                            $category_name = $result['category_name']; // Tên của category
                            $brand_name = $result['brand_name']; // Tên của brand
                            $brand_id = $result['brand_id']; // ID của brand

                            // Nếu chưa có category_name trong mảng categories, tạo một mảng mới cho nó
                            if (!isset($categories[$category_name])) {
                                $categories[$category_name] = [];
                            }

                            // Thêm brand vào mảng của category
                            $categories[$category_name][] = [
                                'brand_name' => $brand_name, 
                                'brand_id' => $brand_id, 
                                'category_id' => $category_id
                            ];
                        }
                    }
                    
                    // Lặp qua các category và hiển thị HTML
                    foreach ($categories as $category_name => $brands) {
                        ?>
                        <li>
                            <!-- Khi click vào category, chuyển hướng đến trang với category_id -->
                            <a href="cartegory.php?category_id=<?php echo $brands[0]['category_id']; ?>">
                            <?php echo $category_name; ?></a>
                            <ul class="sub-menu">
                                <?php
                                // Lặp qua từng brand trong danh sách của category

                                foreach ($brands as $brand) {
                                    ?>
                                    <li>
                                        <!-- Khi click vào brand, chuyển hướng đến trang với cả category_id và brand_id -->
                                        <a href="cartegory.php?category_id=<?php echo $brand['category_id']; ?>&brand_id=<?php echo $brand['brand_id']; ?>">
                                            <?php echo $brand['brand_name']; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                ?>
        <?php
            $logged_in = isset($_SESSION['user_id']);
            $user_taikhoan = $logged_in ? $_SESSION['user_taikhoan'] : null;
        ?>
        <div class="orther">
            <li>
                <form method="GET" action="cartegory.php">
                    <input placeholder="Tìm Kiếm" type="text" name="search" required>
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </li>
            <li><a style="font-weight: bold; font-size: 15px;" href="cart.php">GIỎ HÀNG <i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a style="font-weight: bold; font-size: 15px;" href="donhang.php">ĐƠN HÀNG <i class="fa-solid fa-coins"></i></i></a></li>
            <?php if ($logged_in): ?>
                <li class="user-dropdown" style="position:relative;">
                    <a href="#" style="font-weight: bold; font-size: 15px;">
                        <?php echo htmlspecialchars($user_taikhoan); ?> <i class="fa-solid fa-user"></i>
                    </a>
                    <ul class="sub-taikhoan">
                        <li><a href="taikhoan.php">Thông tin tài khoản</a></li>
                        <?php if (isset($_SESSION['user_quyen']) && $_SESSION['user_quyen'] === 'Admin'): ?>
                            <li><a href="admin/categoryadd.php">Quản lý</a></li>
                        <?php endif; ?>
                        <li><a href="?logout=1">Đăng xuất <i class="fa-solid fa-right-from-bracket"></i></a></li>
                    </ul>
                </li>
                <?php else: ?>
                    <li style="font-weight: bold; font-size: 15px;"><a href="login.php">ĐĂNG NHẬP<i class="fa-solid fa-user"></i></a></li>
                <?php endif; ?>
        </div>
    </header>
    