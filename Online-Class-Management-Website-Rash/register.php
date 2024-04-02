<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthdayDate = $_POST['birthdayDate'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $subject = $_POST['subject']; 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Validate form inputs
    if (empty($firstName) || empty($lastName) || empty($birthdayDate) || empty($gender) || empty($emailAddress) || empty($phoneNumber) || empty($subject) || empty($username) || empty($password) || empty($confirmPassword)) {
        $message = 'Please fill all the fields';
    } elseif ($password !== $confirmPassword) {
        $message = 'Passwords do not match';
    } else {
        // Retrieve the current date
        $registrationDate = date('Y-m-d');

        // Perform database insertion
        $sql = "INSERT INTO teacher (first_name, last_name, birthday, gender, email, phone_number, subject, registration_date, username, password)
                VALUES (:firstName, :lastName, :birthdayDate, :gender, :emailAddress, :phoneNumber, :subject, :registrationDate, :username, :password)";
         
        $query = $dbh->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':birthdayDate', $birthdayDate, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':emailAddress', $emailAddress, PDO::PARAM_STR);
        $query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':registrationDate', $registrationDate, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $query->execute();
        if ($query) {
            $message = 'Registration successful.';
        } else {
            $message = 'Error occurred.';
        }
    }
}
?>

<!-- Rest of the HTML code -->

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Class Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="">
    <?php if (!empty($message)): ?>
        <div><?php echo $message; ?></div>
    <?php endif; ?>
    <div class="main-wrapper">
        <div class="">
            <div class="row">
                <h1 align="center">Online Class Management System</h1>
                <div class="col-lg-11 visible-lg-block">
                    <section class="section">
                        <div class="row mt-40">
                            <div class="col-md-20 col-md-offset-1 pt-70">
                                <div class="row mt-30">
                                    <div class="col-md-13">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title text-center">
                                                    <h4>Students Registration Form</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body p-50">
                                                <section class="vh-100 gradient-custom">
                                                    <div class="container py-5 h-100">
                                                        <div class="row justify-content-center align-items-center h-100">
                                                            <div class="col-12">
                                                                <form class="form-horizontal" method="post">
                                                                    <div class="form-group">
                                                                        <label for="firstName" class="col-sm-2 control-label">First Name</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="lastName" class="col-sm-2 control-label">Last Name</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="birthdayDate" class="col-sm-2 control-label">Birthdate</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="date" class="form-control" id="birthdayDate" name="birthdayDate" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="gender" class="col-sm-2 control-label">Gender</label>
                                                                        <div class="col-sm-10">
                                                                            <select class="form-control" id="gender" name="gender" required>
                                                                                <option value="">Select Gender</option>
                                                                                <option value="Male">Male</option>
                                                                                <option value="Female">Female</option>
                                                                                <option value="Other">Other</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="emailAddress" class="col-sm-2 control-label">Email</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter Email" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="phoneNumber" class="col-sm-2 control-label">Phone Number</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="subject" class="col-sm-2 control-label">Subject</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" required>
                                                                        </div>
                                                                    </div>
                                                                
                                                                    <div class="form-group">
                                                                        <label for="username" class="col-sm-2 control-label">Username</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password" class="col-sm-2 control-label">Password</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                            <button type="submit" name="register" class="btn btn-success btn-labeled pull-right">Register<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>

                                                                            
                                                                        

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <p class="link">Already have an account? <a href="index.php">loging</a></p>
                                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery/jquery-1.12.3.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>
</html>
