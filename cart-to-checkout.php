<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
include('include/collection.class.php');
$conn = DB::db();
session::start();
if (session_status() === PHP_SESSION_NONE) {
    echo "<script>alert('Session not start')</script>";
}
if (session::get('is_login')) {
    $user1 = session::get('username');
    $user2=session::get('id');
    $place = false;
    $order = false;
    $msg = null;
    $place1 = false;
    $order1 = false;
    if (isset($_POST["place"])) {
        $id = $conn->real_escape_string($_POST["user_id"]);
        $sql = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$id'");
        $row = mysqli_fetch_array($sql);
        if ($row['active'] == 0) {
            $name = $conn->real_escape_string($_POST["name"]);
            $phone = $conn->real_escape_string($_POST["phone"]);
            $address = $conn->real_escape_string($_POST["address"]);
            $delivery = "cash on delivery";
            $id = $conn->real_escape_string($_POST["user_id"]);
            $img = $_POST["img"];
            $product_name = $_POST["product_name"];
            $product_id = $_POST["product_id"];
            $color = $_POST["color"];
            $size = $_POST["size"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];
            $name = htmlspecialchars($name);
            $phone = htmlspecialchars($phone);
            $address = htmlspecialchars($address);
            $id = htmlspecialchars($id);
            $product_id = implode(",", $product_id);
            $product_name = implode(",", $product_name);
            $size = implode(",", $size);
            $color = implode(",", $color);
            $price = implode(",", $price);
            $quantity = implode(",", $quantity);
            $img = implode(",", $img);
            $order = collection::order($id, $name, $phone, $address, $delivery, $product_id, $size);
            $place = true;
        } else {
            echo "<script>alert('This product already placed in order please check your order list!')</script>";
            header("refresh:1; url=order");
        }
    }
    if ($order == true && $place == true) {
        $product_ids = base64_encode($product_id);
        $colors = base64_encode($color);
        $sizes = base64_encode($size);
        $msg = "Order placed successfully.If you want recepit <a href='print?product_id=$product_ids&color=$colors&size=$sizes' target='_blank'>click here</a>. page render with in 10sec!";
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
        <p class="error msg text-white"><?php if (isset($msg)) { ?>
        <div class="alert alert-success text-center" role="alert"><?php echo $msg; ?></div>
    <?php  } ?></p>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <?php include('__template/__cart_checkout.php'); ?>
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

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/validate.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('body').on('click', '.buy_now', function(e){
            var totalAmount = $('#total').val();
            var username =  $('#name').val();
            var phone =  $('#phone').val();
            var address =  $('#address').val();
            var id =  $('#user_id').val();
            if(username=="" || username==null){
                alert("Please enter your name");
            }else if(phone=="" || phone==null){
                alert("Please enter your phone no");
            }else if(address=="" || address==null){
                alert("Please enter your address");
            }else{
                var options = {
                "key": "rzp_test_FTHxmaWdqiH2GI", // secret key id
                "amount": (totalAmount * 100), // 2000 paise = INR 20
                "name": "My-shop",
                "description": "Payment",
                "image": "https://img.lovepik.com/element/45003/6056.png_300.png",
                "handler": function(response) {
                    $.ajax({
                        url: 'payment-proccess.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            totalAmount: totalAmount,
                            username: username,
                            phone: phone,
                            address: address,
                            id: id,
                        },
                        success: function(msg){
                            var show=JSON.stringify(msg);
                            alert(show);
                            window.location.href = 'order';
                        }
                    });
                },
                "theme": {
                    "color": "#528FF0"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
            }
        });
    </script>
    </body>

    </html>

<?php } else {
    header("Location: login");
} ?>