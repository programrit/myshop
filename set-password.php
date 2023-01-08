<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}

$reset=false;
$msg1=null;
$msg=null;
$reset_password=false;
if(isset($_POST["reset_password"])){
    $email_get=$_GET["email"];
    $decodes=base64_decode($email_get);
    $decode=$conn->real_escape_string($decodes);
    $decode=htmlspecialchars($decode);
    $reverse=strrev($decode);
    $email=$reverse;
    $query="SELECT * FROM user WHERE email='$email'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    $user1=$row["username"];
    $password=$conn->real_escape_string($_POST["password"]);
    $password1=$conn->real_escape_string($_POST["password1"]);
    $password=htmlspecialchars($password);
    $password1=htmlspecialchars($password1);
    if($password==$password1){
        $reset_password=user::reset_password($password,$password1,$user1);
        $reset=true;
    }else{
        $msg="Password doesn't match!";
        header("refresh:3; url=set-password");
    }
    
}
if($reset_password==true && $reset==true){
    $msg1="Password update successfully!";
    header("refresh:3; url=login");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-change-password</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Set new Password</h1>
            <a href="login" style="text-decoration:none">Login page</a>
        </div>
    </div>
    <!-- Page Header End -->
    <p class="error msg text-success text-center"><?php if(isset($msg1)){echo $msg1;} ?></p>
    <p class="error msg text-danger text-center"><?php if(isset($msg)){echo $msg;} ?></p>

    <!-- Contact Start -->
    <?php include('__template/__set-password.php'); ?>
    <!-- Contact End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/validate.js"></script>
    <script>
    function preventback(){
      window.history.forward();
    }
    setTimeout("preventback()", 0);
    window.onunload=function(){ null };
  </script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php


?>


