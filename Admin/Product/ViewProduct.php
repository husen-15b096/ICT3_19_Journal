<?php
session_start();
if (!$_SESSION["islogin"]) {
    header('Location: /ShoppingCart/Admin/Login.php');
}
