<?php
require_once 'student.php';
$email = $_GET['email'];
$population = $_GET['population'];
Student::deleteStudent($email);
header("Location: population.php?population=" . $population);