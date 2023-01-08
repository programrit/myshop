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
    $decodes=base64_decode($_GET["verify"]);
    $decode=$conn->real_escape_string($decodes);
    $decode=htmlspecialchars($decode);
    $reverse=strrev($decode);
    $query="SELECT * FROM admin_user WHERE phone='$reverse'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if(isset($row["otp"])){
        if($row["otp_verify"]==3){
            $msg=null;
            $msg1=null;      
            if(isset($_POST["submit"])){
                $password1=$conn->real_escape_string($_POST["password"]);
                $password=htmlspecialchars($password1);
                $update="UPDATE admin_user SET password='$password' WHERE phone='$reverse'";
                if($conn->query($update)===TRUE){
                    $msg="Password change successfully!";
                    header("refresh:3; url=login");
                }else{
                    $msg1="Something went wrong. please try again later!";
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
                <div class="mt-5 form-control w-50 mx-auto h-50">
                    <p class="error msg text-white"><?php if(isset($msg)){?>
                        <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
                   <?php  } ?></p>
                   <p class="error msg text-white"><?php if(isset($msg1)){?>
                        <div class="alert alert-danger text-center" role="alert"><?php echo $msg1;?></div>
                   <?php  } ?></p>
                    <h5 class="text-center mt-3">Forget password</h5><hr>
                    <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="col-md-4 mx-auto mt-4">
                        <label for="">password</label>
                        <input class="form-control" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" type="text"  required>
                   </div>
                    <div class="col-md-3 mx-auto mt-4">
                        <button class="btn btn-primary ml-5" name="submit" type="submit">Submit</button>
                        <button class="btn btn-danger" type="reset">Cancel</button>
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
            
            
            
    <?php }else{
            header("Location: forget-password");
        }
    }else{
        header("Location: login");
    }
}else{
    header("Location: forget-password");
}

