<?php
  include('database.php');
  session_start();
  if(!isset($_SESSION['login_id'])) {
    header("location: logout.php");
    die();
  } else {
    $user_id = $_SESSION['login_id'];
    $query = 'SELECT `USERNAME` FROM `user` WHERE `STUDENT_ID` = :user_id';
    $stat1 = $db->prepare($query);
    $stat1->bindValue(':user_id', $user_id);
    $stat1->execute();
    $result = $stat1->fetch();
    $stat1->closeCursor();
    $login_name = $result['USERNAME'];
  }

?>
