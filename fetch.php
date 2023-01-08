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
                echo "<input type='number' name='quantity' class='form-control bg-secondary text-center' id='quantity' min='1' value='1' max='$row[quantity]'>";
            }
        }else{
            echo "<input type='number' name='quantity' class='form-control bg-secondary text-center' id='quantity' min='1' value='1' max='1'>";
        }
    }

}else{
    header("Location: login");
}



