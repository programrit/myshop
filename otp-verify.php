<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ('phpmailer/src/Exception.php'); 
require ('phpmailer/src/PHPMailer.php');
require ('phpmailer/src/SMTP.php');

include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if (session::get('is_login')) {
    $user1=session::get('username');
    if(isset($_POST["resend_otp"])){
        date_default_timezone_set('Asia/Kolkata');
        $current_date_time=date("Y:m:d H:i:s");
        $query1="SELECT * FROM user WHERE username='$user1'";
        $result1=$conn->query($query1);
        $row1=$result1->fetch_assoc();
        $email=$row1["email"];
        $otp=rand(100000, 999999);
        $message=strval($otp);
        $subject="Verfication code:$message";
        $body="
        <div style='border: 1px solid gray; border-radius: 5px;'>
            <p style='text-align: center;'>My-shop</p>
            <h3 style='text-align: center;'>Verfication email change password</h3>
            <hr>
            <p style='margin-left: 20px; margin-top: 30px;'>Please use the verfication code below to change password</p>
            <h2 style='text-align: center; color: black;'>$message</h2>
            <p style='margin-left: 20px;'>Don't share OTP with anyone.This OTP expire with in 15 minutes</p>
        </div>
        <p style='color: grey; margin-left: 20px;'>You receviwed this email to let you know about important change your password in My-shop</p>
        <p style='color: grey; margin-left: 20px;'>@ 2023 My-shop website Srivilliputhur Virudhunagar Tamilnadu,India</p>
        ";
        $mail=new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username='YOUR_EMAIL';
        $mail->Password='YOUR_PASSWORD';
        $mail->SMTPSecure='ssl';
        $mail->Port=465;
        $mail->setFrom('YOUR_EMAIL');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject=$subject;
        $mail->Body=$body;
        $mail->send();
        if($mail->send()){
            $insert="UPDATE user SET otp='$message',otp_verify='1',otp_verify_time='$current_date_time' WHERE email='$email'";
            if($conn->query($insert)===TRUE){
                echo "<script>alert('OTP send successful. Please check your email!')</script>";
                header("refresh:1; url=otp-verify");
            }else{
                echo "<script>alert('Something went wrong.Please try again later!')</script>";
                header("refresh:1; url=index?user".base64_encode(strrev($user1)));
            }
        }else{
            echo "<script>alert('Something went wrong.Please try again later!')</script>";
            header("refresh:1; url=index?user".base64_encode(strrev($user1)));
        }
    }
    $msg=null;
    $msg1=null;
    if(isset($_POST["otp_verify"])){
        date_default_timezone_set('Asia/Kolkata');
        $otp_send=$conn->real_escape_string($_POST["otp"]);
        $otp=htmlspecialchars($otp_send);
        $query="SELECT * FROM user WHERE username='$user1'";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        if($row["otp_verify"]==1){
            $times_ago=strtotime($row["otp_verify_time"]);
            $current_time=date("Y:m:d H:i:s");
            $check_time =date("Y:m:d H:i:s",strtotime($row["otp_verify_time"].'+15 minutes'));
            if($current_time>=$check_time){
                $update="UPDATE user SET otp_verify='2' WHERE username='$user1'";
                if($conn->query($update)==TRUE){
                    $msg="OTP is expired! Please click resend otp button";
                    // header("refresh:2; url=otp-verify");
                }else{
                    $msg="Something went wrong.Please try again later!";
                    // header("refresh:2; url=otp-verify");
                }
            }else{
                if($otp==$row["otp"]){
                    $updated="UPDATE user SET otp_verify='3' WHERE username='$user1'";
                    if($conn->query($updated)==TRUE){
                        $msg1="OTP verfication successfully!";
                        header("refresh:3; url=change-password");
                    }else{
                        $msg="Something went wrong.Please try again later!";
                        // header("refresh:2; url=otp-verify");
                    }
                   }else{
                        $msg="Incorrect OTP!";
                        // header("refresh:2; url=otp-verify");
                   }
            }
            
        }else if($row["otp_verify"]==3){
            $msg="This OTP is already used.Please click resend otp button";
            // header("refresh:2; url=otp-verify");
        }else if($row["otp_verify"]==2){
            $msg="OTP is expired! Please click resend otp button";
            // header("refresh:2; url=otp-verify");
        }else{
            $msg="You want to change password. click resend otp button";
            // header("refresh:2; url=otp-verify");
        }

    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-otp-varfication</title>
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
    <!-- Topbar Start -->
    <?php include('__template/__topbar.php'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include('__template/__navbar1.php'); ?>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">OTP verification</h1>
        </div>
    </div>
    <p class="error msg text-danger text-center"><?php if(isset($msg)){
                echo $msg;
              } ?> <p class="error msg text-success text-center"><?php if(isset($msg1)){
                echo $msg1;
              } ?></p></p>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <?php include('__template/__otp.php'); ?>
    <!-- Contact End -->


    <!-- Footer Start -->
    <?php include('__template/__footer.php'); ?>
    <!-- Footer End -->


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
    if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
    }
  </script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php
}else{
    header("Location: login");
}

?>


