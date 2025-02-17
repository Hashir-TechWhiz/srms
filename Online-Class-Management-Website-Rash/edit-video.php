<?php
session_start();
include('includes/config.php');

$msg = ""; // Initialize the variable $msg
$error = ""; // Initialize the variable $error

if(strlen($_SESSION['alogin'])=="") {   
    header("Location: index.php"); 
} else {
    if(isset($_POST['submit'])) {
        
        $title = $_POST['title']; 
        $description = $_POST['description']; 
        $subject = $_POST['subject'];
        $class = $_POST['class'];
        $thumbnail = $_FILES['thumbnail']['name'];
        $thumbnail = filter_var($thumbnail, FILTER_SANITIZE_STRING);
        $thumb_ext = pathinfo($thumbnail, PATHINFO_EXTENSION);
        $rename_thumb = uniqid().'.'.$thumb_ext;
        $thumb_size = $_FILES['thumbnail']['size'];
        $thumb_tmp_name = $_FILES['thumbnail']['tmp_name'];
        $thumb_folder = 'uploaded_files/'.$rename_thumb;

        $video = $_FILES['video']['name'];
        $video = filter_var($video, FILTER_SANITIZE_STRING);
        $video_ext = pathinfo($video, PATHINFO_EXTENSION);
        $rename_video = uniqid().'.'.$video_ext;
        $video_tmp_name = $_FILES['video']['tmp_name'];
        $video_folder = 'uploaded_files/'.$rename_video;

        $sql = "UPDATE video SET ClassId=:class, SubjectId=:subject, title=:title, thumbnail, description, video) 
                VALUES(:class, :subject, :title, :thumbnail, :description, :video)";
                move_uploaded_file($thumb_tmp_name, $thumb_folder);
                move_uploaded_file($video_tmp_name, $video_folder);
        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':thumbnail',$rename_thumb, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':video',$rename_video, PDO::PARAM_STR);
        $query->bindParam(':class', $class, PDO::PARAM_STR);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        
        if($lastInsertId) {
            $msg = "New video uploaded!";
        } else {
            $error = "Something went wrong. Please try again";
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
    <title>SRMS Admin Add video</title>
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
                                <h2 class="title">Add video</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li>Subjects</li>
                                    <li class="active">Add Subject Combination</li>
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
                                            <h5>Add video</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if($msg){?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if($error){?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Class</label>
                                                <div class="col-sm-10">
                                                    <select name="class" class="form-control" id="default" required="required">
                                                        <option value="">Select Class</option>
                                                        <?php 
                                                        $sql = "SELECT * from tblclasses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0) {
                                                            foreach($results as $result) {
                                                        ?>
                                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
                                                        <?php 
                                                            } 
                                                        } 
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Subject</label>
                                                <div class="col-sm-10">
                                                    <select name="subject" class="form-control" id="default" required="required">
                                                        <option value="">Select Subject</option>
                                                        <?php 
                                                        $sql = "SELECT * from tblsubjects";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0) {
                                                            foreach($results as $result) {
                                                        ?>
                                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->SubjectName); ?></option>
                                                        <?php 
                                                            } 
                                                        } 
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                                
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="title" class="form-control" id="default" placeholder="Video Title" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="description" class="form-control" id="default" placeholder="Video Description" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Thumbnail</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="thumbnail" accept="image/*" required class="box">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Select Video</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="video" accept="video/*" required class="box">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
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
        </div>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
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
