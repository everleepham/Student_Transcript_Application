<?php
require_once 'student.php';
require_once 'course.php';
$search = $_GET['search'];


$courses = Course::searchCourse($search);
$isEmpty = (count($courses) == 0);
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
                - <button class="link">Population</button>
                <div class="content">
                    <a href="population.php?population=AIs">Artificial Inteligences - AIs</a>
                    <a href="population.php?population=CS">Cyber Security - CS</a>
                    <a href="population.php?population=ISM">Information System Management - ISM</a>
                    <a href="population.php?population=DSA">Data Science - DSA</a>
                    <a href="population.php?population=SE">Software Engineer - SE</a>
                </div>
            </div>
            
            <div class='logout'>
                <span class="material-symbols-outlined">logout</span>
                <a href="logout.php" class="custom">Logout</a>
            </div>
            
        </div>

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
            
        <?php
        if ($isEmpty) {
            echo "<p>No course found.</p>";
        } else {
            if (count($courses) > 0) {
        ?>
        <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Teacher</th>
                        <th>Session count</th>
                        <th>Program assignment</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $previousValue = null;

                foreach ($courses as $cour) {
                    if ($cour['course_code'] === $previousValue) {
                        continue; 
                    }

                    echo '<tr>';
                    echo '<td>' . $cour['course_code'] . '</td>';
                    echo '<td>' . $cour['course_name'] . '</td>';
                    echo '<td>' . ($cour['teacher'] ?? '<span class="null-value">NULL</span>') . '</td>';
                    echo '<td>' . ($cour['session count'] == 1 ? '<span class="null-value">NULL</span>' : $cour['session count']) . '</td>';
                    echo '<td>';
                    echo '<a href="assign_course.php?id=' . $cour['course_code'] . '" class="custom"><span class="material-symbols-outlined">assignment_add</span></a>';
                    echo '</td>';

                    echo '</tr>';

                    $previousValue = $cour['course_code'];
                }
                ?>
                </tbody>

        </table>

        <br>

        <p><b>Programs assignment</b></p> 
        <?php
            $new_lst = array();
            foreach ($courses as $cour) {
                if (!in_array($cour['program_assignment'], $new_lst)) {
                    $new_lst[] = $cour['program_assignment'];
                }
            }
            foreach ($new_lst as $pop) {
            echo '<ul>';
            echo '<li>' . $pop . '</li>';
            echo '</ul>';

            }
            }
        }
        ?>

                <br>
                <br>
            </div>

</body>

</html>