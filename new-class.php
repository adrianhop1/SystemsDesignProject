<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('session.php');
require('database.php');
?>
<head>
    <title>Admin Panel - New Class</title>
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
<body>
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
        <h2>Create a class:</h2>
        <form id="addForm" action="admin-action.php" method="POST">
            <label>Major:</label>
            <input type="text" name="MAJOR" required autocomplete="off"><span> (ex. CSCI)</span><br>
            <label>Level:</label>
            <input type="text" name="LEVEL" required autocomplete="off"><span> (ex. 1301)</span><br>
            <label>Name:</label>
            <input type="text" name="NAME" required autocomplete="off"><span> (ex. Computer Science)</span><br>
            <label>&nbsp;</label>
            <input class="tableSbm" type="submit" value="Add Class" name="addClass" style="width: 22em;height: 2em;"><br>
        </form>
    </main>
    <footer>&copy;2020 Adrian</footer>
</body>
