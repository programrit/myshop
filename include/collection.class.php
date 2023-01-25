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
    public static function order($id,$name,$phone,$address,$delivery,$product_id,$size){
        $conn = DB::db();
        $status1="confirm";
        $status2="pending";
        $status3="remove";
        $order_id="ORDER_".rand(1111,9999).substr($phone,8);
        $product_id=explode(",",$product_id);
        $product_id=implode("','",$product_id);
        $size=explode(",",$size);
        $size=implode("','",$size);
        $query="SELECT * FROM checkout WHERE user_id='$id' AND product_id IN('$product_id') AND size IN('$size') AND (status='$status2' OR status='$status1' OR status='$status3')";
        echo $query;
        $result=$conn->query($query);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        if($result->num_rows>0){
            echo"<script>alert('This product already placed in order please check your order list!')</script>";
            header("refresh:1; url=order");
            $order=false;
        }else{
            $place="INSERT INTO orders (user_id,order_id,name,phone,address,delivery,time) VALUES('$id','$order_id','$name','$phone','$address','$delivery','$current_date')";
            if($conn->query($place)===TRUE){
                $sql=mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$id'");
                while($res=mysqli_fetch_array($sql)){
                    $product_id1=$res["product_id"];
                    $product_name=$res["product_name"];
                    $img=$res["product_img"];
                    $size1=$res["size"];
                    $quantity=$res["quantity"];
                    $color=$res["color"];
                    $total=$res["total"];
                    $insert="INSERT INTO checkout (order_id,user_id,product_id,product_name,product_img,size,quantity,color,price) VALUES ('$order_id','$id','$product_id1','$product_name','$img','$size1','$quantity','$color','$total')";
                    if($conn->query($insert)===true){
                        $update="DELETE FROM cart WHERE user_id='$id' AND product_id='$product_id1' AND size='$size1'";
                        if($conn->query($update)===TRUE){
                            $sql1=mysqli_query($conn,"SELECT quantity FROM mens_size WHERE product_id='$product_id1' AND size='$size1'");
                            $get=mysqli_fetch_array($sql1);
                            $qty=$get["quantity"]-$quantity;
                            $change=mysqli_query($conn,"UPDATE mens_size SET quantity='$qty' WHERE product_id='$product_id1' AND size='$size1'");
                            if($change===true){
                                $del=mysqli_query($conn,"DELETE FROM cart WHERE user_id='$id' AND  product_id IN('$product_id') AND size IN('$size')");
                                if($del===TRUE){
                                    $order=true;
                                }else{
                                    $order=false;
                                    $order=$conn->error;
                                }
                            }else{
                                $order=false;
                                $order=$conn->error;
                            }
                        }else{
                            $order=false;
                            $order=$conn->error;
                        }
                    }
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
        $get=mysqli_query($conn,"SELECT * FROM checkout WHERE id='$id'");
        $fetch=mysqli_fetch_array($get);
        $product_id=$fetch["product_id"];
        $size=$fetch["size"];
        $quantity=$fetch["quantity"];
        $sql=mysqli_query($conn,"SELECT quantity FROM mens_size WHERE product_id='$product_id' AND size='$size'");
        $result=mysqli_fetch_array($sql);
        $quantity1=$result["quantity"];
        $qty=$quantity+$quantity1;
        $update=mysqli_query($conn,"UPDATE mens_size SET quantity='$qty' WHERE product_id='$product_id' AND size='$size'");
        if($update===true){
            $remove="UPDATE checkout SET status='remove' WHERE id='$id'";
            if($conn->query($remove)===TRUE){
                $del=true;
            }else{
                $del=false;
                $del=$conn->error;
            }
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
        $status3="remove";
        $order_id="ORDER_".rand(1111,9999).substr($phone,8);
        $query="SELECT * FROM checkout WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND (status='$status2' OR status='$status1' OR status='$status3')";
        $result=$conn->query($query);
        date_default_timezone_set('Asia/Kolkata');
        $current_date=date("Y/m/d H:i:s");
        if($result->num_rows>0){
            echo"<script>alert('This product already placed in order please check your order list!')</script>";
            header("refresh:1; url=order");
            $check=false;
        }else{
            $place="INSERT INTO orders (user_id,order_id,name,phone,address,delivery,time) VALUES('$user_id','$order_id','$name','$phone','$address','$delivery','$current_date')";
            if($conn->query($place)===TRUE){
                $insert="INSERT INTO checkout (order_id,user_id,product_id,product_name,product_img,size,quantity,color,price) VALUES('$order_id','$user_id','$product_id','$product_name','$img','$size','$quantity','$color','$total')";
                if($conn->query($insert)===TRUE){     
                    $update="DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size'";
                    if($conn->query($update)===TRUE){
                        $sql=mysqli_query($conn,"SELECT quantity FROM mens_size WHERE product_id='$product_id' AND size='$size'");
                        $get=mysqli_fetch_array($sql);
                        $qty=$get["quantity"]-$quantity;
                        $change=mysqli_query($conn,"UPDATE mens_size SET quantity='$qty' WHERE product_id='$product_id' AND size='$size'");
                        if($change===true){
                            $check=true;
                        }else{
                            $check=false;
                            $check=$conn->error;
                        }
                    }else{
                        $check=false;
                        $check=$conn->error;
                    }
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