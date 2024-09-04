<?php
require_once 'course.php';
$population = $_GET['population'];

if(isset($_POST['c_id']) && isset($_POST['c_name'])) {
    $course = new Course($_POST['c_id'], $_POST['c_name'], $population );
    $course->addCourse();
    header('Location: population.php?population=' . $population);
    exit();
}
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <title>Add course</title>
 </head>

 <body>
    <div class="form_wrapper">

    <div id="login-header" class="login-header">
            <h2>Add Course</h2>
    </div>

        <form method="post" class='form_group' action="add_course.php?population=<?php echo $population ?>">
            <label>Course ID</label>
            <div class="input-box">
                <input type="text" name="c_id" class="input-field" required pattern="\S+" placeholder="e.g: AI_DATA_PREP" title="Please enter a course id without spaces." required>
                <br>
            </div>
            <br>
            <label>Course name</label>
            <div class="input-box">
                <input type="text" name="c_name" class="input-field" placeholder="e.g: data exploration and preparation" required>
                <br>
            </div>
            <br>
            <div class="add-course">
                <input type="submit" value="Add this course for <?php echo $population ?>" class='add-course-input'>
            </div>
        </form>
    </div>

 </body>
 </html>