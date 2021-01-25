<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$_NORMAL_PAGE = TRUE;
require('session.php');
require('database.php');
$classesQuery = "SELECT * FROM registered JOIN class_slot ON class_slot.crn = registered.CRN JOIN class ON class.ID = class_slot.class_id WHERE STUDENT_ID = :userid and semester = :semester";
$classes = $db->prepare($classesQuery);
$classes->bindValue(':semester', $_GET['s']);
$classes->bindValue(':userid', $user_id);
$classes->execute();
$classes = $classes->fetchAll();
?>
<head>
    <title>View Schedule</title>
    <link rel="stylesheet" type="text/css" href="site.css">
    <script>
     var classes = <?=json_encode($classes)?>;
     function updateDay(day, period, color) {
         inputElement = document.getElementById(day+"Input");
         if (inputElement.value != -1) {
             element = document.getElementById(day+inputElement.value)
             element.style.borderColor = "";
             element.style.backgroundColor = "";
         }
         if (inputElement.value != period) {
             element = document.getElementById(day+period)
             inputElement.value = period;
             element.style.borderColor = "green";
             element.style.backgroundColor = "lightgreen";
         } else {
             inputElement.value = -1;
         }
         
     }
     
     document.addEventListener("DOMContentLoaded", function(event) {
         colors = ["darksalmon","steelblue","limegreen","rosybrown","darkslategray","mediumpurple"];
         classes.forEach(function(item, index) {
             if(item['slot_monday'] == "1") {
                 element = document.getElementById("monday"+item['monday_period']);
                 element.style.backgroundColor = colors[index%colors.length];
                 element.style.borderRadius = "3px";
                 element.style.color = "white";
                 element.innerHTML = element.innerHTML + item['MAJOR'] + " " + item['LEVEL'] + " ";
             }
             console.log("Monday");
             if(item['slot_tuesday'] == "1") {
                 element = document.getElementById("tuesday"+item['tuesday_period']);
                 element.style.backgroundColor = colors[index%colors.length];
                 element.style.borderRadius = "3px";
                 element.style.color = "white";
                 element.innerHTML = element.innerHTML + item['MAJOR'] + " " + item['LEVEL'] + " ";
             }
             console.log("wednesday"+item['wednesday_period']);
             if(item['slot_wednesday'] == "1") {
                 element = document.getElementById("wednesday"+item['wednesday_period']);
                 element.style.backgroundColor = colors[index%colors.length];
                 element.style.borderRadius = "3px";
                 element.style.color = "white";
                 element.innerHTML = element.innerHTML + item['MAJOR'] + " " + item['LEVEL'] + " ";
             }
             console.log("Monday");
             if(item['slot_thursday'] == "1") {
                 element = document.getElementById("thursday"+item['thursday_period']);
                 element.style.backgroundColor = colors[index%colors.length];
                 element.style.borderRadius = "3px";
                 element.style.color = "white";
                 element.innerHTML = element.innerHTML + item['MAJOR'] + " " + item['LEVEL'] + " ";
             }
             console.log("Monday");
             if(item['slot_friday'] == "1") {
                 element = document.getElementById("friday"+item['friday_period']);
                 element.style.backgroundColor = colors[index%colors.length];
                 element.style.borderRadius = "3px";
                 element.style.color = "white";
                 element.innerHTML = element.innerHTML + item['MAJOR'] + " " + item['LEVEL'] + " ";
             }
         });
     });
    </script>
</head>
<body>
    <?php include ('header.php');?>
    <main>
        <div>
            <h2>Pick a semester</h2>
            <table class="semesterTable">
                <tr>
                    <td class="table-button"><a href="?s=Fall">Fall</a></td>
                    <td class="table-button"><a href="?s=Spring">Spring</a></td>
                    <td class="table-button"><a href="?s=Summer">Summer</a></td>
                </tr>
            </table>
        </div>
        <h1 style="text-align:center"><?=$_GET['s']?> Semester</h2>
        <div class="schedule-view-container">
            <div class="schedule-view" style="height:initial" >
                <div class="schedule-view-day-header-container">
                    <div class="schedule-view-day-mwf" style="height: initial">
                        <div style="text-align:center">Monday</div>
                    </div>
                </div>
                <div class="schedule-view-day-header-container">
                    <div class="schedule-view-day-mwf" style="height: initial">
                        <div style="text-align:center">Tuesday</div>
                    </div>
                </div>
                <div class="schedule-view-day-header-container">
                    <div class="schedule-view-day-mwf" style="height: initial">
                        <div style="text-align:center">Wednesday</div>
                    </div>
                </div>
                <div class="schedule-view-day-header-container">
                    <div class="schedule-view-day-mwf" style="height: initial">
                        <div style="text-align:center">Thursday</div>
                    </div>
                </div>
                <div class="schedule-view-day-header-container">
                    <div class="schedule-view-day-mwf" style="height: initial">
                    <div style="text-align:center">Friday</div>
                </div>
            </div>
        </div>
    </div>
    <div class="schedule-view-container">
        <div class="schedule-view">
            <div class="schedule-view-day-mwf-container">
                <div class="schedule-view-day-mwf">
                    <?php
                    for ($i = 1; $i <= 13; $i++) : ?>
                        <div class="schedule-view-slot-container" style="cursor:initial">
                            <div class="schedule-view-slot" id="monday<?=$i?>">

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="schedule-view-day-tr-container">
                <div class="schedule-view-day-tr">
                    <?php
                    for ($i = 1; $i <= 10; $i++) : ?>
                        <div class="schedule-view-slot-container" style="cursor:initial">
                            <div class="schedule-view-slot" id="tuesday<?=$i?>">

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="schedule-view-day-mwf-container">
                <div class="schedule-view-day-mwf">
                    <?php
                    for ($i = 1; $i <= 13; $i++) : ?>
                        <div class="schedule-view-slot-container" style="cursor:initial">
                            <div class="schedule-view-slot"  id="wednesday<?=$i?>">

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="schedule-view-day-tr-container">
                <div class="schedule-view-day-tr">
                    <?php
                    for ($i = 1; $i <= 10; $i++) : ?>
                        <div class="schedule-view-slot-container" style="cursor:initial">
                            <div class="schedule-view-slot"  id="thursday<?=$i?>">

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="schedule-view-day-mwf-container">
                <div class="schedule-view-day-mwf">
                    <?php
                    for ($i = 1; $i <= 13; $i++) : ?>
                        <div class="schedule-view-slot-container" style="cursor:initial">
                            <div class="schedule-view-slot" id="friday<?=$i?>">

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
    </main>
    <footer>&copy;2020 Adrian</footer>
</body>
