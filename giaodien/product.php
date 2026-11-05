<?php
    ob_start();
    include "./slider_top.php";
    include "./class/product_class.php";
    include "./class/cart_class.php";
?>
<?php
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // lấy user_id từ url
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
    if (isset($_GET['voted']) && $_GET['voted'] == 1) {
    echo "<script>alert('Cảm ơn bạn đã đánh giá sản phẩm!');</script>";
    }
    $product = new product();
    $averageVote = $product->get_average_rating($product_id);
    $avg_sao = 0;
    $total_vote = 0;

    if ($averageVote && $averageVote->num_rows > 0) {
        $voteRow = $averageVote->fetch_assoc();
        $avg_sao = round($voteRow['avg_sao'], 1);
        $total_vote = $voteRow['total'];
    }
        if ($product_id) {
            $product = new product;
            $show_product = $product->show_product($product_id);
            if ($show_product && $show_product->num_rows > 0) {
                $result = $show_product->fetch_assoc();
                $imagePath = './admin/class/uploads/' . $result['product_img'];
                if (file_exists($imagePath)) {
                    $imageSrc = $imagePath;
                } else {
                    $imageSrc = './giaodien/admin/class/uploads/default.jpg';
                }
            } else {
                echo "Sản phẩm không tồn tại hoặc lỗi truy vấn!";
                $result = false;
            }
        }  
?>
<?php
    $cart = new cart;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    if ($form_type === 'add_to_cart') {
        if (!$user_id) {
            echo "<script>alert('Vui lòng đăng nhập để mua hàng.');</script>";
        } 
        else
            {
                $cart_size = $_POST['cart_size'] ?? null;
                $cart_sl = isset($_POST['cart_sl']) ? intval($_POST['cart_sl']) : 0;
                $product_name = $result['product_name'] ?? null;
                $product_ma = $result['product_ma'] ?? null;
                $product_price = $result['product_price'] ?? null;
                $product_img = $imageSrc ?? null;

                if ($user_id && $product_id && $cart_size && $cart_sl > 0) 
                    {
                    $insert_cart = $cart->insert_cart($user_id, $product_id, $cart_size, $cart_sl, $product_name, $product_ma, $product_price, $product_img);
                    if ($insert_cart === true) 
                        {
                        echo "<script>
                            alert('Thêm vào giỏ hàng thành công!');
                            window.location.href = 'cart.php';
                        </script>";
                        exit();
                        } 
                    else 
                        {
                            echo "<script>alert('" . $insert_cart . "');</script>";
                        }
                
                    }
                    else
                        {
                            echo "<script>alert('Dữ liệu không hợp lệ!');</script>";
                        }
            }
            } elseif ($form_type === 'vote') {
                    // Kiểm tra nếu chưa đăng nhập
                    if (empty($user_id)) {
                        echo "<script>alert('Vui lòng đăng nhập để đánh giá sản phẩm.');</script>";
                    } else {
                        if (isset($_POST['sao'])) {
                            $sao = intval($_POST['sao']);
                            $productObj = new product();
                            $vote_result = $productObj->insert_vote($user_id, $product_id, $sao);
                            if ($vote_result === true) {
                                header("Location: product.php?product_id=$product_id&voted=1");
                                exit();
                            } else {
                                echo "<script>alert('$vote_result');</script>";
                            }
                        }
                    }
                }
        elseif ($form_type === 'comment') {
                if (!$user_id) {
                    echo "<script>alert('Vui lòng đăng nhập để bình luận.');</script>";
                } else {
                    $user_taikhoan = $_SESSION['user_taikhoan'] ?? 'Ẩn danh';
                    $binhluan = $_POST['binhluan'] ?? '';

                    if (!empty($binhluan)) {
                        $productObj = new product();
                        $insert_binhluan_result = $productObj->insert_binhluan($user_id, $product_id, $user_taikhoan, $binhluan);

                        if ($insert_binhluan_result) {
                            echo "<script>alert('Đã gửi bình luận!');</script>";
                        } else {
                            echo "<script>alert('Lỗi khi gửi bình luận.');</script>";
                        }
                    } else {
                        echo "<script>alert('Vui lòng nhập nội dung bình luận!');</script>";
                    }
                }
            }
            elseif ($form_type === 'delete_comment') {
                $idbinhluan = $_POST['idbinhluan'] ?? null;

                if ($idbinhluan && $user_id) {
                    $productObj = new product();
                    $delete_result = $productObj->delete_binhluan($idbinhluan, $user_id);

                    if ($delete_result) {
                        header("Location: product.php?product_id=$product_id&comment_deleted=1");
                        exit();
                    } else {
                        echo "<script>alert('Không thể thu hồi bình luận.');</script>";
                    }
                } else {
                    echo "<script>alert('Dữ liệu không hợp lệ.');</script>";
                }
            }
        }

?>
<!-- product---------------------------------------------------------------------------------------------------->
    <section class="product">
            <div class="product-content">
                <div class="product-content-left row">
                    <div class="product-content-left-big-img">
                    <img src="<?php echo $imageSrc?>" alt="Product Image">
                    </div>
                </div>
                <div class="product-content-right">
                    <div class="product-content-right-product-name">
                        <h1><?php echo $result['product_name']; ?></h1>
                        <p>MSP: <?php echo $result['product_ma']; ?></p>
                    </div>
                    <div class="rating-display">
                        <span class="star-icon">★</span>
                        <span class="avg-score"><?php echo $avg_sao; ?> sao</span>
                        <span class="total-votes">(<?php echo $total_vote; ?> đánh giá)</span>
                    </div>
                    <div class="product-content-right-product-price">
                    <p>Giá:<?php echo number_format($result['product_price'], 0, ',', '.'); ?><sup>VNĐ</sup></p>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="form_type" value="add_to_cart">
                    <div class="product-content-right-product-size">
                        <p style="font-weight: bold;">Size:</p>
                        <div class="size">
                        <label><input type="radio" name="cart_size" value="S" required> S</label>
                        <label><input type="radio" name="cart_size" value="M"> M</label>
                        <label><input type="radio" name="cart_size" value="L"> L</label>
                        <label><input type="radio" name="cart_size" value="XL"> XL</label>
                        <label><input type="radio" name="cart_size" value="XXL"> XXL</label>
                        </div>
                    </div>
                    <div class="quantity">
                        <p style="font-weight: bold;">Số lượng:</p>
                        <input type="number" min="1" value="1" max="25" name="cart_sl" id="cart_sl">
                    </div>
                        <p style="color: red;">Vui lòng chọn size*</p>
                    <div class="product-content-right-product-sl">
                        <?php if ($result['product_soluong'] == 0): ?>
                            <h1 style="color: red;">Hàng đã hết</h1>
                        <?php else: ?>
                            <h1>Số lượng còn lại: <?php echo $result['product_soluong']; ?></h1>
                        <?php endif; ?>
                        <h1>Đã bán:<?php echo $result['product_daban']; ?></h1>
                    </div>
                    <div class="product-content-right-product-button">
                        <button type="submit"><p><i class="fa-solid fa-cart-shopping"></i> THÊM VÀO GIỎ HÀNG</p></button>
                    </div>
                    
                </form>
                    <div class="product-content-right-product-icon">
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-phone"></i><p>Hotline</p>
                        </div>
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-comments"></i><p>Chat</p>
                        </div>
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-envelope"></i><p>Mail</p>
                        </div>
                    </div>
                    <div class="product-content-right-product-QR">
                        <img src="img/QR.jpg" alt="">
                    </div>
                    <div class="product-content-right-button">
                        <div class="product-content-right-product-button-top">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                        <div class="product-content-right-button-content-big">
                            <div class="product-content-right-button-content-litle row">
                                <div class="product-content-right-button-content-litle-item chitiet">
                                    <p>Mô tả</p>
                                </div>
                                <div class="product-content-right-button-content-litle-item baoquan">
                                    <p>Bảo quản</p>
                                </div>
                            <div class="product-content-right-button-content">
                                <div class="product-content-right-button-content-chitiet">
                                    Mô tả sản phẩm:<?php echo $result ['product_desc'];?>
                                </div>
                                <div class="product-content-right-button-content-baoquan">
                                    Chi tiết bảo quản sản phẩm:
                                    để nơi khô ráo sạch sẽ
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                <!-- vote sao -->
                <form method="post" action="" id="voteForm">
                    <input type="hidden" name="form_type" value="vote">
                    <div class="vote-section">
                        <p><strong>Đánh giá sản phẩm:</strong></p>
                        <div class="stars">
                            <?php 
                            for ($i = 1; $i <= 5; $i++): 
                                $reverseValue = 6 - $i; // Đảo ngược giá trị
                            ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="sao" value="<?php echo $reverseValue; ?>" required>
                                <label for="star<?php echo $i; ?>" title="<?php echo $i; ?> sao">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>
                </form>
                <!-- bình luận -->
                 <h3 class="vietbinhluan">Viết bình luận:</h3>
                    <form method="POST" class="comment-form">
                        <input type="hidden" name="form_type" value="comment">
                        <textarea name="binhluan" rows="4" cols="60" placeholder="Nội dung bình luận..." required></textarea><br>
                        <button type="submit">Gửi bình luận</button>
                    </form>
                <!-- xem bình luận -->
                 <h3 class="xembinhluan">Bình luận sản phẩm:</h3>
                <div class="comments-container">
                    <?php
                    $productObj = new product(); // dùng tên khác
                    $ds_binhluan = $productObj->get_binhluan_by_product($product_id);
                    if ($ds_binhluan !== false && $ds_binhluan->num_rows > 0) {
                        while ($row = $ds_binhluan->fetch_assoc()) {
                            ?>
                            <div class="comment-item">
                                <strong><?php echo htmlspecialchars($row['user_taikhoan']); ?>:<small style="color: gray;float:right;"><?php echo date("d/m/Y", strtotime($row['thoigian'])); ?></small></strong>
                                <p><?php echo nl2br(htmlspecialchars($row['binhluan'])); ?></p>
                                
                                <!-- Nếu là người dùng đã đăng nhập và trùng user_id -->
                                <?php if ($user_id && $row['user_id'] == $user_id): ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="form_type" value="delete_comment">
                                        <input type="hidden" name="idbinhluan" value="<?php echo $row['idbinhluan']; ?>">
                                        <button type="submit" style="color: red; background: none; border: none; cursor: pointer;float:right;">Thu hồi</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Chưa có bình luận nào.</p>";
                    }
                    ?>
                </div>
<?php
ob_end_flush();
?>
<?php
     include "./slider_bot.php";
?>
   