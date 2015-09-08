<?php
include_once "vendor/autoload.php";

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if($username == 'lhs' && $password = '123') {
    $_SESSION['isLogin'] = true;
    header('Location: /home.php');
}
?>
<form action="#" method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" name="login">
</form>
<a href="/signin.php">sign in</a>