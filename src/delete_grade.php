<?php
require_once 'student.php';
$email = $_GET['email'];
$id = $_GET['id'];
Student::deleteGrade($email, $id);
header("Location: grade.php?email=" . $email);
?>