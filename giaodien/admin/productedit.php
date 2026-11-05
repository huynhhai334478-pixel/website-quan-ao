<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>

<?php
    $product = new product;
    $product_id = $_GET['product_id'];
    $get_product = $product -> get_product($product_id);
    if ($get_product) {
        $result = $get_product -> fetch_assoc();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
        $product_name = $_POST['product_name'];
        $product_ma = $_POST['product_ma'];
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_img = $_FILES['product_img']['name'];
        $alert = $product->update_product($product_name, $product_ma, $category_id, $brand_id, $product_price, $product_desc, $product_img, $product_id);
        if ($alert) 
        {
            echo "<script>alert('$alert');</script>";
        }
    }
?>

<div class="admin-content-right">
    <div class="admin-content-right-product_add">
        <h1>Chỉnh sửa Sản phẩm</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="">Nhập tên sản phẩm<span style="color: orangered;">*</span></label>
            <input name="product_name" require type="text" value="<?php echo $result['product_name']; ?>">

            <label for="">Nhập mã sản phẩm<span style="color: orangered;">*</span></label>
            <input name="product_ma" require type="text" value="<?php echo $result['product_ma']; ?>">

            <label for="">Chọn danh mục<span style="color: orangered;">*</span></label>
            <select name="category_id" id="category_id">
                <option value="#">--Chọn--</option>
                <?php
                    $show_category = $product ->show_category();
                    if($show_category)
                    {
                        while($category = $show_category -> fetch_assoc())
                        {
                            $selected = ($category['category_id'] == $result['category_id']) ? 'selected' : '';
                            echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                        }
                    }
                ?>
            </select>

            <label for="">Chọn Loại sản phẩm<span style="color: orangered;">*</span></label>
            <select name="brand_id" id="brand_id">
                <option value="#">--Chọn--</option>
                <?php
                if (isset($result['category_id'])) {
                    $category_id = $result['category_id'];
                    $brands = $product->get_brands_by_category($category_id); // Hàm này cần được định nghĩa trong lớp product

                    if ($brands) {
                        while ($brand = $brands->fetch_assoc()) {
                            $selected = ($brand['brand_id'] == $result['brand_id']) ? 'selected' : '';
                            echo "<option value='{$brand['brand_id']}' $selected>{$brand['brand_name']}</option>";
                        }
                    }
                }
            ?>
            </select>
            <label for="">Giá sản phẩm<span style="color: orangered;">*</span></label>
            <input name="product_price" require type="text" value="<?php echo $result['product_price']; ?>">
            <label for="">Mô tả sản phẩm<span style="color: orangered;">*</span></label>
            <textarea name="product_desc" required cols="30" rows="10"><?php echo $result['product_desc']; ?></textarea>
                <div>
                    <label for="product_img">Chọn ảnh sản phẩm<span style="color: orangered;">*</span></label>
                    <input name="product_img" id="product_img" type="file" required>
                    <?php if (!empty($result['product_img'])) { ?>
                        <p>Tên ảnh hiện tại: <strong><?php echo $result['product_img']; ?></strong></p>
                    <?php } ?>
                </div>
            <button type="submit">Sửa</button>
        </form>
    </div>  
</div>

<script>
    $(document).ready(function() {
    $("#category_id").change(function() {
        var category_id = $(this).val();
        
        if (category_id != "#") {
            $.get("productadd_ajax.php", { category_id: category_id }, function(data) {
                $("#brand_id").html(data); // Cập nhật options cho brand_id
            });
        } else {
            $("#brand_id").html("<option value='#'>--Chọn--</option>");
        }
    });
});

</script>
</html>
