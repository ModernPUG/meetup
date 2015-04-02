<?php
include_once "vendor/autoload.php";

if (isset($_SESSION['isLogin']) && $_SESSION['isLogin']) {
    header('Location: /home.php');
} else {
    header('Location: /login.php');
}