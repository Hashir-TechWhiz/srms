<?php
session_start();
include('includes/config.php');

$teacher_id = null; // Initialize $teacher_id variable



// Redirect to view_Video.php if get_id is not set
if(!isset($_GET['get_id'])){
    header('location:view_Video.php');
    exit(); // Ensure script stops execution after redirection
} else {
    $get_id = $_GET['get_id'];
}

// Handle delete video request
if(isset($_POST['delete_video'])){
    $delete_id = $_POST['video_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_video = $dbh->prepare("SELECT * FROM `video` WHERE id = ? AND teacher_id = ? LIMIT 1");
    $verify_video->execute([$delete_id, $teacher_id]);
    if($verify_video->rowCount() > 0){
        $fetch_thumb = $verify_video->fetch(PDO::FETCH_ASSOC);
        unlink('uploaded_files/'.$fetch_thumb['thumbnail']);
        unlink('uploaded_files/'.$fetch_thumb['video']);
        $delete_content = $dbh->prepare("DELETE FROM `video` WHERE id = ?");
        $delete_content->execute([$delete_id]);
        $message[] = 'Video deleted!';
    } else {
        $message[] = 'Video not found or you do not have permission to delete it!';
    }
}

// Handle delete comment request
if(isset($_POST['delete_comment'])){
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_comment = $dbh->prepare("SELECT * FROM `comments` WHERE id = ? AND teacher_id = ?");
    $verify_comment->execute([$delete_id, $teacher_id]);
    if($verify_comment->rowCount() > 0){
       $delete_comment = $dbh->prepare("DELETE FROM `comments` WHERE id = ?");
       $delete_comment->execute([$delete_id]);
       $message[] = 'Comment deleted successfully!';
    }else{
       $message[] = 'Comment not found or you do not have permission to delete it!';
    }
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
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
    <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
    <link rel="stylesheet" href="css/select2/select2.min.css" >
    <link rel="stylesheet" href="css/main.css" media="screen" >
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
      /*
      $select_content = $dbh->prepare("SELECT * FROM `video` WHERE id = ? AND teacher_id = ?");
      $select_content->execute([$get_id, $teacher_id]);
      if($select_content->rowCount() > 0){
          while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
              $video_id = $fetch_content['id'];*/
              ?>
   
   <div class="container">
   <video src="uploaded_files/<?= $fetch_videos['video']; ?>" autoplay controls width="840" height="460" poster="uploaded_files/<?= $fetch_videos['thumb']; ?>" class="video" ></video>


      <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_videos['Updationdate']; ?></span></div>
      <h2 class="title"><?= $fetch_videos['title']; ?></h2>
      
      <div class="description"><?= $fetch_videos['description']; ?></div>
      <div class="w3-section">
      <form action="" method="post" class="flex-btn">
    <input type="hidden" name="video_id" value="<?= $video_id; ?>">
    <a href="edit-video.php?get_id=<?= $video_id; ?>" class="w3-button w3-gray btn-custom btn-large">Update</a>
    <input type="submit" value="Delete" class="w3-button w3-gray btn-custom btn-large" onclick="return confirm('Delete this video?');" name="delete_video">
</form>

                    </div>
     
   </div>
   <?php
    


      
   ?>
    </div>
</div>

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
</body>
</html>
       <?php }}?>