<?php

class collection{
    private $conn;

    public static function cart($user,$id1,$name,$img,$size,$price,$quantity,$color,$total){
        $conn = DB::db();
        $sql=mysqli_query($conn, "SELECT * FROM cart WHERE product_id='$id1' AND size='$size' AND user_id='$user' AND active='0'");
        $sql1=mysqli_query($conn, "SELECT * FROM cart WHERE product_id='$id1' AND size='$size' AND user_id='$user' AND active='1'");
        if(mysqli_num_rows($sql)>0){
            echo"<script>alert('This product already add to cart. Please check you cart!')</script>";
            header("refresh:1; url=cart");
            $cart=false;
        }else if(mysqli_num_rows($sql1)){
            echo"<script>alert('This product already order placed. Please check you order!')</script>";
            header("refresh:1; url=order");
            $cart=false;
        }else{
            $insert="INSERT INTO cart (user_id,product_id,product_name,product_img,size,quantity,price,color,total) VALUES('$user','$id1','$name','$img','$size','$quantity','$price','$color','$total')";
            if($conn->query($insert)===TRUE){
                $cart=true;
            }else{
                $cart=false;
                $cart=$conn->error;
            }
        }
        return $cart;  
    }
    public static function remove($id){
        $conn = DB::db();
        $remove="DELETE FROM cart WHERE id='$id'";
        if($conn->query($remove)===TRUE){
            $del=true;
        }else{
            $del=false;
            $del=$conn->error;
        }
        return $del;
    }
    public static function order($id,$name,$phone,$address,$delivery,$product_id,$product_name,$img,$color,$size,$quantity,$price){
        $conn = DB::db();
        $status1="confirm";
        $status2="pending";
        $query="SELECT * FROM checkout WHERE user_id='$id' AND product_id='$product_id' AND size='$size' AND status='$status2' OR status='$status1'";
        $result=$conn->query($query);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        if($result->num_rows>0){
            echo"<script>alert('This product already placed in order please check your order list!')</script>";
            // header("refresh:1; url=order");
            $order=false;
        }else{
            $insert="INSERT INTO checkout (user_id,name,phone,address,delivery,product_id,product_name,product_img,size,quantity,color,price,time) VALUES('$id','$name','$phone','$address','$delivery','$product_id','$product_name','$img','$size','$quantity','$color','$price','$current_date')";
            if($conn->query($insert)===TRUE){
                $update="DELETE FROM cart WHERE user_id='$id' AND product_id='$product_id' AND size='$size'";
                if($conn->query($update)===TRUE){
                    $order=true;
                }else{
                    $order=false;
                    $order=$conn->error;
                }
            }else{
                $order=false;
                $order=$conn->error;
            }
        }
        return $order;
    }
    public static function remove_order($id){
        $conn = DB::db();
        $remove="UPDATE checkout SET status='cancel' WHERE id='$id'";
        if($conn->query($remove)===TRUE){
            $del=true;
        }else{
            $del=false;
            $del=$conn->error;
        }
        return $del;
    }
    public static function checkout($user_id,$name,$phone,$address,$delivery,$product_id,$product_name,$img,$color,$size,$quantity,$total){
        $conn = DB::db();
        $status1="confirm";
        $status2="pending";
        $query="SELECT * FROM checkout WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND status='$status2' OR status='$status1'";
        $result=$conn->query($query);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d");
        if($result->num_rows>0){
            echo"<script>alert('This product already placed in order please check your order list!')</script>";
            header("refresh:1; url=order");
            $check=false;
        }else{
            $insert="INSERT INTO checkout (user_id,name,phone,address,delivery,product_id,product_name,product_img,size,quantity,color,price,time) VALUES('$user_id','$name','$phone','$address','$delivery','$product_id','$product_name','$img','$size','$quantity','$color','$total','$current_date')";
            if($conn->query($insert)===TRUE){
                $update="DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size'";
                if($conn->query($update)===TRUE){
                    $check=true;
                }else{
                    $check=false;
                    $check=$conn->error;
                }
            }else{
                $check=false;
                $check=$conn->error;
            }
                    
                
        }
        return $check;
    }
    public static function review($id, $product_id, $product_name, $name, $rate, $message){
        $conn = DB::db();
        $check="SELECT * FROM review WHERE user_id='$id' AND product_id='$product_id'";
        $verfy=$conn->query($check);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        if($verfy->num_rows>0){
            echo "<script>alert('Review and ratings already exist!')</script>";
            header("refresh:1; url=detail?id=".base64_encode($product_id));
            $review=false;
        }else{
            $sql="INSERT INTO review (user_id,product_id,product_name,rating,name,message,date) VALUES('$id','$product_id','$product_name','$rate','$name','$message','$current_date')";
            if($conn->query($sql)===TRUE){
                $review=true;
            }else{
                $review=false;
                $review=$conn->error; 
            }
        }
        return $review;
    }
}