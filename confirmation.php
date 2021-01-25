<?php
require('session.php');
require('database.php');
$_NORMAL_PAGE = TRUE;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!empty($_POST['drop_classes'])) {
        foreach ($_POST['drop_classes'] as $selected) {
            $query = 'DELETE FROM `registered` WHERE `CRN` = :crn AND `STUDENT_ID` = :studentid;';
            $stat = $db->prepare($query);
            $stat->bindValue(':crn', $selected);
            $stat->bindValue(':studentid', $user_id);
            $stat->execute();
            $stat->closeCursor();
        }
    } else if (!empty($_POST['crn'])) {
        // We delete all entries to simplify the update process because there is no primary key for the registered table!
        $query = 'DELETE FROM `registered` WHERE `STUDENT_ID` = :studentid;';
        $stat = $db->prepare($query);
        $stat->bindValue(':studentid', $user_id);
        $stat->execute();
        $stat->closeCursor();
        foreach ($_POST['crn'] as $selected) {
            $query = 'INSERT INTO `registered` (CRN, STUDENT_ID) VALUES (:crn, :studentid);';
            $stat = $db->prepare($query);
            $stat->bindValue(':crn', $selected);
            $stat->bindValue(':studentid', $user_id);
            $stat->execute();
            $stat->closeCursor();
        }
    }
} else {
    $error = "No values were selected!";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Class Registration</title>
        <link rel="stylesheet" type="text/css" href="site.css">
    </head>
    <body>
        <?php include('header.php') ?>
        <main>
            <?php if (isset($error)) { echo $error; } else {echo
                '<p>Successfully added/dropped the classes</p>';} ?><br>
            <a href="my-account.php">My account</a>
        </main>
        <footer>&copy;2020 Adrian</footer>
    </body>
</html>
