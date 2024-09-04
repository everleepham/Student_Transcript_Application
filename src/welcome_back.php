<?php
// session_start();
require_once 'connection.php';
function getOverall() {
    $query = "SELECT s.student_population_code_ref, count(s.student_epita_email) FROM students s group by s.student_population_code_ref";
    $con = Connection::getConnection();
    $stmt = $con->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAttendance() {
    $query = "SELECT s.student_population_code_ref,round(sum(a.attendance_presence) / count(*) * 100) 
            AS percentage FROM attendance a 
            JOIN students s 
            ON a.attendance_student_ref = s.student_epita_email 
            GROUP BY s.student_population_code_ref ";

    $con = Connection::getConnection();
    $stmt = $con->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}



?>