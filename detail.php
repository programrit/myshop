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
error_reporting(0);
if (session::get('is_login')) {
    $user1=session::get('username'); 
    $add=false;   
    $cart=false;
    if(isset($_POST["cart"])){
        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
        $row=mysqli_fetch_array($sql);
        $sql1=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$_POST[id1]'");
        $row1=mysqli_fetch_array($sql1);
        if($row1['active']==1){
            $user=$row['id'];
            $id1=$conn->real_escape_string($_POST["id1"]);
            $name=$conn->real_escape_string($_POST["name1"]);
            $size=$conn->real_escape_string($_POST["size1"]);
            $price=$conn->real_escape_string($_POST["price1"]);
            $quantity=$conn->real_escape_string($_POST["quantity"]);
            $color=$conn->real_escape_string($_POST["color"]);
            $img=$conn->real_escape_string($_POST["img"]);
            $name=htmlspecialchars($name);
            $id1=htmlspecialchars($id1);
            $size=htmlspecialchars($size);
            $price=htmlspecialchars($price);
            $quantity=htmlspecialchars($quantity);
            $color=htmlspecialchars($color);
            $img=htmlspecialchars($img);
            $total=$quantity*$price;
            if($quantity >10){
                echo "<script>alert('Quantity must be less 10.')</script>";
            } else{
                $cart=collection::cart($user,$id1,$name,$img,$size,$price,$quantity,$color,$total);
                $add=true;
            }  
        }else{
            echo "<script>alert('This product not available!')</script>";
            header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
        }
    }
    if($cart==true && $add==true){
        echo "<script>alert('Product add to cart successfully!')</script>";
        header("refresh:1; url=cart");
    }
    if(isset($_POST["order"])){
        $sql1=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$_POST[id1]'");
        $row1=mysqli_fetch_array($sql1);
        if($row1['active']==1){
            $id1=$conn->real_escape_string($_POST["id1"]);
            $size=$conn->real_escape_string($_POST["size1"]);
            $id1=htmlspecialchars($id1);
            $size=htmlspecialchars($size);
            $query="SELECT * FROM cart WHERE product_id='$id1' AND size='$size' AND active='0'";
            $result=$conn->query($query);
            $query1="SELECT * FROM cart WHERE product_id='$id1' AND size='$size' AND active='1'";
            $result1=$conn->query($query1);
            if($result->num_rows>0){
                echo "<script>alert('This product is already add to cart. you cannot place order!')</script>";
                header("refresh:1; url=cart");
            }else if($result1->num_rows>0){
                echo "<script>alert('This product is already placed order. you cannot place order again!')</script>";
                header("refresh:1; url=order");
            }else{
                session::set("id",$id1);
                session::set("name", $_POST["name1"]);
                session::set("size", $_POST["size1"]);
                session::set("color", $_POST["color"]);
                session::set("price",$_POST["price1"]);
                session::set("quantity",$_POST["quantity"]);
                session::set("color",$_POST["color"]);
                session::set("img",$_POST["img"]);
                $total=($_POST["quantity"])*($_POST["price1"]);
                session::set("total",$total);
                if($_POST["quantity"]>10){
                    echo "<script>alert('Quantity must be less 10.')</script>";
                } else{
                   header("Location: checkout?id=".base64_encode($id1));
                }
            }
        }else{
            echo "<script>alert('This product not available!')</script>";
            header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
        }
    
    }
    $review=false;
    $insert=false;
    if(isset($_POST["save"])){
        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
        $row=mysqli_fetch_array($sql);
        $user_id=$row['id'];
        $id=$conn->real_escape_string($user_id);
        $product_id=$conn->real_escape_string($_POST["product_id"]);
        $product_name=$conn->real_escape_string($_POST["product_name"]);
        $name=$conn->real_escape_string($_POST["name"]);
        $rate=$conn->real_escape_string($_POST["rating"]);
        $message=$conn->real_escape_string($_POST["message"]);
        $id=htmlspecialchars($id);
        $product_id=htmlspecialchars($product_id);
        $product_name=htmlspecialchars($product_name);
        $name=htmlspecialchars($name);
        $rate=htmlspecialchars($rate);
        $message=htmlspecialchars($message);
        $review=collection::review($id, $product_id, $product_name, $name, $rate, $message);
        $insert=true;
    }
    if($review==true && $insert==true){
        echo "<script>alert('Review and ratings add successfully!')</script>";
        header("refresh:1; url=detail?id=".base64_encode($product_id));
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShop-detail</title>
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
    <link href="rating/fontawesome-stars.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <!-- <script src="rating/jquery.barrating.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop detail</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <?php include('__template/__show_detail.php'); ?>
    <!-- Shop Detail End -->

    <!-- Footer Start -->
    <?php include('__template/__footer.php'); ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="js/validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
                var rating = data.rating;
                $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
                $(this).parent().find('.result').text('Rating : '+ rating);
                $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
            });
        });
        // window.addEventListener('beforeunload',()=>{
        //     event.preventDefault();
        //     event.returnValue="";
        // });
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
        function display(){
            $('#quantity').html('');
            var id=document.getElementById('size').value;
            var ids=document.getElementById('ids').value;
            $.ajax({
                type:'post',
                url:'fetch.php',
                data: {size:id, product_id:ids},
                success: function(data){
                    $('#quantity').html(data);
                }
            });
            $('#price').html('');
            $.ajax({
                type:'post',
                url:'fetch1.php',
                data: {size:id, product_id:ids},
                success: function(data){
                    $('#price').text("$ "+data);
                    var s=document.getElementById('price1').value=data;
                }
            });
        }
        (function (){
            var words=[
                "You know that thing when you see someone cute and he smiles and your heart kind of goes like warm butter sliding down hot toast? Well that’s what it’s like when I see a store. Only it’s better.",
                "I love shopping. There is a little bit of magic found in buying something new. It is instant gratification, a quick fix.",
                "When I shop, the world gets better, and the world is better, but then it’s not and I need to do it again…",
                "On the one hand, shopping is dependable: You can do it alone, if you lose your heart to something that is wrong for you, you can return it; it’s instant gratification and yet something you buy may well last for years.",
                "The secret idea she was forming of an afterlife gave her the foothold she needed to endure the agonies to come, a newfound courage and optimism which found instant expression through SHOPPING.",
                "A man will never love you or treat you as well as a store. If a man doesn’t fit, you can’t exchange him seven days later for a gorgeous cashmere sweater. And a store always smells good. A store can awaken a lust for things you never even knew you needed. And when your fingers first grasp those shiny, new bags… oh yes… oh yes.",
                "Be at the pains of putting down every single item of expenditure whatsoever every day which could possibly be twisted into a professional expense and remember to lump in all the doubtfuls.",
                "Shopping is a woman thing. It’s a contact sport like football. Women enjoy the scrimmage, the noisy crowds, the danger of being trampled to death, and the ecstasy of the purchase.",
                "I’ve no idea when I’m going to wear it, the girl replied calmly. I only knew that I had to have it. Once I tried it on, well… She shrugged. The dress claimed me."
            ],
            i=0;
            setInterval(function(){
               $('#words').fadeOut(function(){
                $(this).html(words[(i = (i+1) % words.length)]).fadeIn();
               });
            },5000)
        })();
    </script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php }else{
    header("Location: login");
}
?>


<!-- $(document).ready(function(){
            var rating_data=0;
            $(document).on('mouseenter','.submit_star',function(){
                var rating=$(this).data('rating');
                reset_background();
                for(var count=1; count<=rating; count++){
                    $('#submit_star-'+ count).addClass('text-warning');
                }
            });
            function reset_background(){
                for(var count=1; count<=5; count++){
                    $('#submit_star-'+ count).addClass('star-light');
                    $('#submit_star-'+ count).removeClass('text-warning');
                }
            }
            $(document).on('mouseleave','.submit_star',function(){
                reset_background();
            });
            $(document).on('mouseenter','.submit_star',function(){
                rating_data=$(this).data('rating');
            });
            $('#save').click(function(){
                var name=$('#name').val();
                var message=$('#message').val();
                if(name==''||message==''){
                    alert("Please fill all the field!");
                    return false;
                }else{
                    $.ajax({
                        url:"review.php",
                        method:"POST",
                        data:{rating_data:rating_data, name:name, message:message},
                        success:function(data){
                            alert(data);
                        }
                    });
                }
            });
    }); -->