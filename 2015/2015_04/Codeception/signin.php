<?php
include_once "vendor/autoload.php";

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if($email && $username && $password){
    $user = User::where('email', $email)->count();

    if($user == 0) {
        $user = User::create([
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        if($user) {
            $_SESSION['isLogin'] = true;
            header('Location: /home.php');
        }
    } else {
        $_SESSION['errorMsg'] = 'duplicated';
    }
}

?>

<?php if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg']) { ?>
    <p><?php echo $_SESSION['errorMsg'];?></p>
<?php } ?>

<form action="#" method="post">
    <input type="text" name="email">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" name="sign in">
</form>