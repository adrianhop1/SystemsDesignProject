<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('session.php');
require('database.php');

$query = 'SELECT * FROM `class`';
$statement = $db->prepare($query);
$statement->execute();
$classes = $statement->fetchAll();
$query = 'SELECT crn,slots,semester,MAJOR,NAME,LEVEL FROM `class_slot` LEFT JOIN class ON class_slot.class_id = class.ID';
$statement = $db->prepare($query);
$statement->execute();
$classSlots = $statement->fetchAll();

$statement->closeCursor();

function generateSlotText($slot) {
    $returnString = "";
    $returnString .= $slot['slot_monday'] == 1 ? "M" : "&nbsp;";
    $returnString .= $slot['slot_tuesday'] == 1 ? "T" : "&nbsp;";
    $returnString .= $slot['slot_wednesday'] == 1 ? "W" : "&nbsp;";
    $returnString .= $slot['slot_thursday'] == 1 ? "R" : "&nbsp;";
    $returnString .= $slot['slot_friday'] == 1 ? "F" : "&nbsp;";
    return $returnString;
}
function generatePeriodText($slot) {
    $returnString = "";
    $returnString .= $slot['slot_monday'] == 1 ? $slot['monday_period']." " : "";
    $returnString .= $slot['slot_tuesday'] == 1 ? $slot['tuesday_period']." " : "";
    $returnString .= $slot['slot_wednesday'] == 1 ? $slot['wednesday_period']." " : "";
    $returnString .= $slot['slot_thursday'] == 1 ? $slot['thursday_period']." " : "";
    $returnString .= $slot['slot_friday'] == 1 ? $slot['friday_period']." " : "";
    return $returnString;
}

?>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="site.css">
    <script>
     function toggleUnavailableClasses() {
         hideables = document.getElementsByClassName("class-list-class hideable")
         Array.from(hideables).forEach(function(item) {
             item.style.display = (document.getElementById("hideCheckbox").checked ? "none" : "")
         });
     }
     document.addEventListener("DOMContentLoaded", function(event) {
         toggleUnavailableClasses();
     });
     var classes = <?=json_encode($classes)?>;
     var classSlots = <?=json_encode($classSlots)?>;
    </script>
</head>
<?php
include('header.php');
?>
<main>
    <h1>All Classes</h1>
    <label style="float:none">Hide unavailable classes:</label><input type="checkbox" onchange="toggleUnavailableClasses()" id="hideCheckbox" checked>
    <br>
    <input id="search" type="text" oninput="searchClasses()" placeholder="Search">
    <div>
        <table class="semesterTable">
            <tr>
                <td class="table-button"><a href="new-class.php">Create new Class</a></td>
            </tr>
        </table>
    </div>
    <?php 
    $semesterClassQuery = 'SELECT DISTINCT semester FROM class_slot';
    $semesterClass = $db->prepare($semesterClassQuery);
    $semesterClass->execute();
    $semesterClass = $semesterClass->fetchAll();
    foreach ($semesterClass as $semester) :?>
        <div class="class-list-semester">
            <h2><?=$semester['semester']?></h2>
            <?php 
            $fallClassQuery = 'SELECT class.*,COUNT(cslot.crn) AS count FROM `class` LEFT JOIN (SELECT * FROM class_slot WHERE semester = :semester) cslot ON cslot.class_id = class.ID GROUP BY class.ID ORDER BY MAJOR,LEVEL ';
            $fallClasses = $db->prepare($fallClassQuery);
            $fallClasses->bindValue(':semester', $semester['semester']);
            $fallClasses->execute();
            $fallClasses = $fallClasses->fetchAll();
            foreach ($fallClasses as $class) : ?>
                <div class="class-list-class <?=(intval($class['count']) == 0 ? "hideable" : "")?>" id="classRow<?=$class['ID'].$semester['semester'] ?>">
                    <div>
                        <h3 style="float:left"><?=$class['MAJOR']?> <?=$class['LEVEL']?>: <?=$class['NAME']?></h3>
                        <form style="float:right;margin:0" action="new-class-slot.php">
                            <input type="hidden" value="<?=$class['ID']?>" name="cid">
                            <input type="submit" value="Add new class slot">
                        </form>
                        <form style="float:right;margin:0" action="admin-action.php" method="POST">
                            <input type="hidden" value="<?=$class['ID']?>" name="cid">
                            <input onclick="return confirm('Are you sure you want to delete this class? This will delete all CRNs associated with it and deregister students.')" type="submit" value="Delete Class" name="delClass">
                        </form>
                    </div>
                    <table class="class-list-table">
                        <thead>
                            <tr>
                                <th>CRN</th>
                                <th>Days</th>
                                <th>Period</th>
                                <th>Class Slots</th>
                                <th class="right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $classSlotQuery = 'SELECT * FROM class_slot LEFT JOIN (SELECT CRN,COUNT(CRN) AS count FROM registered GROUP BY CRN) registered_count ON registered_count.CRN = class_slot.crn WHERE class_id=:classid AND semester=:semester';
                            $classSlots = $db->prepare($classSlotQuery);
                            $classSlots->bindValue(':classid', $class['ID']);
                            $classSlots->bindValue(':semester', $semester['semester']);
                            $classSlots->execute();
                            $classSlots = $classSlots->fetchAll();
                            foreach ($classSlots as $slot) : ?>
                                <tr id="crnRow<?= $slot['crn'] ?>">
                                    <td><?=$slot['crn']?></td>
                                    <td><?=generateSlotText($slot)?></td>
                                    <td><?=generatePeriodText($slot)?></td>
                                    <td><?=(intval($slot['slots'])-intval($slot['count']))?>/<?=$slot['slots']?></td>
                                    <td class="right">
                                        <form action="admin-action.php" method="POST">
                                            <input type="hidden" value="<?=$slot['crn']?>" name="crn">
                                            <input class="action-button" type="submit" value="Edit" name="editSlot">
                                            <input onclick="return confirm('Are you sure you want to delete this CRN? This will deregister students from this course.')" class="action-button" type="submit" value="Delete" name="deleteSlot">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</main>
<footer>&copy;2020 Adrian</footer>
<script>
 function searchClasses() {
     var searchTerm = document.getElementById("search").value;
     var semesters = ["Fall", "Spring", "Summer"];
     semesters.forEach(function (semester) {
         classes.forEach(function (item) {
             var isFound = false;
             Object.values(item).forEach(function(entry) {
                 if (entry.toLowerCase().includes(searchTerm.toLowerCase())) {
                     isFound = true;
                 }
             });
             document.getElementById("classRow"+item[1]+semester).hidden = !isFound;
         });
     });
     classSlots.forEach(function (item) {
         var isFound = false;
         Object.values(item).forEach(function(entry) {
             if (entry.toLowerCase().includes(searchTerm.toLowerCase())) {
                 isFound = true;
             }
         });
         document.getElementById("crnRow"+item[0]).hidden = !isFound;
     });
 }
</script>
