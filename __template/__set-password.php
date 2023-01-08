<?php
if(isset($_GET["email"])){
    $email_gets=$_GET["email"];
    $email_get=$conn->real_escape_string($email_gets);
    $email_get=htmlspecialchars($email_get);
    $decode=base64_decode($email_get);
    $reverse=strrev($decode);
    $email=$reverse;
    $query="SELECT * FROM user WHERE email='$email'";
    $result=$conn->query($query);
    $row=$result->fetch_assoc();
    if(isset($row["otp"])){
        if($row["otp_verify"]==3){?>
            <div class="col-md-12">
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="col-md-3 mx-auto mt-3">
                        <label for="">New Password</label>
                        <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" name="password" required class="form-control">
                        <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                        <label for="">Confirm Password</label>
                        <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" name="password1" required class="form-control">
                        <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                        <button class="btn btn-success mt-3 ml-5" name="reset_password" type="submit">Submit</button>
                        <button class="btn btn-danger mt-3" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        <?php }else{
            header("Location: otp-verfication?email=".base64_encode(strrev($email)));
        }
    }else{
        header("Location: email-verfication");
    }
}else{
    header("Location: email-verfication");
}