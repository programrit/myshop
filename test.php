<?php

include('include/session.class.php');
include('include/user.class.php');
include('include/test.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();

$n=5;
$x=new test();
$x->s1($n);




// $result=null;
// $email="nisha@gmail.com";
// $password="Nisha123@";

// $result=user::login($email, $password);
// $result=null;
// if(isset($_GET['logout'])){
//     session::destroy();
//     die("session destroy <br><br><a href='logintest.php'>Login Again</a>");
// }

// if(session::get('is_token')){
//     $user=session::get('session_username');
//     print("Already login \n".$user->getUsername());
//     // print("\n".$user->getBio());
//     // $result=user::login($email, $password);
//     $result=$user;
// }else{
//     printf("No session found, trying to login!\n");
//     $result =user::login($email,$password);
//     if ($result) {
//         echo ("\nLogin Success\n".$result->getUsername());
//         echo user::authenticate($result->getUsername());
        
//         session::set('is_token',true);
//         session::set('session_username',$result);
        
//     } else {
//         echo "\nLogin Filed,$email";
//     }
// }