<?php
    include "header.php";
    include "slider.php";
    include "class/user_class.php";
?>
<?php
    $user = new user;
    $show_user = $user ->show_user();
?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách tài khoản</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>Tài khoản</th>
                        <th>Mật khẩu</th>
                        <th>SĐT</th>
                        <th>Quyền</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if($show_user)
                    {
                        $i=0;
                        while($result = $show_user->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['user_id']?></td>
                        <td><?php echo $result['user_taikhoan']?></td>
                        <td><?php echo $result['user_matkhau']?></td>
                        <td><?php echo $result['user_sdt']?></td>
                        <td>
                            <?php
                            echo $result['user_quyen']
                            ?>
                        </td>
                        <td><a href="useredit.php?user_id=<?php echo $result['user_id']?>"><i class="fa-solid fa-wrench"></i></a>|<a href="userdelete.php?user_id=<?php echo $result['user_id']?>"><i class="fa-solid fa-delete-left"></i></a></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
</body>
</html>