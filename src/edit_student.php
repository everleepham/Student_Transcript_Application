<?php
require_once "student.php";
$objStu = Student::getStudentbyMail($_GET['email']);

if ($objStu->getIntake() == 'FALL') {
    $intake = 'F2020';
} else {
    $intake = 'S2021';
}
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <title>Edit student</title>
 </head>


 <body>
    <div class="form_wrapper">
        <div id="login-header" class="login-header">
            <h2>Edit Students</h2>
        </div>

        <form method="post" action="edit_student_action.php?" class='form_group'>
            <label>First name</label><br>
            <div class="input-box">
                <input type="text" name="fname" class='input-field' value="<?php echo $objStu->getFname(); ?>">
            </div>
            <br>
            <label>Last name</label>
            <div class="input-box">
                <input type="text" name="lname" class='input-field' value="<?php echo $objStu->getLname(); ?>">
            </div>
            <br>
            <label>Epita email</label>
            <div class="input-box">
                <input type="text" name="email" class='input-field' value="<?php echo $objStu->getEmail(); ?>" readonly>
            </div>

            <br>

            <label>Intake</label> <br>
            <span class="radio-group">
                <input type="radio" name="intake" class="add_stu" value="F2020" <?php echo $intake === 'F2020' ? 'checked' : ''; ?> disabled>F2020<br>
            </span>
            <span class="radio-group">
                <input type="radio" name="intake" class="add_stu" value="S2021" <?php echo $intake === 'S2021' ? 'checked' : ''; ?> disabled>S2021<br>
            </span><br>

            <label>Major</label>
            <div class="input-box">
            <select name="population" class="input-select" disabled>
                <option value="AIs" <?php echo $objStu->getPopulation() === 'AIs' ? 'selected' : ''; ?> >Artificial Intelligence</option> 
                <option value="CS" <?php echo $objStu->getPopulation() === 'CS' ? 'selected' : ''; ?> >Cyber Security</option> 
                <option value="ISM" <?php echo $objStu->getPopulation() === 'ISM' ? 'selected' : ''; ?> >Information System Management</option> 
                <option value="DSA" <?php echo $objStu->getPopulation() === 'DSA' ? 'selected' : ''; ?> >Data Science</option>
                <option value="SE" <?php echo $objStu->getPopulation() === 'SE' ? 'selected' : ''; ?> >Software Engineering</option>
            </select>
            </div>
            <input type="hidden" name="population" value="<?php echo $objStu->getPopulation(); ?>">
            <br>

            <div class="login_button">
                <input type="submit" value="Save" class='login-input'>
            </div>
    </form>
    </div>
</div>
</body>

</html>