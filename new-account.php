<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$_HEADER_TITLE = "Sign Up";
$_HEADER_NO_LOGOUT = TRUE;
include('database.php');
$error = '';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameCheckQuery = "SELECT USERNAME FROM user WHERE USERNAME = :user";
    $usernameCheck = $db->prepare($usernameCheckQuery);
    $usernameCheck->bindValue(':user', $_POST['user']);
    $usernameCheck->execute();
    $usernameCheck = $usernameCheck->fetch();
    if (isset($usernameCheck['USERNAME'])) {
        $error = 'Error: Username already exists';
    } else if ($_POST['password'] != $_POST['verify']) {
		$error = 'Error: Passwords do not match';
	} else {
        var_dump($_POST);
        $newUserQuery = "INSERT INTO user (USERNAME,PASSWORD) VALUES (:username, :password)";
        $newUser = $db->prepare($newUserQuery);
        $newUser->bindValue(':username', $_POST['user']);
        $newUser->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $newUser->execute();
        header('Location: index.php');
    }
}
?>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="site.css">
</head>
<body>
    <?php include('header.php') ?>
    <main>
        <div>
            <div>
                <table class="semesterTable">
                    <tr>
                        <td class="table-button"><a href="index.php">Back to sign in</a></td>
                    </tr>
                </table>
            </div>
            <h2>Make a new Account</h2>
            <form action="" method="post">
                <label>Username:</label>
                <input type="text" name="user" required><br><br>
                <label>Password:</label>
                <input type="password" name="password" required
				placeholder="At least 6 characters, with 1 number" 
				title="At least 6 characters, with 1 number"
				pattern="(?=.*\d).{6,}"><br><br>
                <label>Confirm Password:</label>
                <input type="password" name="verify" required><br><br>
                <input type="submit" value="Register" class="submit">
            </form>
            <br>
            <p class="error"><?php echo $error; ?></p>
        </div>
    </main>
    <footer>&copy;2020 Adrian</footer>
</body>
