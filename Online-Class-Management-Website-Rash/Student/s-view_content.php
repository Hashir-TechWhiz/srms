<?php
session_start();

include('config.php');

$teacher_id = null; // Initialize $teacher_id variable

// Redirect to view_Video.php if get_id is not set
if(!isset($_GET['get_id'])){
    header('location:s-view-Video.php');
    exit(); // Ensure script stops execution after redirection
} else {
    $get_id = $_GET['get_id'];
    $video_id = $_GET['get_id'];

}


 
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <title>View Video</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!--<link rel="stylesheet" href="css/admin_style.css">-->
    <link rel="stylesheet" href="../css/bootstrap.min.css" media="screen" >
    <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen" >
    <link rel="stylesheet" href="../css/animate-css/animate.min.css" media="screen" >
    <link rel="stylesheet" href="../css/lobipanel/lobipanel.min.css" media="screen" >
    <link rel="stylesheet" href="../css/prism/prism.css" media="screen" >
    <link rel="stylesheet" href="../css/select2/select2.min.css" >
    <link rel="stylesheet" href="../css/main.css" media="screen" >
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('s-topbar.php');?> 

        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('s-leftbar.php');?>  

                <div class="main-page">
                    <div class="container-fluid">
                        <!-- Your container fluid content here -->
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h3>View Video</h3>
                                        </div>
                                        
                                        <div class="panel-body">
                                            
<section class="content">
    <div class="row">
    <?php
    
    $select_videos = $dbh->prepare("SELECT * FROM `video` WHERE id = ?");
$select_videos->execute([$get_id]);
    
    if($select_videos->rowCount() > 0) {
        while($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) { 
            $video_id = $fetch_videos['id'];
            $select_likes = $dbh->prepare("SELECT * FROM `likes` WHERE video_id = ?");
            $select_likes->execute([$video_id]);
            $total_likes = $select_likes->rowCount();  

            $student_id = $_SESSION['student_id'];
            $verify_likes = $dbh->prepare("SELECT * FROM `likes` WHERE student_id = ? AND video_id = ?");
            $verify_likes->execute([$student_id, $video_id]);
            $select_tutor = $dbh->prepare("SELECT * FROM `teacher` WHERE id = ? LIMIT 1");
            $select_tutor->execute([$fetch_videos['teacher_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);?>
   
   <div class="container">
   <video src="../uploaded_files/<?= $fetch_videos['video']; ?>" autoplay controls width="840" height="460" poster="../uploaded_files/<?= $fetch_videos['thumbnail']; ?>" class="video" ></video>


      <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_videos['Updationdate']; ?></span></div>
      <h2 class="title"><?= $fetch_videos['title']; ?></h2>
      
      <div class="description"><?= $fetch_videos['description']; ?></div>
      
      

      
   <form action="" method="post" class="flex">
        
         <?php
            if($verify_likes->rowCount() > 0){
         ?>
        
         <?php
         }else{
         ?>
         
         <?php
            }
         ?>
      </form>
      
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no videos added yet!</p>';
      }
   ?>

</section>

<!-- watch video section ends -->


</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="../js/jquery/jquery-2.2.4.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/pace/pace.min.js"></script>
<script src="../js/lobipanel/lobipanel.min.js"></script>
<script src="../js/iscroll/iscroll.js"></script>
<script src="../js/prism/prism.js"></script>
<script src="../js/select2/select2.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
