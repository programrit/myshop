<?php
include('../evomas/connect.php');
session_start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$msg=null;
$msg1=null;
if(isset($_POST["submit"])){
    $otp=$_POST["otp"];
    $sql1=mysqli_query($conn, "SELECT * FROM admin WHERE username='$_SESSION[username]'");
    $row1=mysqli_fetch_array($sql1);
    if($row1['active']==0){
        $sql2=mysqli_query($conn, "SELECT current_time_date FROM admin WHERE username='$_SESSION[username]'");
        $row2=mysqli_fetch_array($sql2);
        $times_ago=strtotime($row2['current_time_date']);
        $current_time=time();
        $time_different=$current_time- $times_ago;
        $seconds=$time_different;
        $minutes=round($seconds/60);
        if($minutes > 15){
            $sqli1="UPDATE admin SET active=2 WHERE username='$_SESSION[username]'";
            if($conn->query($sqli1)===true){
              $msg="Your OTP is expired!";
              header("refresh:3 url=login");
            }else{
              $msg="Something Wrong!";
              header("refresh:3 url=login");
            }
        }else if($minutes <= 15){
            $sql3=mysqli_query($conn, "SELECT otp FROM admin WHERE username='$_SESSION[username]'");
            $row3=mysqli_fetch_array($sql3);
            if($otp == $row3['otp']){
              $update="UPDATE admin SET active=1 WHERE username='$_SESSION[username]'";
              if($conn->query($update)===true){
                $_SESSION['otp']=$row3['otp'];
                $msg1="Correct OTP";
                header("refresh:3 url=index");
              }else{
                $msg="Something Wrong!";
                header("refresh:3 url=send_otp");
              }
            }else{
              $msg="Incorrect OTP";
              header("refresh:3 url=send_otp");
            }
        }else{
            $msg="Something Wrong!";
            header("refresh:3 url=send_otp");
        }
    }else if($row1['active']==1){
        $sql4=mysqli_query($conn, "SELECT otp FROM admin WHERE username='$_SESSION[username]'");
        $row4=mysqli_fetch_array($sql4);
        if($otp==$row4['otp']){
          $msg="Already use the otp change password again enter your email!";
          header("refresh:3 url=send_otp");
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/evomas/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Evomas</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    function preventback(){
      window.history.forward();
    }
    setTimeout("preventback()", 0);
    window.onunload=function(){ null };
  </script>
  </head>
  <body>
    <section class="vh-100">
  <div class="container-fluid h-custom py-2">
    <div class="row d-flex justify-content-center align-items-center h-50">
      <div class="col-md-9 col-lg-7 col-xl-6">
        <img src="/evomas/img/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-3  mx-auto">
      <div>
      <p class="error msg text-white text-center"><?php if(isset($msg)){?>
                        <div class="alert alert-danger text-center" role="alert"><?php echo $msg;?></div>
                   <?php  } ?></p>
                    <p class="error msg text-white text-center"><?php if(isset($msg1)){?>
                        <div class="alert alert-success text-center" role="alert"><?php echo $msg1;?></div>
                    <?php } ?></p>
      <form action="" method="POST" class="needs-validation" novalidate> 
      <h3 class="py-3 text-center">Enter OTP</h3>
          <div class="form-outline">
            <input type="number" name="otp" id="form3Example3" class="form-control"
              placeholder="Enter OTP" required />
              <div class="invalid-feedback">Enter Valid OTP</div>
            <label class="form-label" for="form3Example3"></label>
          </div>
          <div class="text-center text-lg-start pt-2 mt-2">
            <button type="submit" class="btn btn-primary" name="submit"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Submit</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div>
</section>
<script src="../js/validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
