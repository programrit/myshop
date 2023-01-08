<?php

class product{
    private $conn;
    public static function mens($category,$type,$name,$data,$color,$mrp,$price,$description,$information,$active){
        $conn = DB::db();
        $set="SELECT * FROM category WHERE id='$category'";
        $result=$conn->query($set);
        $row=$result->fetch_array(MYSQLI_ASSOC);
        $category_name=$row['category'];
        $sqli=mysqli_query($conn,"SELECT * FROM mens WHERE product_name='$name' AND category='$category_name'");
        $sqli1=mysqli_query($conn,"SELECT * FROM mens WHERE product_img='$data'");
        if(mysqli_num_rows($sqli)>0){
            header("Location: add-men?exist= $name already exist");
            echo"<script>window.location.href='/my-shop/admin/add-men'</script>";
        }else if(mysqli_num_rows($sqli1)>0){
            header("Location: add-men?exist= $data already exist");
            echo"<script>window.location.href='/my-shop/admin/add-men'</script>";
        }else{
            $insert="INSERT INTO mens (category,product_type,product_name,product_img,color,mrp,price,description,information,active) VALUES ('$category_name','$type','$name','$data','$color','$mrp',$price,'$description','$information','$active')";
            if($conn->query($insert)===TRUE){
                $men=$data;
            }else{
                $men=false;
                $men=$conn->error;
            }
        }
        return $men;
    }
    public static function size($id,$category,$type,$product_id,$size,$quantity,$mrp,$price,$active){
        $conn = DB::db();
        $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$id'");
        $row=mysqli_fetch_array($sql);
        $sql1=mysqli_query($conn, "SELECT * FROM mens_size WHERE product_id='$row[product_id]' AND size='$size'");
        if(mysqli_num_rows($sql1)>0){
            echo"<script>alert('size $size is already exist')</script>";
            header("refresh:1; url=men-size?id=".base64_encode($product_id));
        }else{
            $insert="INSERT INTO mens_size (product_id,category,product_type,size,quantity,mrp,price,active) VALUES ('$product_id','$category','$type','$size','$quantity','$mrp','$price',$active)";
            if($conn->query($insert)===TRUE){
                $add=true;
            }else{
                $add=false;
                $add=$conn->error;
            }
        }
        return $add;
    }
    public static function update($id1,$name,$data,$mrp,$price,$description,$information,$active){
        $conn = DB::db();
        $update="UPDATE mens SET product_name='$name',product_img='$data',mrp='$mrp',price='$price',description='$description',information='$information', active='$active' WHERE product_id='$id1'";
        if($conn->query($update)===TRUE){
                $men=true;
        }else{
                $men=false;
                $men=$conn->error;
        }
        return $men;
    }
    public static function size_update($id1,$sizes,$quantity,$mrp,$price,$active){
        $conn = DB::db();
        $update="UPDATE mens_size SET quantity='$quantity',mrp='$mrp',price='$price',active='$active' WHERE id='$id1' AND size='$sizes'";
        if($conn->query($update)===TRUE){
            $men=true;
        }else{
            $men=false;
            $men=$conn->error;
        }
        return $men;
    }
    public static function men_delete($id){
        $conn = DB::db();
        $query=mysqli_query($conn, "SELECT * FROM mens_size WHERE product_id='$id'");
        $fetch=mysqli_fetch_array($query);
        if($fetch['product_id']){
            echo"<script>alert('You cannot delete this product. Because the product size & price is not deleted')</script>";
            header("refresh:1; url=mens");
        }else{
            $delete="DELETE FROM mens WHERE product_id='$id'";
            if($conn->query($delete)===TRUE){
                $del=true;
            }else{
                $del=false;
                $del=$conn->error;
            }
        }
        return $del;
    }
    public static function men_size_delete($id,$size){
        $conn = DB::db();
        $delete="DELETE FROM mens_size WHERE id='$id' AND size='$size'";
        if($conn->query($delete)===TRUE){
            $del=true;
        }else{
            $del=false;
            $del=$conn->error;
        }
        return $del;
    }
    public static function order_update($id,$status){
        $conn = DB::db();
        $update="UPDATE checkout SET status='$status' WHERE id='$id'";
        if($conn->query($update)===TRUE){
                $order=true;
        }else{
                $order=false;
                $order=$conn->error;
        }
        return $order;
    }
    public static function order_delete($id){
        $conn = DB::db();
        $delete="DELETE FROM checkout WHERE id='$id'";
        if($conn->query($delete)===TRUE){
            $del=true;
        }else{
            $del=false;
            $del=$conn->error;
        }
        return $del;
    }
}

