 <?php
    require_once "course.php";
    $id = $_GET['id'];

    $courses = Course::getCourseById($id);
    $pop_list = Course::getAllPopulations();

    $available_majors = [];
    $name = $courses[0]['course_name'];

    foreach ($courses as $cour) {
        $assigned_majors[] = $cour['program_assignment'];
    }

    foreach ($pop_list as $pop) {
        if (!in_array($pop, $assigned_majors)) {
            $available_majors[] = $pop;
        }
    }


    if (isset($_POST['population'])) {
        $populations = (array) $_POST['population'];
        foreach ($populations as $pop) {
            $new_course = new Course($id, $name, $pop);
            $new_course->assignCourse();
        }
        header('Location: welcome.php');
        exit();
    }
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="style/main.css">
     <title>Assign course</title>
 </head>


 </header>

 <div class="content">
     <div class="form_wrapper">

         <div id="login-header" class="login-header">
             <h2>Assign course to major</h2>
         </div>

         <form method="post" action="assign_course.php?id=<?php echo $id ?>" class='form_group'>

             <?php
                if (count($available_majors) == 0) {
                    echo "<p>All majors are already assigned.</p>";
                } else {
                    echo "<label>Assign " . $id  . " to ...</label>";
                    echo "<br>";

                    foreach ($available_majors as $major): ?>
                     <div>
                         <input type="checkbox" name="population[]" value="<?php echo $major; ?>" />
                         <label><?php echo $major; ?></label>
                     </div>

             <?php endforeach;
                }
                if (count($available_majors) > 0) {
                    echo "<div class='login_button'>";
                    echo "<input type='submit' value='Assign' class='login-input'></div>";
                }
                ?>
         </form>
     </div>
 </div>
 </div>
 </body>

 </html>