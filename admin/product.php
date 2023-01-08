<?php  
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
include('../include/product.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if(admin_session::get('is_login')){
    if(isset($_POST['category_id'])){
        $query="SELECT * FROM collections WHERE category_id='$_POST[category_id]'";
        $result=$conn->query($query);
        if($result->num_rows>0){
            echo "<select class='form-control' id='product_type' name='product_type' required>";
            echo " <option value='' selected disabled>Select product type</option>";
            while($row=$result->fetch_array(MYSQLI_ASSOC)){
                echo "<option value='$row[collection_name]'>$row[collection_name]</option>";
            }
        }else{
            echo "<option>No collection!</option>";
        }
    }
}