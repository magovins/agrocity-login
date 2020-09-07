<?php
session_start();

// Application library ( with DemoLib class )
require __DIR__ . '/server/library.php';
$app = new Library();

$login_error_message = '';
$register_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->login($email, $password); // check user login
        if($user_id > 0) {
            $_SESSION['user_id'] = $user_id; // Set Session
            header("Location: profile.php"); // Redirect user to the profile.php
        }
        else {
            $login_error_message = 'Invalid login!';
        }
    }
}

// check Register request
if (!empty($_POST['btnRegister'])) {
    if ($_POST['firstName'] == "") {
        $register_error_message = 'First name field is required!';
    } else if ($_POST['email'] == "") {
        $register_error_message = 'Email field is required!';
    } else if ($_POST['lastName'] == "") {
        $register_error_message = 'Last name field is required!';
    } else if ($_POST['password'] == "") {
        $register_error_message = 'Password field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $register_error_message = 'Invalid email address!';
    } else if ($app->isEmail($_POST['email'])) {
        $register_error_message = 'Email is already in use!';
    } else {
        $user_id = $app->register($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password']);
        // set session and redirect user to the profile page
        $_SESSION['user_id'] = $user_id;
        header("Location: profile.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <!-- Latest compiled and minified CSS -->
    <link 
        rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
        crossorigin="anonymous">

</head>
<body>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-5 well">
                <h4>Register</h4>
                <?php
                    if ($register_error_message != "") {
                        echo '
                        <div class="alert alert-danger"><strong>Error: </strong> '. 
                            $register_error_message .
                        '</div>';
                    }
                ?>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" name="firstName" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="lastName" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                    </div>
                </form>
            </div>

            <div class="col-md-2"></div>
            <div class="col-md-5 well">
                <h4>Login</h4>
                <?php
                if ($login_error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
                }
                ?>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>