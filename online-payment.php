<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
include('include/collection.class.php');
$conn = DB::db();
session::start();
if (session_status() === PHP_SESSION_NONE) {
    echo "<script>alert('Session not start')</script>";
}
if (session::get('is_login')) {
    $user1 = session::get('username');
    $user2=session::get('id');
    if(isset($_POST["razorpay_payment_id"]) && isset($_POST["totalAmount"]) && isset($_POST["username"])&&
    isset($_POST["phone"]) && isset($_POST["address"]) && isset($_POST["product_id"])&& isset($_POST["product_name"]) 
    && isset($_POST["img"]) && isset($_POST["size"]) && isset($_POST["quantity"])&& isset($_POST["color"])
     && isset($_POST["price"])){
        $sql=mysqli_query($conn,"SELECT * FROM user WHERE username='$user1'");
        $row=mysqli_fetch_array($sql);
        $user_id=$row["id"];
        $delivery=$_POST["razorpay_payment_id"];
        $total=$_POST["totalAmount"];
        $name=$_POST["username"];
        $phone=$_POST["phone"];
        $address=$_POST["address"];
        $product_id=$_POST["product_id"];
        $size=$_POST["size"];
        $product_name=$_POST["product_name"];
        $img=$_POST["img"];
        $quantity=$_POST["quantity"];
        $price=$_POST["price"];
        $color=$_POST["color"];
        $status1="confirm";
        $status2="pending";
        $status3="remove";
        $order_id="ORDER_".rand(1111,9999).substr($phone,8);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        $query="SELECT * FROM checkout WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND (status='$status2' OR status='$status1' OR status='$status3')";
        $result=$conn->query($query);
        if($result->num_rows>0){
            $arr=array('msg'=>'This product already placed in order please check your order list. amount is return with in days!','status'=>false);
            echo json_encode($arr);
            exit();
        }else{
            $place="INSERT INTO orders (user_id,order_id,name,phone,address,delivery,time) VALUES('$user_id','$order_id','$name','$phone','$address','$delivery','$current_date')";
            if($conn->query($place)===TRUE){
                $insert="INSERT INTO checkout (order_id,user_id,product_id,product_name,product_img,size,quantity,color,price) VALUES('$order_id','$user_id','$product_id','$product_name','$img','$size','$quantity','$color','$price')";
                if($conn->query($insert)===TRUE){     
                    $update="DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size'";
                    if($conn->query($update)===TRUE){
                        $sql=mysqli_query($conn,"SELECT quantity FROM mens_size WHERE product_id='$product_id' AND size='$size'");
                        $get=mysqli_fetch_array($sql);
                        $qty=$get["quantity"]-$quantity;
                        $change=mysqli_query($conn,"UPDATE mens_size SET quantity='$qty' WHERE product_id='$product_id' AND size='$size'");
                        if($change===true){
                            $arr=array('msg'=>'Payment successfully!','status'=>true);
                            echo json_encode($arr);
                        }else{
                            $arr=array('msg'=>'Something went wrong. please try again later','status'=>false);
                            echo json_encode($arr);
                        }
                    }else{
                        $arr=array('msg'=>'Something went wrong. please try again later','status'=>false);
                        echo json_encode($arr);
                    }
                }else{
                    $arr=array('msg'=>'Something went wrong. please try again later','status'=>false);
                    echo json_encode($arr);
                }
                    
            }else{
                $arr=array('msg'=>'Something went wrong. please try again later','status'=>false);
                echo json_encode($arr);
            }    
        }
    }
}else{
    header("Location: index?user=".base64_encode(strrev($user2)));
}
?>
   
   