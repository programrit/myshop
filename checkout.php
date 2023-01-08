<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
include('include/collection.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$out=false;
$check=false;
$out1=false;
$check1=false;
$msg=null;
if (session::get('is_login')) {
    $user1=session::get('username');
    if(isset($_POST["place"])){
        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
        $row=mysqli_fetch_array($sql);
        $user_id=$row["id"];
        $name=$conn->real_escape_string($_POST["name"]);
        $phone=$conn->real_escape_string($_POST["phone"]);
        $address=$conn->real_escape_string($_POST["address"]);
        $delivery="cash on delivery";
        $product_name=session::get("product_name");
        $product_id=session::get("id");
        $img=session::get("img");
        $size=session::get("size");
        $quantity=session::get("quantity");
        $color=session::get("color");
        $total=session::get("total");
        $name=htmlspecialchars($name);
        $phone=htmlspecialchars($phone);
        $address=htmlspecialchars($address);
        $check=collection::checkout($user_id,$name,$phone,$address,$delivery,$product_id,$product_name,$img,$color,$size,$quantity,$total);
        $out=true;

    }
    if($check==true && $out==true){

        $msg="Order placed successfully. If you want recepit <a href='printout?id=$product_id&size=$size' target='_blank'> click</a>";
        header("refresh:10; url=order");
        
    }
    if(isset($_POST["online"])){
        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
        $row=mysqli_fetch_array($sql);
        $user_id=$row["id"];
        $name=$conn->real_escape_string($_POST["name"]);
        $phone=$conn->real_escape_string($_POST["phone"]);
        $address=$conn->real_escape_string($_POST["address"]);
        $delivery="online delivery";
        $product_name=session::get("name");
        $product_id=session::get("id");
        $img=session::get("img");
        $size=session::get("size");
        $quantity=session::get("quantity");
        $color=session::get("color");
        $total=session::get("total");
        $name=htmlspecialchars($name);
        $phone=htmlspecialchars($phone);
        $address=htmlspecialchars($address);
        $check1=collection::checkout($user_id,$name,$phone,$address,$delivery,$product_id,$product_name,$img,$color,$size,$quantity,$total);
        $out1=true;
    
    }
    if($check1==true && $out1==true){
        $msg="Order placed successfully. If you want recepit <a href='printout?id=$product_id&size=$size' target='_blank'> click</a>";
        header("refresh:10; url=order");
    }

    
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-checkout</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping checkout</h1>
        </div>
    </div>
    <p class="error msg text-white"><?php if(isset($msg)){?>
        <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
    <?php  } ?></p>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <?php include('__template/__show_checkout.php'); ?>
    <!-- Checkout End -->


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
    <script src="js/validate.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

<?php }else{
    header("Location: login");
}?>


