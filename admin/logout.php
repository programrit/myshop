<?php
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}

if(admin_session::get('is_login')){
    $user1=admin_session::get('email');
    admin_session::destroy();
}else{
    header("Location:index?user=".base64_encode(strrev($user1)));
}
header("Location: login");
