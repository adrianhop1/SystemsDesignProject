<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('session.php');
require('database.php');
if (isset($_GET['crn'])) {
    $crnQuery = "SELECT * FROM class_slot JOIN class ON class.ID = class_slot.class_id WHERE crn = :crn";
    $crn = $db->prepare($crnQuery);
    $crn->bindValue(":crn", $_GET['crn']);
    $crn->execute();
    $crn = $crn->fetch();
    $_GET['cid'] = $crn['class_id'];
}
?>
<head>
    <title>Admin Panel - New Class Slot</title>
    <link rel="stylesheet" type="text/css" href="site.css">
    <script>
     <?php if (isset($crn)) : ?>
     document.addEventListener("DOMContentLoaded", function(event) {
         <?php if($crn['slot_monday'] == "1"):?>updateDay("monday",<?=$crn['monday_period']?>);<?php endif; ?>
         <?php if($crn['slot_tuesday'] == "1"):?>updateDay("tuesday",<?=$crn['tuesday_period']?>);<?php endif; ?>
         <?php if($crn['slot_wednesday'] == "1"):?>updateDay("wednesday",<?=$crn['wednesday_period']?>);<?php endif; ?>
         <?php if($crn['slot_thursday'] == "1"):?>updateDay("thursday",<?=$crn['thursday_period']?>);<?php endif; ?>
         <?php if($crn['slot_friday'] == "1"):?>updateDay("friday",<?=$crn['friday_period']?>);<?php endif; ?>
     })
     <?php endif; ?>

     function updateDay(day, period) {
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

     function setMonday(period) { updateDay("monday", period); }
     function setTuesday(period) { updateDay("tuesday", period); }
     function setWednesday(period) { updateDay("wednesday", period); }
     function setThursday(period) { updateDay("thursday", period); }
     function setFriday(period) { updateDay("friday", period); }
    </script>
</head>
<?php
include('header.php');
?>
<main>
    <div>
        <table class="semesterTable">
            <tr>
                <td class="table-button"><a href="admin-list-classes.php">Back to classes</a></td>
            </tr>
        </table>
    </div>
    <h1><?=(isset($crn) ? "Edit CRN ".$crn['crn'] : "Create a new class slot")?></h1>
    <?php
    if (isset($_GET['cid'])) {
        $classQuery = "SELECT NAME FROM class WHERE ID=:id";
        $class = $db->prepare($classQuery);
        $class->bindValue(':id',$_GET['cid']);
        $class->execute();
        $class = $class->fetch();
    ?>
        <h2><?=$class['NAME']?></h2>
        <form class="new-class-form" action="class-slot-action.php" method="POST">
            <input type="hidden" value="<?=(isset($_GET['crn']) ? "edit" : "new")?>" name="mode">
            <input type="hidden" name="cid" value="<?=$_GET['cid']?>">
            <label>CRN (leave blank for an automatic CRN):</label><input type="text" name="crn" value="<?=(isset($crn) ? $crn['crn'] : "")?>" autocomplete="off"><br><br>
            <label># of Seats:</label><input type="text" name="seats" value="<?=(isset($crn) ? $crn['slots'] : "")?>" required autocomplete="off"><br><br>
            <label>Semester:</label>
            <select name="semester">
                <option value="Fall" <?php if(isset($crn) and $crn['semester'] == "Fall") echo 'selected="selected"'?>>Fall</option>
                <option value="Spring" <?php if(isset($crn) and $crn['semester'] == "Spring") echo "selected='selected'"?>>Spring</option>
                <option value="Summer" <?php if(isset($crn) and $crn['semester'] == "Summer") echo "selected='selected'"?>>Summer</option>
            </select><br>
            <input type="hidden" value="-1" name="monday" id="mondayInput" >
            <input type="hidden" value="-1" name="tuesday" id="tuesdayInput">
            <input type="hidden" value="-1" name="wednesday" id="wednesdayInput">
            <input type="hidden" value="-1" name="thursday" id="thursdayInput">
            <input type="hidden" value="-1" name="friday" id="fridayInput">
            <h2>Select time slots</h2>
            <div class="schedule-view-container">
                <div class="schedule-view" style="height:initial" >
                    <div class="schedule-view-day-header-container">
                        <div class="schedule-view-day-mwf">
                            <div style="text-align:center">Monday</div>
                        </div>
                    </div>
                    <div class="schedule-view-day-header-container">
                        <div class="schedule-view-day-mwf">
                            <div style="text-align:center">Tuesday</div>
                        </div>
                    </div>
                    <div class="schedule-view-day-header-container">
                        <div class="schedule-view-day-mwf">
                            <div style="text-align:center">Wednesday</div>
                        </div>
                    </div>
                    <div class="schedule-view-day-header-container">
                        <div class="schedule-view-day-mwf">
                            <div style="text-align:center">Thursday</div>
                        </div>
                    </div>
                    <div class="schedule-view-day-header-container">
                        <div class="schedule-view-day-mwf">
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
                                <div class="schedule-view-slot-container" onClick="setMonday(<?=$i?>)">
                                    <div class="schedule-view-slot" id="monday<?=$i?>">
                                        Period <?=$i?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="schedule-view-day-tr-container">
                        <div class="schedule-view-day-tr">
                            <?php
                            for ($i = 1; $i <= 10; $i++) : ?>
                                <div class="schedule-view-slot-container" onClick="setTuesday(<?=$i?>)">
                                    <div class="schedule-view-slot" id="tuesday<?=$i?>">
                                        Period <?=$i?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="schedule-view-day-mwf-container">
                        <div class="schedule-view-day-mwf">
                            <?php
                            for ($i = 1; $i <= 13; $i++) : ?>
                                <div class="schedule-view-slot-container" onClick="setWednesday(<?=$i?>)">
                                    <div class="schedule-view-slot"  id="wednesday<?=$i?>">
                                        Period <?=$i?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="schedule-view-day-tr-container">
                        <div class="schedule-view-day-tr">
                            <?php
                            for ($i = 1; $i <= 10; $i++) : ?>
                                <div class="schedule-view-slot-container" onClick="setThursday(<?=$i?>)">
                                    <div class="schedule-view-slot"  id="thursday<?=$i?>">
                                        Period <?=$i?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="schedule-view-day-mwf-container">
                        <div class="schedule-view-day-mwf">
                            <?php
                            for ($i = 1; $i <= 13; $i++) : ?>
                                <div class="schedule-view-slot-container" onClick="setFriday(<?=$i?>)">
                                    <div class="schedule-view-slot"  id="friday<?=$i?>">
                                        Period <?=$i?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
            <input style="font-size: 150%; width: 100%;margin: 0.25em 0 0 0;" type="Submit" value="<?=(!isset($crn) ? "Add class slot" : "Save Changes")?>">
        </form>
    <?php
    } else {
        echo "<h2>Error: No class selected</h2>";
    }
    ?>
</main>
<footer>&copy;2020 Adrian</footer>
