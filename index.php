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
$user=base64_decode($_GET['user']);

if(session::get('is_login')){
    $user1=session::get('username');
    $users=strrev($user);
if ($user1==$users){
    $query="SELECT * FROM user WHERE username='$user1'";
	$result=$conn->query($query);
	$row=$result->fetch_assoc();
    if(isset($row["username"])==$users){
        $update=mysqli_query($conn,"UPDATE user SET active='1' WHERE username='$user1'");
        $profile=false;
        $pro=false;
        $profile1=false;
        $pro1=false;
        if (isset($_POST["save"])) {
            $id=$conn->real_escape_string($_POST["id"]);
            $name=$conn->real_escape_string($_POST["name"]);
            $date_of_birth=$conn->real_escape_string($_POST["birth"]);
            $address=$conn->real_escape_string($_POST["address"]);
            $id=htmlspecialchars($id);
            $date_of_birth=htmlspecialchars($date_of_birth);
            $name=htmlspecialchars($name);
            $address=htmlspecialchars($address);
            $avatar=$_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "C:/xampp/htdocs/my-shop/profile/".$_FILES["avatar"]["name"]);
            $profile=user::profile($id, $name, $date_of_birth, $address, $avatar);
            $pro=true;
        }
        if ($profile==true && $pro==true) {
            echo "<script>alert('Profile add successfully!')</script>";
            header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
        }
        if (isset($_POST["update"])) {
            $id=$conn->real_escape_string($_POST["id"]);
            $name=$conn->real_escape_string($_POST["name"]);
            $date_of_birth=$conn->real_escape_string($_POST["birth"]);
            $address=$conn->real_escape_string($_POST["address"]);
            $id=htmlspecialchars($id);
            $date_of_birth=htmlspecialchars($date_of_birth);
            $name=htmlspecialchars($name);
            $address=htmlspecialchars($address);
            $avatar=$_FILES["avatar"]["name"];
            if ($avatar==null) {
                $select="SELECT * FROM profile WHERE user_id='$id'";
                $selected=$conn->query($select);
                $fetch=$selected->fetch_assoc();
                $avatar=$fetch["avatar"];
            } else {
                $select1="SELECT * FROM profile WHERE user_id='$id'";
                $selected1=$conn->query($select1);
                $fetch1=$selected1->fetch_assoc();
                $delete="C:/xampp/htdocs/my-shop/profile/$fetch1[avatar]";
                if (is_file($delete)) {
                    unlink($delete);
                    $avatar=$_FILES["avatar"]["name"];
                    move_uploaded_file($_FILES["avatar"]["tmp_name"], "C:/xampp/htdocs/my-shop/profile/".$_FILES["avatar"]["name"]);
                } else {
                    echo "<script>alert('Something went wrong. Please try again later!')</script>";
                    header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
                }
            }
            $profile1=user::profile_update($id, $name, $date_of_birth, $address, $avatar);
            $pro1=true;
        }
        if ($profile1==true && $pro1==true) {
            echo "
                <script>
                   alert('profile update successfully!');
                </script> 
                ";
            header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
        }
        $otp=false;
        if(isset($_POST["change_password"])){
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
            $mail->Password='YOUR_Password';
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
                if($conn->query($insert)){
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
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EShop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">   
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <?php include('__template/__topbar.php') ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include('__template/__navbar.php') ?>
    <!-- Navbar End -->


    <!-- Featured Start -->
    <?php include('__template/__feature.php') ?>
    <!-- Featured End -->


    <!-- Categories Start -->
    <?php include('__template/__category.php') ?>
    <!-- Categories End -->

    <!-- Products Start -->
    <?php include('__template/__product.php') ?>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <?php include('__template/__subscribe.php') ?>
    <!-- Subscribe End -->

    <!-- Vendor Start -->
    <?php include('__template/__vendor.php') ?>
    <!-- Vendor End -->


    <!-- Footer Start -->
    <?php include('__template/__footer.php') ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/validate.js"></script>
</body>

</html>
    <?php }else{
     header("Location: login");
    } 
    }else{
     header("Location: login");
    }
}else{
    header("Location: login");
}

?>


