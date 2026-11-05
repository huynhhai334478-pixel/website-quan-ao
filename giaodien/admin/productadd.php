<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>

<?php
    $product = new product;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {   
        $alert = $product->insert_product($_POST,$_FILES);
        if ($alert) 
        {
            echo "<script>alert('$alert');</script>";
        }
    }
?>


<div class="admin-content-right">
<div class="admin-content-right-product_add">
                <h1>Thêm Sản phẩm</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm<span style="color: orangered;">*</span></label>
                    <input name="product_name" require type="text">
                    <label for="">Nhập mã sản phẩm<span style="color: orangered;">*</span></label>
                    <input name="product_ma" require type="text">
                    <label for="">Chọn danh mục<span style="color: orangered;">*</span></label>
                    <select name="category_id" id="category_id">
                    <option value="#">--Chọn--</option>
                        <?php
                            $show_category = $product ->show_category();
                            if($show_category)
                            {
                                while($result = $show_category -> fetch_assoc())
                                {
                        ?>
                        <option value="<?php echo $result['category_id'] ?>"><?php echo $result['category_name'] ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <label for="">Chọn Loại sản phẩm<span style="color: orangered;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <option value="#">--Chọn--</option>
                        
                    </select>
                    <label for="">Giá sản phẩm<span style="color: orangered;">*</span></label>
                        <input name="product_price" require type="text">
                    <label for="">Số lượng sản phẩm<span style="color: orangered;">*</span></label>
                        <input name="product_soluong" require type="text">
                    <label for="">Mô tả sản phẩm<span style="color: orangered;">*</span></label>
                        <textarea require name="product_desc" id="" cols="30" rows="10"></textarea>
                    <label for="">Ảnh sản phẩm<span style="color: orangered;">*</span></label>
                    <span style="color: orangered;"> 
                        <?php 
                        if(isset($insert_product))
                            {
                                echo ($insert_product);
                            }
                        ?>
                     </span>
                        <input name="product_img" require type="file">
                    <button type="submit">Thêm</button>
                </form>
            </div>  
        </div>
    </section>
</body>
    <script>
    $(document).ready(function()
        {
            $("#category_id").change(function()
            {
                // alert($(this).val()) test
                var x = $(this).val()
                $.get("productadd_ajax.php",{category_id:x},function(data)
                {
                    $("#brand_id").html(data);
                });
            });
        });
    </script>
</html>