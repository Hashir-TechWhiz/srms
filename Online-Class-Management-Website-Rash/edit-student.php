<?php
session_start();
$msg = '';
$error = '';
include('includes/config.php');

    $stid = intval($_GET['stid']);
    if (isset($_POST['submit'])) {
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $roleid = $_POST['role_id'];
        $studentemail = $_POST['email'];
        $gender = $_POST['gender'];
        
        $phone_number = $_POST['phone_number'];

        $sql = "UPDATE student SET first_name=:first_name, last_name=:last_name, role_id=:role_id, email=:email, gender=:gender, phone_number=:phone_number WHERE id=:stid;";
        $query = $dbh->prepare($sql);
        $query->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $query->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $query->bindParam(':role_id', $roleid, PDO::PARAM_STR);
        $query->bindParam(':email', $studentemail, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        
        
        $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $query->bindParam(':stid', $stid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Student info updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin | Edit Student</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
<div class="main-wrapper">
    <!-- ========== TOP NAVBAR ========== -->
    <?php include('includes/topbar.php');?>
    <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
    <div class="content-wrapper">
        <div class="content-container">
            <!-- ========== LEFT SIDEBAR ========== -->
            <?php include('includes/leftbar.php');?>
            <!-- /.left-sidebar -->
            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-6">
                            <h2 class="title">Student Admission</h2>
                        </div>
                    </div>
                    <div class="row breadcrumb-div">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                <li class="active">Student Admission</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5>Fill the Student info</h5>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php if ($msg) : ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php elseif ($error) : ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="form-horizontal" method="post">
                                        <?php
                                        $sql = "SELECT 
                                        student.id AS id,
                                        student.first_name AS first_name,
                                        student.last_name AS last_name,
                                        student.gender AS gender,
                                        student.email AS email,
                                        student.phone_number AS phone_number,
                                        student.role_id AS role_id,
                                        student.subjectid AS subjectid,
                                        tblsubjects.SubjectName AS SubjectName
                                    FROM 
                                        student
                                    LEFT JOIN 
                                        tblsubjects ON student.subjectid = tblsubjects.id
                                    WHERE 
                                        student.id = :stid;
                                    ";

                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':stid', $stid, PDO::PARAM_STR);
                                        $query->execute();
                                        $result = $query->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        
                                        <div class="form-group">
    <label for="default" class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
        <input type="text" name="fname" class="form-control" id="fname" value="<?php echo htmlentities($result['first_name']); ?>" required="required" autocomplete="off">
    </div>
</div>
                                        <div class="form-group">
<label for="default" class="col-sm-2 control-label">Last Name</label>
<div class="col-sm-10">
<input type="text" name="lname" class="form-control" id="lname" value="<?php echo htmlentities($result['last_name']);?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Roll Id</label>
<div class="col-sm-10">
<input type="text" name="role_id" class="form-control" id="role_id" value="<?php echo htmlentities($result['role_id']);?>" maxlength="5" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email </label>
<div class="col-sm-10">
<input type="email" name="email" class="form-control" id="email" value="<?php echo htmlentities($result['email']);?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Contact No </label>
<div class="col-sm-10">
<input type="text" name="phone_number" class="form-control" id="phone_number" value="<?php echo htmlentities($result['phone_number']);?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<?php  
if($result['gender']=="Male")
{
?>
<input type="radio" name="gender" value="Male" required="required" checked>Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($result['gender']=="Female")
{
?>
<input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required" checked>Female <input type="radio" name="gender" value="Other" required="required">Other
<?php }?>
<?php  
if($result['gender']=="Other")
{
?>
<input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required" checked>Other
<?php }?>


</div>
</div>

                                        
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" name="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.main-wrapper -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/prism/prism.js"></script>
<script src="js/select2/select2.min.js"></script>
<script src="js/main.js"></script>
<script>
    $(function ($) {
        $(".js-states").select2();
        $(".js-states-limit").select2({
            maximumSelectionLength: 2
        });
        $(".js-states-hide").select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
</body>
</html>
<?php //} ?>
