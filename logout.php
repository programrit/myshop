<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}

if(session::get('is_login')){
    $user1=session::get('username');
    $user2=session::get('id');
    $sql="SELECT * FROM user WHERE username='$user1'";
    $result=$conn->query($sql);
    $row=$result->fetch_array(MYSQLI_ASSOC);
    if($row['active']==1){
        $query1="UPDATE user SET active='0' WHERE username='$user1'";
        if($conn->query($query1)===TRUE){
            $update=true;
        }else{
            $update=false;
            $update=$conn->error;
        }
        session::destroy();
    }else{
        $update=false;
    }
    header("Location: login");
}else{
    header("Location:index?user=".base64_encode(strrev($user2)));
}




