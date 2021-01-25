<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addClass'])) {
        require_once("database.php");
        $major = $_POST['MAJOR'];
        $level = (int) $_POST['LEVEL'];
        $name = $_POST['NAME'];
        $query = 'INSERT INTO `class` (MAJOR, LEVEL, NAME) VALUES (:major, :level, :name);';
        $statement = $db->prepare($query);
        $statement->bindValue(':major', $major);
        $statement->bindValue(':level', $level);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $statement->closeCursor();
        header("location: admin-list-classes.php");
    } else if (isset($_POST['delClass'])) {
        require_once("database.php");
        $delQuery = 'DELETE FROM `class` WHERE `ID` = :cid';
        $statement = $db->prepare($delQuery);
        $statement->bindValue(':cid', $_POST['cid']);
        $statement->execute();
        $statement->closeCursor();
        header("location: admin-list-classes.php");
    } else if (isset($_POST['deleteSlot'])) {
        require_once("database.php");
        $deleteQuery = "DELETE FROM class_slot WHERE crn = :crn";
        $delete = $db->prepare($deleteQuery);
        $delete->bindValue(':crn', $_POST['crn']);
        $delete->execute();
        $delete->closeCursor();
        header('Location: admin-list-classes.php');
    } else if (isset($_POST['editSlot'])) {
        header('Location: new-class-slot.php?crn='.$_POST['crn']);
    }
}

?>
