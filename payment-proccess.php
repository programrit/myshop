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
    isset($_POST["username"]) && isset($_POST["phone"]) && isset($_POST["address"]) && isset($_POST["id"])){
        $delivery=$_POST["razorpay_payment_id"];
        $total=$_POST["totalAmount"];
        $name=$_POST["username"];
        $phone=$_POST["phone"];
        $address=$_POST["address"];
        $id=$_POST["id"];
        $order_id="ORDER_".rand(1111,9999).substr($phone,8);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        $sql=mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$id'");
        while($row=mysqli_fetch_array($sql)){
            $product_id=$row["product_id"];
            $size=$row["size"];
            $product_name=$row["product_name"];
            $quantity=$row["quantity"];
            $img=$row["product_img"];
            $price=$row["price"];
            $total=$row["total"];
            $status1="confirm";
            $status2="pending";
            $status3="remove";
            $color=$row["color"];
            $check=mysqli_query($conn,"SELECT * FROM checkout WHERE user_id='$id' AND product_id IN('$product_id') AND size IN('$size') AND (status='$status2' OR status='$status1' OR status='$status3')");
            if($check->num_rows>0){
                $arr=array('msg'=>'Product already place order. your amount is return with in days!','status'=>false);
                echo json_encode($arr);
                exit();
            }else{
                $sql1=mysqli_query($conn,"SELECT quantity FROM mens_size WHERE  product_id IN('$product_id') AND size IN('$size')");
                $get=mysqli_fetch_array($sql1);
                $qty=$get["quantity"]-$quantity;
                $change=mysqli_query($conn,"UPDATE mens_size SET quantity='$qty' WHERE  product_id IN('$product_id') AND size IN('$size')");
                if($change===true){
                    $insert=mysqli_query($conn,"INSERT INTO checkout (order_id,user_id,product_id,product_name,product_img,size,quantity,color,price) VALUES ('$order_id','$id','$product_id','$product_name','$img','$size','$quantity','$color','$total')");
                    if($insert===true){
                        $del=mysqli_query($conn,"DELETE FROM cart WHERE user_id='$id' AND  product_id IN('$product_id') AND size IN('$size')");
                        if($del===TRUE){
                            // $arr=array('msg'=>'Payment successfully!','status'=>true);
                            // echo json_encode($arr);
                        }else{
                            $arr=array('msg'=>'Something went wrong. please try again later!','status'=>true);
                            echo json_encode($arr);
                        }
                    }else{
                        $arr=array('msg'=>'Something went wrong. please try again later!','status'=>true);
                        echo json_encode($arr);
                    }
                }else{
                    $arr=array('msg'=>'Something went wrong. please try again later!','status'=>true);
                    echo json_encode($arr);
                }               
            }
        }
        $query=mysqli_query($conn,"INSERT INTO orders (user_id,order_id,name,phone,address,delivery,time) VALUES ('$id','$order_id','$name','$phone','$address','$delivery','$current_date')");
        if($query===true){  
            $arr=array('msg'=>'Payment successfully!','status'=>true);
            echo json_encode($arr);
        }else{
            $arr=array('msg'=>'Something went wrong. please try again later!','status'=>true);
            echo json_encode($arr);
        }
    }
}else{
    header("Location: login");
}
?>

   
   