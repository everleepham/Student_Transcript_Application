<?php
require_once 'student.php';
require_once 'course.php';
$population = $_GET['population'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Populations</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script type="text/javascript">
        function confirmDelete() {
            return confirm("Are you sure you want to delete this student?");
        }
    </script>

</head>


<body>
    <div id="wrapper">
        <div id="header">
        <div class="header-content">
                <p><a href="welcome.php" class="custom">Welcome</a></p> 
                
                <div class="dropdown">
                    - <button class="link">Population</button> - 
                    <div class="content">
                        <a href="population.php?population=AIs">Artificial Inteligences - AIs</a>
                        <a href="population.php?population=CS">Cyber Security - CS</a>
                        <a href="population.php?population=ISM">Information System Management - ISM</a>
                        <a href="population.php?population=DSA">Data Science - DSA</a>
                        <a href="population.php?population=SE">Software Engineer - SE</a>
                    </div>
                </div>
                
                <p> <b><?php echo $population ?></b></p>

                <div class='logout'>
                    <span class="material-symbols-outlined">logout</span>
                    <a href="logout.php" class="custom">Logout</a>
                </div>
        </div>

            <br>
            <div id="students">
            <div class="search-container">
                <h2><b>Students</b></h2> 
                <form class="search-bar" action="search_student.php">
                    <div class="search">
                    <span class="search-icon material-symbols-outlined">search</span>
                    <input class='search-input' type="search" name="search" placeholder='Search student with last name'> 
                    </div>
                </form>
            </div>
              
            <div class="add-student">
            <span class="material-symbols-outlined">add</span>
                <a href="add_student.php?population=<?php echo $population ?>" class="custom">Add students</a>
            </div>

                <p id="sub_title"><u>Fall intake - F2020</u></p>
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Full Name</th>
                            <th>Passed</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        $students = Student::getStudents($population, 2020);
                        foreach ($students as $stu) {
                            echo '<tr>';

                            echo '<td>';
                            echo '<a href="grade.php?email=' . $stu['student_epita_email'] . '" class="custom_link">' . $stu['student_epita_email'] . '</a>';
                            echo '</td>';

                            echo '<td>' . $stu['contact_first_name'] . '</td>';
                            echo '<td>' . $stu['contact_last_name'] . '</td>';
                            echo '<td>' . $stu['full_name'] . '</td>';
                            echo '<td>' . ($stu['passed'] ?? '<span class="null-value">NULL</span>'). '</td>';

                            echo '<td>';
                            echo '<a href="edit_student.php?email=' . $stu['student_epita_email'] . '" class="custom"><span class="material-symbols-outlined">edit</span></a>';
                            echo '</td>';

                            echo '<td>';
                            echo '<a href="delete_student.php?email=' . $stu['student_epita_email'] . '&population=' . $population . '" class="custom" onclick="return confirmDelete(\'' . htmlspecialchars($stu['student_epita_email']) . '\')"><span class="material-symbols-outlined">
                            delete
                            </span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>



                <br>
                <p id="sub_title"><u>Spring intake - S2021</u></p>
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Full Name</th>
                            <th>Passed</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $students = Student::getStudents($population, 2021);
                        foreach ($students as $stu) {
                            echo '<tr>';
                            echo '<td>';
                            echo '<a href="grade.php?email=' . $stu['student_epita_email'] . '" class="custom_link">' . $stu['student_epita_email'] . '</a>';
                            echo '</td>';

                            echo '<td>' . $stu['contact_first_name'] . '</td>';
                            echo '<td>' . $stu['contact_last_name'] . '</td>';
                            echo '<td>' . $stu['full_name'] . '</td>';
                            echo '<td>' . ($stu['passed'] ?? '<span class="null-value">NULL</span>'). '</td>';

                            echo '<td>';
                            echo '<a href="edit_student.php?email=' . $stu['student_epita_email'] . '" class="custom"><span class="material-symbols-outlined">edit</span></a>';
                            echo '</td>';

                            echo '<td>';
                            echo '<a href="delete_student.php?email=' . $stu['student_epita_email'] . '&population=' . $population . '" class="custom" onclick="return confirmDelete(\'' . htmlspecialchars($stu['student_epita_email']) . '\')"><span class="material-symbols-outlined">
                            delete
                            </span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <br>

                <div id="courses">
                    <div class="search-container">
                    <h2><b>Courses</b></h2> 
                    <form class="search-bar" action="search_course.php">
                        <div class="search">
                        <span class="search-icon material-symbols-outlined">search</span>
                        <input class='search-input' type="search" name="search" placeholder='Search course'> 
                        </div>
                    </form>
                </div>
                    <div class="add-student">
                        <span class="material-symbols-outlined">add</span>
                        <a href="add_course.php?population=<?php echo $population ?>" class="custom">Add course</a>
                    </div>
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Teacher</th>
                                <th>Session count</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $courses = Course::getCourse($population);
                        foreach ($courses as $cour) {
                            echo '<tr>';
                            echo '<td>' . $cour['course_code'] . '</td>';
                            echo '<td>' . $cour['course_name'] . '</td>';
                            echo '<td>' . ($cour['teacher'] ?? '<span class="null-value">NULL</span>'). '</td>';
                            echo '<td>' . ($cour['session count'] == 1 ? '<span class="null-value">NULL</span>' : $cour['session count']) . '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
<br>
            </div>

</body>

</html>