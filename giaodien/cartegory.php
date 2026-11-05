<?php
    include "./slider_top.php";
    include "./class/product_class.php"; // Cập nhật để sử dụng lớp product từ product_class.php
?>
<?php
    $brand = new brand;
    $show_brand = $brand ->show_brand();
    $product = new product();

    // Nếu có từ khóa tìm kiếm
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $products = $product->search_product_by_name($search);
        $is_search = true;
    } else {
        // Lấy sản phẩm theo category như cũ
        $is_search = false;
        // ... phần lấy $category_id, $brand_id và $products như bạn đã có ...
    }
    
?>


<section class="cartegory">
    <?php
        // Lấy category_id và brand_id từ URL
        if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $products = $product->search_product_by_name($search);
        $is_search = true;
        } else {
            // Lấy category_id và brand_id từ URL
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
            $brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;

            // Chỉ kiểm tra category_id khi không phải tìm kiếm
            if ($category_id === null) {
                echo "<p>Vui lòng cung cấp category_id hợp lệ.</p>";
                $products = false;
            } else {
                // Truy vấn sản phẩm từ cơ sở dữ liệu
                $products = $product->get_products_by_category_and_brand($category_id, $brand_id);
            }
            $is_search = false;
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="cartegory-left">
                <ul>
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
                        <li class="cartegory-left-li">
                            <!-- Khi click vào category, chuyển hướng đến trang với category_id -->
                            <a href="#"><?php echo $category_name; ?></a>
                            <ul class="sub-menu-left">
                                <?php
                                // Lặp qua từng brand trong danh sách của category
                                foreach ($brands as $brand) {
                                    ?>
                                    <li>
                                        <!-- Khi click vào brand, chuyển hướng đến trang với cả category_id và brand_id -->
                                        <a href="cartegory.php?category_id=<?php echo $brand['category_id']; ?>&brand_id=<?php echo $brand['brand_id']; ?><?php echo $user_id ? '&user_id=' . $user_id : ''; ?>">
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
                </ul>
            </div>  
            <div class="cartegory-right row">
                <?php
                if (isset($products) && $products) {
                    if ($is_search) {
                        echo '<div style="width:100%;"><h2>Kết quả tìm kiếm cho "<span style="color:orangered;">' . htmlspecialchars($search) . '</span>"</h2></div>';
                    } else {
                        echo '<div style="width:100%;"><h2>HÀNG MỚI VỀ</h2></div>';
                    }
                    $found = false; 
                    while ($product = $products->fetch_assoc()) {
                        $found = true;
                        $imagePath = './admin/class/uploads/' . $product['product_img'];
                        if (!file_exists($imagePath)) {
                            $imagePath = './giaodien/admin/class/uploads/default.jpg';
                        }
                        ?>
                            <div class="cartegory-right-content-item">
                                <a href="product.php?product_id=<?php echo $product['product_id']; ?>">
                                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $product['product_name']; ?>">
                                    <h1><?php echo $product['product_name']; ?></h1>
                                    <p><?php echo number_format($product['product_price'], 0, ',', '.'); ?><sup>VNĐ</sup></p>
                                </a>
                            </div>
                        <?php
                    // echo '</div>';
                            }
                            if (!$found) {
                                echo "<p>Không tìm thấy sản phẩm phù hợp.</p>";
                            }
                        } else {
                            echo "<p>Không có sản phẩm nào.</p>";
                        }
                        ?>
                <!-- quatrang -->
                <div class="cartegory-right-bottom row">
                    <div class="cartegory-right-bottom-item">
                        <p>Hiển thị 2 <span>|</span> 4 sản phẩm</p>
                    </div>
                    <div class="cartegory-right-bottom-item">
                        <p><i class="fa-solid fa-angles-left"></i><span>1 2 3 4 5</span><i class="fa-solid fa-angles-right"></i>Trang cuối</p>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
<?php
    include "./slider_bot.php";
?>
