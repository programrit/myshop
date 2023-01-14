<?php
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
    $info=false;
    $contact=false;
    if(isset($_POST["submit"])){
        $name=$conn->real_escape_string($_POST["name"]);
        $query="SELECT * FROM user WHERE username='$user1'";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $id=$row["id"];
        $email=$conn->real_escape_string($_POST["email"]);
        $phone=$conn->real_escape_string($_POST["phone"]);
        $message=$conn->real_escape_string($_POST["message"]);
        $name=htmlspecialchars($name);
        $email=htmlspecialchars($email);
        $phone=htmlspecialchars($phone);
        $message=htmlspecialchars($message);
        $contact=user::contact($id,$name,$email,$phone,$message);
        $info=true;
    }
    if($contact==true && $info==true){
        echo "<script>alert('Message send successfully.contact us soon')</script>";
        header("refresh:1; url=contact");
    }
    
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-contact</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping contact us</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <?php include('__template/__show_contact.php'); ?>
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
    <!-- <script src="mail/contact.js"></script> -->

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/validate.js"></script>
</body>

</html>
<?php
}else{
    header("Location: login");
}

?>


