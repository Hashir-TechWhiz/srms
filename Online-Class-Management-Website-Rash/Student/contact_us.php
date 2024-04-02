<?php
session_start();

include('../includes/config.php');
$msg = '';
$error = '';
$message ='';
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: ../index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
    $roll_id=$_POST['roll_id'];
$name=$_POST['name']; 
$email=$_POST['email'];
$subject=$_POST['subject']; 
$class=$_POST['class'];  
$msg=$_POST['msg'];

    
$sql = "INSERT INTO contact (roll_id, name, email, subject, class, mgs) VALUES (:roll_id, :name, :email, :subject, :class, :msg)";

    $query = $dbh->prepare($sql);
    $query->bindParam(':roll_id',$roll_id,PDO::PARAM_INT);
    $query->bindParam(':name',$name,PDO::PARAM_STR);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
    $query->bindParam(':subject',$subject,PDO::PARAM_STR);
    $query->bindParam(':class',$class,PDO::PARAM_STR);
    $query->bindParam(':msg',$msg,PDO::PARAM_STR);
   

    try {
        // ... (your existing code)
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $message = "Message sent successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}    
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Us</title>
        <link rel="stylesheet" href="../css/bootstrap.css" media="screen" >
        <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="../css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="../css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="../css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="../css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <script type="text/javascript">

</script>
         <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

 .box-container{
   margin-top: 3rem;
   display: flex;
   align-items: flex-start;
   gap: 1.5rem;
   flex-wrap: wrap;
}

.box-container .box{
   flex: 1 1 30rem;
   border-radius: .5rem;
   background-color: var(--white);
   padding: 2rem;
   text-align: center;
}

 .box-container .box i{
   font-size: 3rem;
   color: var(--main-color);
   margin-bottom: 1rem;
}

 .box-container .box h4{
   margin: 1.5rem 0;
   font-size: 2rem;
   color: var(--black);
}

 .box-container .box a{
   display: block;
   font-size: 1.2rem;
   color: black;
   line-height: 1.5;
   margin-top: .5rem;
}

 .box-container .box a:hover{
   text-decoration: underline;
   color: blue;
}
 .image{
   flex: 1 1 50rem;
}

.image img{
   height: 50rem;
   width: 100%;
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('s-topbar.php');?>   
            <div class="content-wrapper">
                <div class="content-container">
<?php include('s-leftbar.php');?>                   
 <!-- /.left-sidebar -->

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Contact Us</h2>
                                </div>
                                
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="s-dashboard.php"><i class="fa fa-home"></i> Home</a></li>
            						
            							<li class="active">Contact Us</li>
            						</ul>
                                </div>
                               
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                              

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Contact Us</h5>
                                                </div>
                                            </div>
          
  
  <div class="panel-body">

  <?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($message); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

      <form  name="contact" method="post" >
          <div class="form-group has-success">
          <label for="rollid">Enter your Roll Id</label>
          <input type="text" class="form-control" id="roll_id" placeholder="Enter Your Roll Id" autocomplete="off" name="roll_id">
          <label for="name">Enter your name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Your name" autocomplete="off" name="name">
          <label for="email">Enter your Email</label>
          <input type="text" class="form-control" id="email" placeholder="Enter Your Email" autocomplete="off" name="email">
          
          <label for="subject">Enter your subject</label>
          
          <select name="subject" class="form-control" id="default" required="required">
<option value="">Select subject</option>
<?php $sql = "SELECT * from tblsubjects";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>

<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->SubjectName); ?>&nbsp; </option>
<?php }} ?>
 </select>      
          
          <label for="class">Enter your Class</label>
         

          <select name="class" class="form-control" id="default" required="required">
<option value="">Select Class</option>
<?php $sql = "SELECT * from tblclasses";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
<?php }} ?>
 </select>
              
         
             
             
<label for="message">Enter your message</label>         
<textarea name="msg" class="box" placeholder="enter your message here" required cols="100" rows="10" maxlength="1000"></textarea>
              
<button type="submit" name="submit" class="btn btn-success btn-labeled pull-right">send<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
              
         



          
 </form>


    
  </div>
  </section>
<section>  

<div class="box-container">

   <div class="box">
     
      <img src="images\call.jpg" alt="">
      <h4> Call Us    </h4>    
      <a href="tel:1234567890">123-456-7890</a>
      <a href="tel:066-456435670">066-456435767</a>
   </div>

   <div class="box">
      <i class="fas fa-envelope"></i>
      <img src="images/gmail.png" alt="">
      <h4>Email us     </h4> 
      <a href="mailto:vishahigheredu@gmail.com">vishahigheredu@gmail.com</a>
      <a href="mailto:admineredu@gmail.com">admineredu@gmail.com</a>
   </div>

   <div class="box">
      <i class="fas fa-map-marker-alt"></i>
      <img src="images/location.png" alt="">
      <h4>office address</h4>
      <a href="#">no 11/3 oruthota road gampaha</a>
   </div>


</div>

</section>
                             
  
                                          

        <!-- ========== COMMON JS FILES ========== -->
        <script src="../js/jquery/jquery-2.2.4.min.js"></script>
        <script src="../js/jquery-ui/jquery-ui.min.js"></script>
        <script src="../js/bootstrap/bootstrap.min.js"></script>
        <script src="../js/pace/pace.min.js"></script>
        <script src="../js/lobipanel/lobipanel.min.js"></script>
        <script src="../js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="../js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="../js/main.js"></script>



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
<?php  } ?>

