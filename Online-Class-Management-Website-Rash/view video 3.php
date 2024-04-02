<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
    exit(); // Add exit() after header to stop further execution
} else {
    if(isset($_POST['delete_video'])){
      
        $delete_id = $_POST['video_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
        $verify_video = $dbh->prepare("SELECT * FROM `video` WHERE id = ? LIMIT 1");
        $verify_video->execute([$delete_id]);
        if($verify_video->rowCount() > 0){
           $fetch_thumb = $verify_video->fetch(PDO::FETCH_ASSOC);
           unlink('uploaded_files/'.$fetch_thumb['thumbnail']);
           unlink('uploaded_files/'.$fetch_thumb['video']);
           $delete_content = $dbh->prepare("DELETE FROM `video` WHERE id = ?");
           $delete_content->execute([$delete_id]);
           $message[] = 'Video deleted!';
        } else {
           $message[] = 'Video already deleted!';
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
    
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <title>View Video</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
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
    <div class="row">
        <?php
        $select_videos = $dbh->prepare("SELECT * FROM `video` ORDER BY Updationdate DESC");
        $select_videos->execute();
        if($select_videos->rowCount() > 0) {
            while($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) { 
                $video_id = $fetch_videos['id'];
        ?>

        <div class="col-md-3">
            <div class="w3-card-4 w3-dark-grey" style="margin-bottom: 20px;">

                <div class="w3-container w3-center">
                    <h6 class="title"><?= $fetch_videos['title']; ?></h6>
                    <img src="uploaded_files/<?= $fetch_videos['thumbnail']; ?>" class="thumbnail" width=98% height=150px alt="">
                    <h6 class="card-subtitle mb-2 "><?= $fetch_videos['Updationdate']; ?></h6>
                    <p class="card-text"><?= $fetch_videos['description']; ?></p>

                    <div class="w3-section">
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                            <a href="edit-video.php?get_id=<?= $video_id; ?>" class="w3-button w3-gray btn-custom">Update</a>
                            <a href="view_content.php?get_id=<?= $video_id; ?>" class="w3-button w3-gray btn-custom" >View Content</a>
                            <input type="submit"  value="Delete" class="w3-button w3-gray btn-custom" onclick="return confirm('Delete this video?');" name="delete_video">
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        }
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
