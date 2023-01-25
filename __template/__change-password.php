<?php
$query="SELECT * FROM user WHERE username='$user1'";
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
        header("Location: otp-verify");
    }
}else{
    header("Location: index?user".base64_encode(strrev($user2)));
}