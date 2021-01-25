<?php
  require('session.php');
  require('database.php');

  //
  $deleteQuery = 'SELECT * FROM `class` WHERE NOT EXISTS (SELECT * FROM registered WHERE class.CRN = registered.CRN)';
  $statement2 = $db->prepare($deleteQuery);
  $statement2->execute();
  $nonRegClasses = $statement2->fetchAll();
  $statement2->closeCursor();
  //
  $queryClasses = 'SELECT * FROM class';
  $statement3 = $db->prepare($queryClasses);
  $statement3->execute();
  $classes = $statement3->fetchAll();
  $statement3->closeCursor();

?>

<html>
  <head>
    <title>Admin Panel</title>
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
    <main class="special">
      <aside>
        <h3>Admin Panel</h3>
        <form action="" method="POST">
          <input class="tableSbm" type="submit" id="makeClass" name="makeClass" value="Create Class">
        </form>
        <br>
        <form action="" method="POST">
          <input class="tableSbm" type="submit" id="deleteClass" name="deleteClass" value="Delete Class">
        </form>
        <br>
        <form action="" method="POST">
          <input class="tableSbm" type="submit" id="listClass" name="listClass" value="List Classes">
        </form>
      </aside>
      <section>
        <?php if (isset($_POST['makeClass'])) : ?>
          <h3>Create a class:</h3>
          <form id="addForm" action="admin-action.php" method="POST">
              <label>Semester:</label>
              <input type="text" name="SEMESTER"><span> (ex. FALL)</span><br>
              <label>Major:</label>
              <input type="text" name="MAJOR"><span> (ex. CSCI)</span><br>
              <label>Level:</label>
              <input type="text" name="LEVEL"><span> (ex. 1301)</span><br>
              <label>Name:</label>
              <input type="text" name="NAME"><span> (ex. Computer Science)</span><br>
              <label>&nbsp;</label>
              <input class="tableSbm" type="submit" value="Add Class" name="addClass"><br>
          </form>
        <?php elseif (isset($_POST['listClass'])) : ?>
          <h3>All Classes:</h3>
          <table>
            <tr>
              <th>CRN</th>
              <th>Semester</th>
              <th>Major</th>
              <th>Level</th>
              <th class="right">Class Name</th>
            </tr>
            <?php foreach ($classes as $class) : ?>
              <tr>
                <td><?php echo $class['CRN']; ?></td>
                <td><?php echo $class['SEMESTER']; ?></td>
                <td><?php echo $class['MAJOR']; ?></td>
                <td><?php echo $class['LEVEL']; ?></td>
                <td class="right"><?php echo $class['NAME']; ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
        <?php elseif (isset($_POST['deleteClass'])) : ?>
          <h3>Delete class(es):</h3>
          <form action="admin-action.php" method="POST">
            <table>
              <tr>
                <th>CRN</th>
                <th>Semester</th>
                <th>Major</th>
                <th>Level</th>
                <th class="right">Class Name</th>
                <th></th>
              </tr>
              <?php foreach ($nonRegClasses as $class) : ?>
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
            <input class="tableSbm" type="submit" value="Drop" name="delClass">
          </form>
        <?php else : ?>
          <p>Please select a button on the left</p>
        <?php endif; ?>
      </section>
    </main>
    <footer>&copy;2020 Adrian</footer>
  </body>
</html>
