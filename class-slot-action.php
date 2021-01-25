<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('session.php');
require('database.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    var_dump($_POST);
    if ($_POST['mode'] == "new") {
        // Insert new class slot
        $ClassQuery = "INSERT INTO class_slot (crn, class_id, slot_monday, monday_period, slot_tuesday, tuesday_period, slot_wednesday, wednesday_period, slot_thursday, thursday_period, slot_friday, friday_period, slots, semester) VALUES (:crn, :classid, :sm, :mp, :st, :tp, :sw, :wp, :sr, :rp, :sf, :fp, :slots, :semester)";
    } else if ($_POST['mode'] == "edit") {
        $ClassQuery = "UPDATE class_slot SET crn = :crn,class_id = :classid,slot_monday = :sm,monday_period = :mp,slot_tuesday = :st,tuesday_period = :tp,slot_wednesday = :sw,wednesday_period=:wp,slot_thursday = :sr,thursday_period =:rp,slot_friday = :sf,friday_period = :fp,slots = :slots,semester = :semester WHERE crn=:crn";
    }
    $newClass = $db->prepare($ClassQuery);
    if (empty($_POST['crn'])) {
        $newClass->bindValue(':crn', $n = null, PDO::PARAM_NULL);
    } else {
        $newClass->bindValue(':crn', $_POST['crn']);
    }
    $newClass->bindValue(':classid', $_POST['cid']);
    $newClass->bindValue(':sm', (intval($_POST['monday']) > -1 ? 1 : 0));
    $newClass->bindValue(':mp', $_POST['monday']);
    $newClass->bindValue(':st', (intval($_POST['tuesday']) > -1 ? 1 : 0));
    $newClass->bindValue(':tp', $_POST['tuesday']);
    $newClass->bindValue(':sw', (intval($_POST['wednesday']) > -1 ? 1 : 0));
    $newClass->bindValue(':wp', $_POST['wednesday']);
    $newClass->bindValue(':sr', (intval($_POST['thursday']) > -1 ? 1 : 0));
    $newClass->bindValue(':rp', $_POST['thursday']);
    $newClass->bindValue(':sf', (intval($_POST['friday']) > -1 ? 1 : 0));
    $newClass->bindValue(':fp', $_POST['friday']);
    $newClass->bindValue(':slots', $_POST['seats']);
    $newClass->bindValue(':semester', $_POST['semester']);
    $newClass->execute();
    $newClass->closeCursor();
    header('location: admin-list-classes.php');
}

echo 'done';
