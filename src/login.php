<?php
$errorMessage = '';
if(isset($_GET['Err'])){
    switch ($_GET['Err']) {
        case 1:
            $errorMessage = 'Login failed, try again';
            break;
    }
}

require_once 'student.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $stu_id = Student::login($_POST['email'], $_POST['password']);
        
        if(!empty($stu_id)){
            session_start();
            $_SESSION['stu_id'] = $stu_id;
            header('location: welcome.php');
            exit;
        } else {
            header('location: ./login.php?Err=1');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/main.css" type='text/css'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>

    <div class='form_wrapper'>
        <div id="login-header" class="login-header">
            <h2>Login</h2>
        </div>
        
        <form name='form' method='POST' action='login.php' class='form_group'>
            <label>Email</label><br>
            <div class="input-box">
                <input type='text' name='email' class='input-field' placeholder='e.g: arelina.chevalier@epita.fr' required pattern=".+@epita.fr" required><br>
            </div>
            <br>
            <label>Password</label><br>
            <div class="input-box">
                <input type='password' name='password' class='input-field' placeholder='e.g: arelina1234' required><br>
            </div>
          
            <br>
            <div class='set-passwd'>
                First time log in? Set password <a href='set_passwd.php' class="custom_link">HERE</a>
            </div>
            <div class='login-failed'><?php echo $errorMessage;?></div> 
            <br>
            <div class="login_button">
                <button type='submit-btn' name='submit' value='Login' class='login-input'><b>Login</b></button>
            </div>

            <br>

            <div class="sign-up-link">
            </div>
        </form>
    </div>
</body>
</html>