<?php
// Start the session
session_start();

// Include the database connection
require 'C:\xampp\htdocs\MediSync\php\php\db_connction.php';

// Path to the log file
$log_file = 'login_attempts.log';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password using MD5 (this should match the hash in the database)
    $password_hash = md5($password);

    // Query to validate the credentials
    $query = "SELECT * FROM users WHERE username = ? AND password_hash = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get the current timestamp for logging
    $timestamp = date("Y-m-d H:i:s");

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['username'] = $username; // Store the username in the session
        file_put_contents($log_file, "[$timestamp] Login successful: Username: $username\n", FILE_APPEND);
        header("Location: home.php"); // Redirect to the landing page
        exit();
    } else {
        // Login failed
        $error_message = "Invalid username or password!";
        file_put_contents($log_file, "[$timestamp] Login failed: Username: $username\n", FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Pharmacy Management - Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js"></script>
</head>
<body>
<div class="container">
    <div class="card m-auto p-2">
        <div class="card-body">
            <form name="login-form" class="login-form" action="index.php" method="post">
                <div class="logo">
                    <img src="images/prof.jpg" class="profile"/>
                    <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
                </div> <!-- logo class -->
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user text-white"></i></span>
                    </div>
                    <input name="username" type="text" class="form-control" placeholder="username" required>
                </div> <!-- input-group class -->
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key text-white"></i></span>
                    </div>
                    <input name="password" type="password" class="form-control" placeholder="password" required>
                </div> <!-- input-group class -->
                <!-- Error Message -->
                <?php if (!empty($error_message)) { ?>
                    <div class="text-danger text-center"><?php echo $error_message; ?></div>
                <?php } ?>
                <!-- Submit Button -->
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-custom">Login</button>
                </div>
            </form><!-- form close -->
        </div> <!-- card-body class -->
        <div class="card-footer">
            <div class="text-center">
                <a class="text-light" href="forgot_password.php">Forgot password?</a>
                <br>
                <a class="text-light" href="signup.php">Sign Up</a>
            </div>
        </div> <!-- card-footer class -->
    </div> <!-- card class -->
</div>
</body>
</html>
