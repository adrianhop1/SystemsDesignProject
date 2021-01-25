<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$_HEADER_TITLE = "Class Registration";
$_HEADER_NO_LOGOUT = TRUE;
include('database.php');
session_start();
$_HEADER_TITLE = "Class Registration Sign In";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['username'], $_POST['password'])) {
   $error = 'Please fill both the username and password fields!';
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $userName = $_POST['username'];
    $pass = $_POST['password'];

    $query = 'SELECT STUDENT_ID,PASSWORD FROM `user` WHERE `USERNAME` = :user';
    $stat1 = $db->prepare($query);
    $stat1->bindValue(':user', $userName);
    $stat1->execute();
    $user = $stat1->fetch();
    if (password_verify($pass, $user['PASSWORD']) && $userName != 'admin') {
        $acct_id = $user['STUDENT_ID'];
        $_SESSION['login_id'] = $acct_id;
        header("location: my-account.php");
    } else if (password_verify($pass, $user['PASSWORD']) && $userName == 'admin') {
        $acct_id = $user['STUDENT_ID'];
        $_SESSION['login_id'] = $acct_id;
        header("location: admin-list-classes.php");
    } else {
        $error = 'Incorrect Login Info!';
    }
    $stat1->closeCursor();
} else {
    $error = "";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Class Registration - Sign In</title>
        <link rel="stylesheet" type="text/css" href="site.css">
    </head>
    <body>
        <?php include('header.php') ?>
        <main>
            <div>
                <h2>Login</h2>
                <form action="" method="post">
                    <label>Username:</label>
                    <input type="text" name="username" required><br><br>
                    <label>Password:</label>
                    <input type="password" name="password" required><br><br>
                    <input type="submit" value="Login" class="submit">
                </form>
                <br>
                <label>&nbsp;</label><a href="new-account.php">Make a new account</a>
                <p><?php echo $error; ?></p>
            </div>
        </main>
        <footer>&copy;2020 Adrian</footer>
    </body>
</html>
