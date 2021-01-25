<?php
//SELECT * FROM `class` WHERE NOT EXISTS (SELECT * FROM registered WHERE class.CRN = registered.CRN AND registered.STUDENT_ID = :studentid)  --For add class
//SELECT * FROM `class` INNER JOIN `registered` ON class.CRN = registered.CRN WHERE registered.STUDENT_ID = :studentid
require('session.php');
require('database.php');
$query = 'SELECT * FROM `class` INNER JOIN `registered` ON class.CRN = registered.CRN WHERE registered.STUDENT_ID = :studentid';
$statement = $db->prepare($query);
$statement->bindValue(':studentid', $user_id);
$statement->execute();
$classes = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Class Registration</title>
    <link rel="stylesheet" type="text/css" href="site.css">
    <script>
      window.onload = function () {
        var logoutbtn = document.getElementById("logout");
        logoutbtn.onclick = function () {
          window.open("logout.php", "_self");
        }
      }
    </script>
  </head>
  <body>
    <header>
      <h2>Welcome <?php echo $login_name; ?></h2>
      <button class="logoutLab" id="logout" name="logout">Logout</button>
    </header>
    <main class="singular">
      <a href="my-account.php"> &lt;- My account</a>
        <h3>Drop class(es):</h3>
        <form action="confirmation.php" method="POST">
          <table>
            <tr>
              <th>CRN</th>
              <th>Semester</th>
              <th>Major</th>
              <th>Level</th>
              <th class="right">Class Name</th>
              <th></th>
            </tr>
            <?php foreach ($classes as $class) : ?>                               <!-- Specific Person -->
              <tr>
                  <td><?php echo $class['CRN']; ?></td>
                  <td><?php echo $class['SEMESTER']; ?></td>
                  <td><?php echo $class['MAJOR']; ?></td>
                  <td><?php echo $class['LEVEL']; ?></td>
                  <td class="right"><?php echo $class['NAME']; ?></td>
                  <td><input type="checkbox" name="drop_classes[]" value=<?php echo $class['CRN']; ?>></td>
              </tr>
            <?php endforeach; ?>
          </table>
          <input class="tableSbm" type="submit" value="Drop" name="submit">
        </form>
    </main>
    <footer>&copy;2020 Adrian</footer>
  </body>
</html>
