<?php
require_once 'student.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$population = $_POST['population'];
Student::editStudent($fname, $lname, $email);
header("Location: population.php?population=" . $population);