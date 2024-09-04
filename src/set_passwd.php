<?php
$errorMessage = '';
require_once 'student.php';

if (isset($_GET['Err'])) {
    switch ($_GET['Err']) {
        case 1:
            $errorMessage = 'Your email not found! Please try again!';
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Student::isEmailExist($_POST['email'])) {
        header('location: set_passwd.php?Err=1');
        exit;
    }
    Student::addPassword($_POST['email'], $_POST['password']);
    header('location: ./login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <title>Set password</title>
</head>

<body>
    <div class="form_wrapper">
        <div id="login-header" class="login-header">
            <h2>Set Password</h2>
        </div>
        <form name='form' method='POST' action='set_passwd.php' class='form_group'>
            <label>Epita email</label><br>
            <div class="input-box">
                <input type='text' name='email' class='input-field' placeholder='e.g: benoit.chevalier@epita.fr' required><br>
            </div>
            <br>
            <label>Set password</label><br>
            <div class="input-box">
                <input type='text' name='password' class='input-field' placeholder='Enter Password' required><br>
            </div>
            <div class='login-failed'><?php echo $errorMessage; ?></div>
            <br>

            <div class="login_button">
                <button type='submit-btn' name='submit' id='submit' value='Login' class='login-input'>Set</button>
            </div>
        </form>
    </div>

</body>

</html>