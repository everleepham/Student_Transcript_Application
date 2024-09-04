<?php
require_once 'student.php';

if ($_POST['intake'] = 'F2020') {
    $intake = 'FALL';
    $year = 2020;
} else {
    $intake = 'SPRING';
    $year = 2021;
}

$population = $_POST['population'];

$student = new Student($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['contact'], $intake, $year, $population);
$student->addStudent();
header('Location: population.php?population=' . $population);
 ?>