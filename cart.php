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
$del=false;
$remove=false;
if (session::get('is_login')) {
    $user1=session::get('username');
    $user2=session::get('id');
    if(isset($_POST["remove"])){
        $id=$conn->real_escape_string($_POST["remove"]);
        $id=htmlspecialchars($id);
        $del=collection::remove($id);
        $remove=true;

    }
    if($del===true && $remove ==true){
        echo "<script>alert('Product remove to cart successfully!')</script>";
        header("refresh:1; url=cart");
    }
    if(isset($_POST["quantity"])){
        $quantity=$conn->real_escape_string($_POST["quantity"]);
        $quantity=htmlspecialchars($quantity);
        $id=$conn->real_escape_string($_POST["id"]);
        $id=htmlspecialchars($id);
        $name=$conn->real_escape_string($_POST["name"]);
        $name=htmlspecialchars($name);
        $size=$conn->real_escape_string($_POST["size"]);
        $size=htmlspecialchars($size);
        $price=$conn->real_escape_string($_POST["price"]);
        $price=htmlspecialchars($price);
        $query=mysqli_query($conn,"SELECT * FROM mens_size WHERE product_id='$id' AND size='$size'");
        $row=mysqli_fetch_array($query);
        $qty=$row["quantity"];
        if($quantity>$qty){
            echo"<script>alert('$name quantity limit is only for less than $qty!')</script>";
            header("refresh:1; url=cart");
        }else if($quantity>10){
            echo"<script>alert('quantity limit less than 10 only!')</script>";
            header("refresh:1; url=cart");
        }else{
            $total=$quantity*$price;
            $update=mysqli_query($conn,"UPDATE cart SET quantity='$quantity',total='$total' WHERE product_id='$id' AND size='$size'");
            if($update===true){
                header("refresh:1; url=cart");
            }else{
                echo"<script>alert('somethig went wrong. please try again later!')</script>";
                header("refresh:1; url=cart");
            }
        }

    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-cart</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping cart</h1>
            <div class="d-inline-flex">
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <?php include('__template/__show_cart.php'); ?>
    <!-- Cart End -->


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
        function checkdelete(){
            return confirm("Are you sure you want to remove this product? ");
        }        
    </script>
    <script>
    function submitValue(){
        var price=document.getElementsByClassName("price");
        var quantity=document.getElementsByClassName("quantity");
        var total=document.getElementsByClassName("total");
        for(i=0;i<price.length;i++){
            // total[i].innerText="$"+(price[i].value)*(quantity[i].value);
        }
    }
    submitValue();

</script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php }else{
    header("Location: login");
}?>



