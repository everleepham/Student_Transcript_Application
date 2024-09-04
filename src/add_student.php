<?php
$population = $_GET['population'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <title>Add student</title>
</head>

<body>
    <div class="form_wrapper">

        <div id="login-header" class="login-header">
            <h2>Add Student</h2>
        </div>

        <form method="post" action="add_student_action.php" class='form_group'>
            <label>First name</label>
            <div class="input-box">
                <input type="text" name="fname" class="input-field" placeholder="e.g: Evelie" required pattern="^[a-zA-Z]{2,30}" required>
            </div>
            <br>

            <label>Last name</label>
            <div class="input-box">
                <input type="text" name="lname" class="input-field" placeholder="eg: Pham" required pattern="^[a-zA-Z]{1,30}" required>
            </div>
            <br>


            <label>Epita email</label>
            <div class="input-box">
                <input type="email" name="email" class="input-field" required pattern=".+@epita.fr" placeholder="e.g: example@epita.fr" title="Please enter an email with @epita.fr." required>
            </div>
            <br>

            <label>Contact email</label>
            <div class="input-box">
                <input type="email" name="contact" class="input-field" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$" placeholder="e.g: example@gmail.com" required>
            </div>
            <br>

            <label>Intake</label> <br>

            <span class="radio-group">
                <input type="radio" name="intake" class="add_stu" value="F2020" required>F2020
            </span>
            <span class="radio-group">
                <input type="radio" name="intake" class="add_stu" value="S2021" required>S2021
            </span><br>

            <br>

            <label>Major</label>
            <div class="input-box">
                <select name="population" class='input-select' required>
                    <option value="AIs" <?php echo $population === 'AIs' ? 'selected' : ''; ?>>Artificial Intelligence</option>
                    <option value="CS" <?php echo $population === 'CS' ? 'selected' : ''; ?>>Cyber Security</option>
                    <option value="ISM" <?php echo $population === 'ISM' ? 'selected' : ''; ?>>Information System Management</option>
                    <option value="DSA" <?php echo $population === 'DSA' ? 'selected' : ''; ?>>Data Science</option>
                    <option value="SE" <?php echo $population === 'SE' ? 'selected' : ''; ?>>Software Engineering</option>
                </select>
            </div>
            <br>

            <div class="login_button">
                <input type="submit" value="Add" class='login-input'>
            </div>
        </form>
    </div>

</body>

</html>