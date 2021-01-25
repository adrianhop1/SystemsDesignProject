<?php
  $host = 'mysql:host=localhost;dbname=classdata';
  $user = 'root';
  $passwd = '';
  try {
    $db = new PDO($host,$user, $passwd);
  } catch (PDOException $e) {
    echo 'Database connection failed.';
    die();
  }
?>
