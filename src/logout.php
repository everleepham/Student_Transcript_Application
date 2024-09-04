<?php
require_once 'student.php';
Student::logout();

header('location: login.php');
?> 