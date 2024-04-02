<?php
session_start();
error_reporting(0);
include('config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['form_name'] === 'teacher'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database
    $stmt = $dbh->prepare("SELECT id, password FROM teacher WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['teacher_id'] = $row['id'];
            $_SESSION['username'] = $username;
            // Set the cookie
            if(isset($_POST['teacher_id'])) {
                $teacher_id = $_POST['teacher_id'];
                // Now you have the teacher_id value, you can use it as needed
                echo "Teacher ID: " . $teacher_id;
            } else {
                echo "Teacher ID not found.";
            }
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}

else if($_POST['form_name'] === 'student'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database
    $stmt = $dbh->prepare("SELECT id, password FROM student WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['student_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header("Location: Student/s-dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Online Class Management System</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > 
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="">
        <div class="main-wrapper">

            <div class="">
                <div class="row">
 <h1 align="center">Online Class Management System</h1>
                    <div class="col-lg-6 visible-lg-block">

<section class="section">


                            <div class="row mt-40">
                                <div class="col-md-10 col-md-offset-1 pt-50">

                                    <div class="row mt-30 ">
                                        <div class="col-md-11">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                        <h4>Student Login</h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20">

                                                    <div class="section-title">
                                                        <p class="sub-title">Online Class Management System</p>
                                                    </div>

                                                    <?php if (isset($error)): ?>
                                                        <div><?php echo $error; ?></div>
                                                    <?php endif; ?>
                                                    <form class="form-horizontal" method="post" name="student">
                                                    <input type="hidden" name="form_name" value="student">
                                                    	<div class="form-group">
                                                    		<label for="username" class="col-sm-2 control-label">Username</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="text" name="username" class="form-control" id="username" placeholder="User Name" name="username" required>
                                                    		</div>
                                                    	</div>
                                                    	<div class="form-group">
                                                    		<label for="password" class="col-sm-2 control-label" name="password" required>Password</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                                                    		</div>
                                                    	</div>

                                                        <div class="form-group mt-20">
                                                    		<div class="col-sm-offset-2 col-sm-10">

                                                    			<button type="submit" name="login" class="btn btn-success btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    		</div>
                                                    	</div>
                                                    </form>




                                                    <p class="link">Don't have an account? <a href="Student/register.php">register now</a></p>




                                                </div>
                                            </div>
                                            <!-- /.panel -->

                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="section">
                            <div class="row mt-40">
                                <div class="col-md-10 col-md-offset-1 pt-50">

                                    <div class="row mt-30 ">
                                        <div class="col-md-11">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                        <h4>Teacher Login</h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20">

                                                    <div class="section-title">
                                                        <p class="sub-title">Online Class Management System</p>
                                                    </div>

                                                    <?php if (isset($error)): ?>
                                                        <div><?php echo $error; ?></div>
                                                    <?php endif; ?>
                                                    <form class="form-horizontal" method="post" name="teacher" >
                                                    <input type="hidden" name="form_name" value="teacher">
                                                    	<div class="form-group">
                                                    		<label for="username" class="col-sm-2 control-label">Username</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="text" name="username" class="form-control" id="username" placeholder="User Name" name="username" required>
                                                    		</div>
                                                    	</div>
                                                    	<div class="form-group">
                                                    		<label for="password" class="col-sm-2 control-label" name="password" required>Password</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                                                    		</div>
                                                    	</div>

                                                        <div class="form-group mt-20">
                                                    		<div class="col-sm-offset-2 col-sm-10">

                                                    			<button type="submit" name="login" class="btn btn-success btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    		</div>
                                                    	</div>
                                                    </form>

                                                        <p class="link">don't have an account? <a href="register.php">register now</a></p>

 



                                                </div>
                                            </div>
                                            <!-- /.panel -->
                                            
                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>
                        
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->

        </div>
        <p class="text-muted text-center"><small>Copyright @Bitium  </a></small> </p>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        
    </body>
</html>