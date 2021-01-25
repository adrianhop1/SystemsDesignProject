<?php
$_NORMAL_PAGE = TRUE;
require('session.php');
require('database.php');
$query = 'SELECT * FROM `class`';
$statement = $db->prepare($query);
$statement->execute();
$classes = $statement->fetchAll();
$query = 'SELECT class_slot.*,MAJOR,NAME,LEVEL,(slots - IFNULL(t.count,0)) AS available_slots FROM `class_slot` LEFT JOIN class ON class_slot.class_id = class.ID LEFT JOIN (SELECT count(*) AS count,registered.* FROM registered GROUP BY registered.CRN) t ON t.CRN = class_slot.crn';
$statement = $db->prepare($query);
$statement->execute();
$classSlots = $statement->fetchAll();

$statement->closeCursor();
$selectedClassesQuery = 'SELECT registered.crn,semester,class_slot.* FROM registered JOIN class_slot ON class_slot.crn=registered.CRN WHERE registered.STUDENT_ID = :studentid';
$selectedClasses = $db->prepare($selectedClassesQuery);
$selectedClasses->bindValue(':studentid', $user_id);
$selectedClasses->execute();
$selectedClasses = $selectedClasses->fetchAll();
function generateSlotText($slot) {
    $returnString = "";
    $returnString .= $slot['slot_monday'] == 1 ? "M" : " ";
    $returnString .= $slot['slot_tuesday'] == 1 ? "T" : " ";
    $returnString .= $slot['slot_wednesday'] == 1 ? "W" : " ";
    $returnString .= $slot['slot_thursday'] == 1 ? "R" : " ";
    $returnString .= $slot['slot_friday'] == 1 ? "F" : " ";
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

<!DOCTYPE html>
<html>
    <head>
        <title>Class Registration</title>
        <link rel="stylesheet" type="text/css" href="site.css">
        <script>
         window.onload = function () {
             var selected = <?=json_encode($selectedClasses)?>;
             console.log(selected);
             selected.forEach(function(item) {
                 toggleClassSelectable(item['crn'],item['class_id']);
                 if (item.semester == "Fall") {
                     if (item.slot_monday == "1") {
                         activeClassesFall[0][parseInt(item.monday_period) - 1] = true;
                     }
                     if (item.slot_tuesday == "1") {
                         activeClassesFall[1][parseInt(item.tuesday_period) - 1] = true;
                     }
                     if (item.slot_wednesday == "1") {
                         activeClassesFall[2][parseInt(item.wednesday_period) - 1] = true;
                     }
                     if (item.slot_thursday == "1") {
                         activeClassesFall[3][parseInt(item.thursday_period) - 1] = true;
                     }
                     if (item.slot_friday == "1") {
                         activeClassesFall[4][parseInt(item.friday_period) - 1] = true;
                     }
                 }
                 if (item.semester == "Spring") {
                     if (item.slot_monday == "1") {
                         activeClassesSpring[0][parseInt(item.monday_period) - 1] = true;
                     }
                     if (item.slot_tuesday == "1") {
                         activeClassesSpring[1][parseInt(item.tuesday_period) - 1] = true;
                     }
                     if (item.slot_wednesday == "1") {
                         activeClassesSpring[2][parseInt(item.wednesday_period) - 1] = true;
                     }
                     if (item.slot_thursday == "1") {
                         activeClassesSpring[3][parseInt(item.thursday_period) - 1] = true;
                     }
                     if (item.slot_friday == "1") {
                         activeClassesSpring[4][parseInt(item.friday_period) - 1] = true;
                     }
                 }
                 if (item.semester == "Summer") {
                     if (item.slot_monday == "1") {
                         activeClassesSummer[0][parseInt(item.monday_period) - 1] = true;
                     }
                     if (item.slot_tuesday == "1") {
                         activeClassesSummer[1][parseInt(item.tuesday_period) - 1] = true;
                     }
                     if (item.slot_wednesday == "1") {
                         activeClassesSummer[2][parseInt(item.wednesday_period) - 1] = true;
                     }
                     if (item.slot_thursday == "1") {
                         activeClassesSummer[3][parseInt(item.thursday_period) - 1] = true;
                     }
                     if (item.slot_friday == "1") {
                         activeClassesSummer[4][parseInt(item.friday_period) - 1] = true;
                     }
                 }
                 updateSelectablesFromPeriods();
             });
         }
         var classes = <?=json_encode($classes)?>;
         var classSlots = <?=json_encode($classSlots)?>;
         classSlots.forEach(function(item) {
             item.disabledByRegister = false;
         });
        </script>
        <script>
         function toggleUnavailableClasses() {
             hideables = document.getElementsByClassName("class-list-class hideable")
             Array.from(hideables).forEach(function(item) {
                 item.style.display = (document.getElementById("hideCheckbox").checked ? "none" : "")
             });
         }

         function getCRNItem(crn) {
             vari = null;
             classSlots.forEach(function(item) {
                 if (item.crn == crn) {
                     vari = item;
                 }
             });
             return vari;
         }
         
         function toggleClassSelectable(crn, cid) {
             shouldBeDisabled = document.getElementById(crn).checked;
             item = getCRNItem(crn);
             console.log(crn);
             if (item.semester == "Fall") {
                 if (item.slot_monday == "1") {
                     activeClassesFall[0][parseInt(item.monday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_tuesday == "1") {
                     activeClassesFall[1][parseInt(item.tuesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_wednesday == "1") {
                     activeClassesFall[2][parseInt(item.wednesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_thursday == "1") {
                     activeClassesFall[3][parseInt(item.thursday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_friday == "1") {
                     activeClassesFall[4][parseInt(item.friday_period) - 1] = shouldBeDisabled;
                 }
             }
             if (item.semester == "Spring") {
                 if (item.slot_monday == "1") {
                     activeClassesSpring[0][parseInt(item.monday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_tuesday == "1") {
                     activeClassesSpring[1][parseInt(item.tuesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_wednesday == "1") {
                     activeClassesSpring[2][parseInt(item.wednesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_thursday == "1") {
                     activeClassesSpring[3][parseInt(item.thursday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_friday == "1") {
                     activeClassesSpring[4][parseInt(item.friday_period) - 1] = shouldBeDisabled;
                 }
             }
             if (item.semester == "Summer") {
                 if (item.slot_monday == "1") {
                     activeClassesSummer[0][parseInt(item.monday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_tuesday == "1") {
                     activeClassesSummer[1][parseInt(item.tuesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_wednesday == "1") {
                     activeClassesSummer[2][parseInt(item.wednesday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_thursday == "1") {
                     activeClassesSummer[3][parseInt(item.thursday_period) - 1] = shouldBeDisabled;
                 }
                 if (item.slot_friday == "1") {
                     activeClassesSummer[4][parseInt(item.friday_period) - 1] = shouldBeDisabled;
                 }
             }
             Array.from(document.getElementsByClassName("cid"+cid)).forEach(function(item) {
                 if (item.id != crn) {
                     item.disabled = shouldBeDisabled;
                     classSlots.forEach(function(item2) {
                         if (item2.crn == item.id) {
                             item2.disabledByRegister = shouldBeDisabled;
                         }
                     });
                 }
             });
			 if (item.available_slots == 0 && !document.getElementById(item.crn).checked) {
				 document.getElementById(item.crn).disabled = true;
			 }
             updateSelectablesFromPeriods();
         }
         // Holds what if a period has been registered for
         activeClassesFall = [Array(13),Array(10),Array(13),Array(10),Array(13)];
         activeClassesSpring = [Array(13),Array(10),Array(13),Array(10),Array(13)];
         activeClassesSummer = [Array(13),Array(10),Array(13),Array(10),Array(13)];
         function updateSelectablesFromPeriods() {
             classSlots.forEach(function(item) {
                 overlapFound = false;
                 if (item['semester'] == "Fall") {
                     activeClassesFall[0].forEach(function(item2, index) {
                         if (item['slot_monday'] && item['monday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesFall[1].forEach(function(item2, index) {
                         if (item['slot_tuesday'] && item['tuesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesFall[2].forEach(function(item2, index) {
                         if (item['slot_wednesday'] && item['wednesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesFall[3].forEach(function(item2, index) {
                         if (item['slot_thursday'] && item['thursday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesFall[4].forEach(function(item2, index) {
                         if (item['slot_friday'] && item['friday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                 }
                 if (item['semester'] == "Spring") {
                     activeClassesSpring[0].forEach(function(item2, index) {
                         if (item['slot_monday'] && item['monday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSpring[1].forEach(function(item2, index) {
                         if (item['slot_tuesday'] && item['tuesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSpring[2].forEach(function(item2, index) {
                         if (item['slot_wednesday'] && item['wednesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSpring[3].forEach(function(item2, index) {
                         if (item['slot_thursday'] && item['thursday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSpring[4].forEach(function(item2, index) {
                         if (item['slot_friday'] && item['friday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                 }
                 if (item['semester'] == "Summer") {
                     activeClassesSummer[0].forEach(function(item2, index) {
                         if (item['slot_monday'] && item['monday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSummer[1].forEach(function(item2, index) {
                         if (item['slot_tuesday'] && item['tuesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSummer[2].forEach(function(item2, index) {
                         if (item['slot_wednesday'] && item['wednesday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSummer[3].forEach(function(item2, index) {
                         if (item['slot_thursday'] && item['thursday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                     activeClassesSummer[4].forEach(function(item2, index) {
                         if (item['slot_friday'] && item['friday_period'] == String(index + 1) && item2) {
                             overlapFound = true;
                         }
                     });
                 }
                 if (!item.disabledByRegister && !document.getElementById(item.crn).checked) {
                     document.getElementById(item.crn).disabled = overlapFound;
                 }
                 
             });
         }
         document.addEventListener("DOMContentLoaded", function(event) {
             toggleUnavailableClasses();
         });
        </script>
    </head>
    <body>
        <?php include('header.php') ?>
        <main>
            <h1>All Classes</h1>
            <label style="float:none">Hide unavailable classes:</label><input type="checkbox" onchange="toggleUnavailableClasses()" id="hideCheckbox" checked>
            <br>
            <input id="search" type="text" oninput="searchClasses()" placeholder="Search">
            <form action="confirmation.php" method="POST">
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
                                </div>
                                <table class="class-list-table">
                                    <thead>
                                        <tr>
                                            <th>CRN</th>
                                            <th>Days</th>
                                            <th>Periods</th>
                                            <th>Class Slots</th>
                                            <th class="right">Selected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        //$classSlotQuery = 'SELECT * FROM class_slot LEFT JOIN (SELECT CRN,STUDENT_ID,COUNT(CRN) AS count FROM registered GROUP BY CRN) registered_count ON registered_count.CRN = class_slot.crn WHERE class_id=:classid AND semester=:semester AND (STUDENT_ID IS NULL OR STUDENT_ID = :studentid)';
                                        $classSlotQuery = 'SELECT * FROM class_slot LEFT JOIN (SELECT CRN,STUDENT_ID,COUNT(CRN) AS count,SUM(STUDENT_ID = :studentid) AS registered_for FROM registered GROUP BY CRN) registered_count ON registered_count.CRN = class_slot.crn WHERE class_id=:classid AND semester=:semester';
                                        $classSlots = $db->prepare($classSlotQuery);
                                        $classSlots->bindValue(':classid', $class['ID']);
                                        $classSlots->bindValue(':semester', $semester['semester']);
                                        $classSlots->bindValue(':studentid', $user_id);
                                        $classSlots->execute();
                                        $classSlots = $classSlots->fetchAll();
                                        foreach ($classSlots as $slot) : ?>
                                            <tr id="crnRow<?= $slot['crn'] ?>">
                                                <td><?=$slot['crn']?></td>
                                                <td><?=generateSlotText($slot)?></td>
                                                <td><?=generatePeriodText($slot)?></td>
                                                <td><?=(intval($slot['slots'])-intval($slot['count']))?>/<?=$slot['slots']?></td>
                                                <td class="right"><input type="checkbox" name="crn[]" class="cid<?=$class['ID']?>" id="<?=$slot['crn']?>" value="<?=$slot['crn']?>" onchange="toggleClassSelectable(<?=$slot['crn']?>,'<?=$class['ID']?>')" <?=($slot['registered_for'] != 0 ? "checked" : "")?>></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Save Classes" name="submit">
            </form>
        </main>
        <footer>&copy;2020 Skyler, Jackson, Jay, Ryan</footer>
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
    </body>
</html>
