<?php
require_once 'student.php';
require_once 'course.php';
$email = $_GET['email'];
$grades = Student::getGrades($email);
$full_name = $grades[0]['fullname'];
$population = $grades[0]['student_population_code_ref'];

if ($grades[0]['student_population_period_ref'] == 'FALL') {
    $intake = 'F2020';
} else {
    $intake = 'S2021';
}

$isEmpty = (count($grades) <= 1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script type="text/javascript">
        function confirmDelete() {
            return confirm("Are you sure you want to delete grade of this course?");
        }
    </script>
</head>


<body>
    <div id="wrapper">
        <div id="header">
            <div class="header-content">
            
            <p><a href="welcome.php" class="custom">Welcome</a>  - Grades</p> 
            
            <div class="dropdown">
                - <button class="link"><b><?php echo $population ?> <?php echo $intake ?></b></button> - 
                <div class="content">
                    <a href="population.php?population=AIs">Artificial Inteligences - AIs</a>
                    <a href="population.php?population=CS">Cyber Security - CS</a>
                    <a href="population.php?population=ISM">Information System Management - ISM</a>
                    <a href="population.php?population=DSA">Data Science - DSA</a>
                    <a href="population.php?population=SE">Software Engineer - SE</a>
                </div> 
            </div>

                <p><?php echo $full_name ?></p> 

            <div class='logout'>
                <span class="material-symbols-outlined">logout</span>
                <a href="logout.php" class="custom">Logout</a>
            </div>
        
        </div>

        <br>

        <div id="grades">
            <p><b>Student final grades per course</b></p>


        <?php
        if ($isEmpty) {
            echo "<p>Grades unavailable for this student</p>";
        } else {
            
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Course</th>
                        <th>Grade (/20)</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($grades as $gra) {
                            echo '<tr>';
                                                        
                            echo '<td>' . $email . '</td>';
                            echo '<td>' . $gra['contact_first_name'] . '</td>';
                            echo '<td>' . $gra['contact_last_name'] . '</td>';
                            echo '<td>' . $gra['grade_course_code_ref'] . '</td>';
                            echo '<td>' . ($gra['grade'] ?? '<span class="null-value">NULL</span>'). '</td>';

                            echo '<td>';
                            echo '<a href="delete_grade.php?email=' . $gra['student_epita_email'] . '&id=' . $gra['grade_course_code_ref'] . '" class="custom" onclick="return confirmDelete(\'' . htmlspecialchars($gra['student_epita_email']) . '\')"><span class="material-symbols-outlined">
                            delete
                            </span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
            <br>
            
    
    </div>
    
</body>
    
</html>