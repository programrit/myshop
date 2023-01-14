<?php
if (session::get('is_login')) {
    $user1=session::get('username');
    if(isset($_POST["subcribe"])){
        $name=$conn->real_escape_string($_POST["person"]);
        $email=$conn->real_escape_string($_POST["mail"]);
        $name=htmlspecialchars($name);
        $email=htmlspecialchars($email);
        $query="SELECT * FROM user WHERE username='$user1'";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        $id=$row["id"];
        $sql=mysqli_query($conn,"SELECT * FROM subcribe WHERE user_id='$id'");
        if(mysqli_num_rows($sql)>0){
            echo "<script>alert('Subcribe already exist!')</script>";
        }else{
            $insert="INSERT INTO subcribe (user_id,name,email)VALUES('$id','$name','$email')";
            if($conn->query($insert)===TRUE){
                echo "<script>alert('Subcribe successfully!')</script>";
            }else{
                echo "<script>alert('Something went wrong. PLease try again later')</script>";
            }
        }
    }
}else{
    echo "<script>window.location.href='login'</script>";
}


?>
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
                </a>
                <p>Any faith that admires truth, that strives to know God, must be brave enough to accommodate the universe.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Srivilliputhur virudhunagar</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>ram@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 9876543210</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="mens"><i class="fa fa-angle-right mr-2"></i>Mens collection</a>
                            <a class="text-dark mb-2" href="womens"><i class="fa fa-angle-right mr-2"></i>Womens collection</a>
                            <a class="text-dark mb-2" href="kids"><i class="fa fa-angle-right mr-2"></i>Kids collection</a>
                            <a class="text-dark mb-2" href="cart"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark" href="contact"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-6 ml-5 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="" method="POST" >
                            <div class="form-group">
                                <input type="text" name="person" class="form-control border-0 py-4" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <input type="email" name="mail" class="form-control border-0 py-4" placeholder="Your Email"
                                    required/>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" name="subcribe" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold">My-shop</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold">Ram</a><br>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>