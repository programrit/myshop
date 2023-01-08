<?php

include('../include/admin_session.class.php');
include('../include/databse.class.php');
include('../include/admin.class.php');
include('../include/product.class.php');
$conn=DB::db();
admin_session::start();

echo admin_session::isset('image');

// $result=null;
// $type="T-shirt";
// $name="black t-shirt";
// $data="black.jpeg ";
// $color="black";
// $description="good ";
// $information="nice ";

// $result=product::mens($type,$name,$data,$color,$description,$information);
// $result=null;
// if(isset($_GET['logout'])){
//     admin_session::destroy();
//     die("admin_session destroy <br><br><a href='logintest.php'>Login Again</a>");
// }

// if(admin_session::get('is_token')){
//     $user=admin_session::get('session_username');
//     print("Already login \n".$user->getEmail());
//     // print("\n".$user->getBio());
//     // $result=user::login($email, $password);
//     $result=$user;
// }else{
//     printf("No admin_session found, trying to login!\n");
//     $result=product::mens($type,$name,$data,$color,$description,$information);
//     if ($result) {
//         echo ("\nLogin Success\n");
//         echo admin::authenticate();
        
//         admin_session::set('is_token',true);
//         admin_session::set('session_username',$result);
        
//     } else {
//         echo "\nLogin Filed";
//     }
// }