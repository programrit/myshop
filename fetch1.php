<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if (session::get('is_login')) {
    if(isset($_POST['product_id'],$_POST['size'])){
        $query=mysqli_query($conn,"SELECT * FROM mens_size WHERE size='$_POST[size]' AND product_id='$_POST[product_id]'");
        if($query->num_rows>0){
            while($row=$query->fetch_array(MYSQLI_ASSOC)){
                echo "$row[price]"; 
            }
        }else{
            $sql=mysqli_query($conn,"SELECT * FROM mens WHERE product_id='$_POST[product_id]'");
            $row1=$sql->fetch_array(MYSQLI_ASSOC);
            echo "$row1[price]"; 
        }
    }

}else{
    header("Location: login");
}