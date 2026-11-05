<?php
    include "class/user_class.php";
    $user = new user;
    $user_id = $_GET['user_id'];
    $delete_user = $user -> delete_user($user_id);
?>
