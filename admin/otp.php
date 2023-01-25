<?php

include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if(isset($_GET["verify"])){
    $verify=$conn->real_escape_string($_GET["verify"]);
    $verified=htmlspecialchars($verify);
    $decode1=base64_decode($_GET["verify"]);
    $decode=$conn->real_escape_string($decode1);
    $decode=htmlspecialchars($decode);
    $reverse=strrev($decode);
    $query="SELECT * FROM admin_user WHERE phone='$reverse'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if($reverse==$row["phone"]){
        $msg=null;
        $msg1=null;
        if(isset($_POST["submit"])){
            $otps=$conn->real_escape_string($_POST["otp"]);
            $otp=htmlspecialchars($otps);
            date_default_timezone_set('Asia/Kolkata');
            $query1="SELECT * FROM admin_user WHERE phone='$reverse'";
            $result1=$conn->query($query1);
            $row1=$result1->fetch_assoc();
            if($row1["otp_verify"]==1){
                $times_ago=strtotime($row1["time"]);
                $current_time=date("Y:m:d H:i:s");
                $check_time =date("Y:m:d H:i:s",strtotime($row1["time"].'+15 minutes'));
                if($current_time>=$check_time){
                    $update="UPDATE admin_user SET otp_verify='2'  WHERE phone='$reverse'";
                    if($conn->query($update)==TRUE){
                        $msg1="OTP is expired! Please click resend otp button";
                        // header("refresh:2; url=otp-verify");
                    }else{
                        $msg1="Something went wrong.Please try again later!";
                        // header("refresh:2; url=otp-verify");
                    }
                }else{
                    if($otp==$row1["otp"]){
                        $updated="UPDATE admin_user SET otp_verify='3' WHERE phone='$reverse'";
                        if($conn->query($updated)==TRUE){
                            $msg="OTP verfication successfully!";
                            header("refresh:3; url=change-password?verify=".base64_encode(strrev($reverse)));
                        }else{
                            $msg1="Something went wrong.Please try again later!";
                            // header("refresh:2; url=otp-verify");
                        }
                    }else{
                        $msg1="Incorrect OTP!";
                            // header("refresh:2; url=otp-verify");
                       }
                }
            }else if($row["otp_verify"]==3){
                $msg1="This OTP is already used.Please click resend otp button";
                // header("refresh:2; url=otp-verify");
            }else if($row["otp_verify"]==2){
                $msg1="OTP is expired! Please click resend otp button";
                // header("refresh:2; url=otp-verify");
            }else{
                $msg1="You want to change password. click resend otp button";
                // header("refresh:2; url=otp-verify");
            }
        }
        if(isset($_POST["resend"])){
            $otp=rand(100000, 999999);
            $otps=strval($otp);
            // Account details
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://2factor.in/API/V1/YOUR_API_KEY/SMS/+91{$reverse}/{$otps}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            if($response){
                $update="UPDATE admin_user SET otp='$otps',otp_verify='1',time='$current_date_time' WHERE phone='$phone'";
                if($conn->query($update)===true){
                    $msg="OTP send successfully.Please check your mobile";
                    header("refresh:3; url=otp?verify=".base64_encode(strrev($reverse)));
                }else{
                    $msg1="Something went wrong. please try agin later!";
                }
            }else{
                $msg1="Something went wrong. please try agin later!";
            }
        }

        ?>
        <!DOCTYPE php>
        <html lang="en">
            <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                <meta name="description" content="" />
                <meta name="author" content="" />
                <title>Forget password</title>
                <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
                <link href="css/styles.css" rel="stylesheet" />
                <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
            </head>
            <body >
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        	    <!-- Navbar Brand-->
        	    <a class="navbar-brand ps-3"></a>
        	    <!-- Sidebar Toggle-->

                <div class="d-none d-md-inline-block form-inline mx-auto ms-auto me-0 me-md-3 my-2 my-md-0"></div>
            </nav>
            <div class="mt-5 form-control w-50 mx-auto h-75">
                <p class="error msg text-white"><?php if(isset($msg)){?>
                    <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
               <?php  } ?></p>
               <p class="error msg text-white"><?php if(isset($msg1)){?>
                    <div class="alert alert-danger text-center" role="alert"><?php echo $msg1;?></div>
               <?php  } ?></p>
                <h5 class="text-center mt-3">OTP verfication</h5><hr>
                <form action="" method="POST" class="needs-validation" novalidate>
                <div class="col-md-4 mx-auto mt-4">
                    <label for="">OTP</label>
                    <input class="form-control" name="otp" type="number" pattern="[0-9]{6}" required>
                </div>
                <div class="col-md-3 mx-auto mt-4">
                    <button class="btn btn-primary ml-5" name="submit" type="submit">Submit</button>
                    <button class="btn btn-danger" type="reset">Cancel</button>
                </div>
                </form>
                <form action="" method="POST">
                <div class="col-md-3 mx-auto ml-3">
                <button class="btn btn-info mx-auto" type="submit" name="resend">Resend otp</button>
                </div>
                </form>
            </div>
            
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="js/scripts.js"></script>
                <script src="../js/validate.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
                <script src="js/datatables-simple-demo.js"></script>
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
            </body>
        </html>
        
        

  <?php   }else{
    header("Location: forget-password");
  }
}else{
    header("Location: forget-password");
  }
?>

