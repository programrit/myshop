<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
session::start();
$conn=DB::db();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
    session::start();
}
if(isset($_GET["token"])){
    $token_get=$_GET["token"];
    $token=$conn->real_escape_string($token_get);
    $token=htmlspecialchars($token);
    $verify="SELECT token,active_token,active_time FROM user WHERE token='$token' LIMIT 1";
    $result=$conn->query($verify);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        if($token==$row["token"]){
            if($row["active_token"]=='0'){
                $times_ago=strtotime($row["active_time"]);
                $current_time=date("Y:m:d H:i:s");
                $check_time =date("Y:m:d H:i:s",strtotime($row["active_time"].'+15 minutes'));
                if($current_time>=$check_time){
                    $delete="DELETE FROM user WHERE token='$token'";
                    if($conn->query($delete)===TRUE){
                        echo "<script>alert('Your token has been expired! please again register!')</script>";
                        header("refresh:1; url=signup"); 
                    }else{
                        echo "<script>alert('Something went wrong. try again or click link again!')</script>";
                        header("refresh:1; url=login"); 
                    }
                }else{
                    $click=$row["token"];
                    $updated="UPDATE user SET active_token='1' WHERE token='$click'";
                    if($conn->query($updated)===TRUE){
                        echo "<script>alert('Your account has been verified successfully!')</script>";
                        header("refresh:1; url=login"); 
                    }else{
                        echo "<script>alert('verfication failed. Please try again later!')</script>";
                        header("refresh:1; url=login");
                    }
                }
            }else{
                $update="";
                echo "<script>alert('Email already verify. please login!')</script>";
                header("refresh:1; url=login");
            }

        }else{
            echo "<script>alert('This token dosn't exist!')</script>";
            header("refresh:1; url=login");
        }
    }else{
        echo "<script>alert('This token dosn't exist!')</script>";
        header("refresh:1; url=login");
    }

}else{
    echo "<script>alert('Something went wrong. please check your email or try again later!')</script>";
    header("refresh:1; url=login");
}

