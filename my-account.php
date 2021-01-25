<?php
require('session.php');
require('database.php');
$_NORMAL_PAGE = TRUE;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['semester'])) {
    $semester = $_GET['semester'];
} else {
    $semester = 'Fall';
}
if ($semester == NULL || $semester == '') {
    $semester = 'Fall';
}

$classCountQuery = 'SELECT count(*) AS `CLASS_COUNT` FROM registered INNER JOIN class_slot ON class_slot.crn = registered.CRN WHERE registered.STUDENT_ID = :userid and class_slot.semester = :semester"Fall"';
$statement2 = $db->prepare($classCountQuery);
$statement2->bindValue(':semester', $semester);
$statement2->bindValue(':userid', $user_id);
$statement2->execute();
$result = $statement2->fetch();
$classCount = $result['CLASS_COUNT'];
$statement2->closeCursor();

$queryClasses = 'SELECT * FROM registered JOIN class_slot ON class_slot.crn = registered.CRN JOIN class ON class.ID = class_slot.class_id WHERE registered.STUDENT_ID = :userid AND class_slot.semester = :semester';
$statement3 = $db->prepare($queryClasses);
$statement3->bindValue(':semester', $semester);
$statement3->bindValue(':userid', $user_id);
$statement3->execute();
$classes = $statement3->fetchAll();
$statement3->closeCursor();

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
            <div>
                <h2>Pick a semester</h2>
                <table class="semesterTable">
                    <tr>
                        <td class="table-button"><a href="?semester=Fall">Fall</a></td>
                        <td class="table-button"><a href="?semester=Spring">Spring</a></td>
                        <td class="table-button"><a href="?semester=Summer">Summer</a></td>
                    </tr>
                </table>
            </div>
                <h3><?php echo $semester; ?> Registered Classes:</h3>
                <table>
                    <tr>
                        <th>CRN</th>
                        <th>Major</th>
                        <th>Level</th>
                        <th class="right">Class Name</th>
                    </tr>
                    <?php foreach ($classes as $class) : ?>                               <!-- Specific Person -->
                        <tr>
                            <td><?php echo $class['CRN']; ?></td>
                            <td><?php echo $class['MAJOR']; ?></td>
                            <td><?php echo $class['LEVEL']; ?></td>
                            <td class="right"><?php echo $class['NAME']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
        </main>
        <footer>&copy;2020 Adrian</footer>
    </body>
</html>
