<?php
class admin{
    private $conn;

    public function __call($name, $argument)
    {
        $property=preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property=strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));
        if (substr($name, 0, 3)=="get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3)=="set") {
            return $this->_set_data($name, $argument[0]);
        } else {
            throw new Exception("user::__call()->$name,function unavailble");
        }
    }

    public static function admin_users($email,$password){
        $conn = DB::db();
        $query="SELECT * FROM admin_user WHERE email='$email'";
        $result=$conn->query($query);
        if ($result->num_rows ==1) {
            $row=$result->fetch_assoc();
            if($password==$row['password']){
                return new admin($row['email'],['password']);
            } else {
                header("Location: login.php?exist=Please enter correct password!");
                echo"<script>window.location.href='/my-shop/admin/login.php'</script>";
                return false;
            }
        }else{
            header("Location: login.php?exist=Please enter correct email!");
            echo"<script>window.location.href='/my-shop/admin/login.php'</script>";
        }
    }
    public function __construct($email){
        $this->email=$email;
        $this->conn=DB::db();
        $sql="SELECT id FROM admin_user WHERE email='$email'";
        $result=$this->conn->query($sql);
        if ($result->num_rows>0) {
            while ($row=$result->fetch_assoc()) {
                $this->id=$row["id"];
            }
        } else {
            throw new Exception("User not found!");
        }
    }
    public function getEmail(){
        return $this->email;
    }
    public static function authenticate(){

    }
    public static function signup($username,$email,$phone,$password,$password1){
        $conn = DB::db();
        $option=[
            'cost'=>8,
        ];
        $password=password_hash($password, PASSWORD_BCRYPT, $option);
        $password1=password_hash($password1, PASSWORD_BCRYPT, $option);
        $sqli=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
        $sqli1=mysqli_query($conn, "SELECT * FROM user WHERE phone='$phone'");
        $sqli2=mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
        if(mysqli_num_rows($sqli)>0){
            header("Location: add-user?exist=$username already exist");
            echo"<script>window.location.href='/my-shop/admin/add-user'</script>";
        }else if(mysqli_num_rows($sqli1)>0){
            header("Location: add-user?exist=$phone already exist");
            echo"<script>window.location.href='/my-shop/admin/add-user'</script>";
        }
        else if(mysqli_num_rows($sqli2)>0){
            header("Location: add-user?exist=$email already exist");
            echo"<script>window.location.href='/my-shop/admin/add-user'</script>";
        }
        else{
            $insert="INSERT INTO user (username,email,phone,password,cofirm_password) VALUES ('$username','$email','$phone','$password','$password1')";
            if($conn->query($insert)===TRUE){
                $user=true;
            }else{
                $user=false;
                $user=$conn->error;
            }
        }
        return $user;
    }
    public static function update($id,$username,$email,$phone){
        $conn = DB::db();
        $select1=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
        $select2=mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
        $select3=mysqli_query($conn,"SELECT * FROM user WHERE phone='$phone'");
        if(mysqli_num_rows($select1)>0){

        }else{
            $update1=mysqli_query($conn,"UPDATE user SET username='$username' WHERE id='$id'");
            $user=true;
        }if(mysqli_num_rows($select2)>0){

        }else{
            $update2=mysqli_query($conn,"UPDATE user SET email='$email' WHERE id='$id'");
            $user=true;
        }
        if(mysqli_num_rows($select3)>0){

        }else{
            $update3=mysqli_query($conn,"UPDATE user SET phone='$phone' WHERE id='$id'");
            $user=true;
        }
        return $user;

    }
    public static function delete($id){
        $conn = DB::db();
        $update="DELETE FROM user WHERE id='$id'";
        if($conn->query($update)===TRUE){
                $user=true;
        }else{
                $user=false;
                $user=$conn->error;
        }
        return $user;

    }
    public static function mens($type,$name,$data,$color,$description,$information){
        $conn = DB::db();
        $sqli=mysqli_query($conn,"SELECT * FROM mens WHERE product_name='$name'");
        if(mysqli_num_rows($sqli)>0){
            header("Location: add-men?exist=$name already exist");
            echo"<script>window.location.href='/my-shop/admin/add-men'</script>";
        }else{
            $insert="INSERT INTO mens (product_type,product_name,product_img,color,description,information) VALUES ('$type','$name','$data','$color','$description','$information')";
            if($conn->query($insert)===TRUE){
                $men=true;
            }else{
                $men=false;
                $men=$conn->error;
            }
        }

    }
    public static function add_admin($email, $phone, $password){
        $conn = DB::db();
        $sqli1=mysqli_query($conn, "SELECT * FROM admin_user WHERE phone='$phone'");
        $sqli2=mysqli_query($conn,"SELECT * FROM admin_user WHERE email='$email'");
        if(mysqli_num_rows($sqli1)>0){
            header("Location: add-admin?exist=$phone already exist");
            echo"<script>window.location.href='/my-shop/admin/add-admin'</script>";
            $admin=false;
        }
        else if(mysqli_num_rows($sqli2)>0){
            header("Location: add-admin?exist=$email already exist");
            echo"<script>window.location.href='/my-shop/admin/add-admin'</script>";
            $admin=false;
        }else{
            $insert="INSERT INTO admin_user (email,password,phone) VALUES('$email','$password','$phone')";
            if($conn->query($insert)===TRUE){
                $admin=true;
            }else{
                $admin=false;
                $admin=$conn->error;
            }
        }
        return $admin;
    }
    public static function admin_update($id,$phone){
        $conn = DB::db();
        $update="UPDATE admin_user SET phone='$phone' WHERE id='$id'";
        if($conn->query($update)===TRUE){
            $admin=true;
        }else{
            $admin=false;
            $admin=$conn->error;
        }
        return $admin;
    }
    public static function admin_delete($id){
        $conn = DB::db();
        $update="DELETE FROM admin_user WHERE id='$id'";
        if($conn->query($update)===TRUE){
                $user=true;
        }else{
                $user=false;
                $user=$conn->error;
        }
        return $user;

    }
    public static function profile_update($id,$img){
        $conn = DB::db();
        $update="UPDATE admin_user SET profile='$img' WHERE id='$id'";
        if($conn->query($update)===TRUE){
            $profile=true;
        }else{
                $profile=false;
                $profile=$conn->error;
        }
        return $profile;
    }
    public static function update_password($username, $new){
        $conn = DB::db();
        $update="UPDATE admin_user SET password='$new' WHERE email='$username'";
        if($conn->query($update)===TRUE){
            $change=true;
        }else{
                $change=false;
                $change=$conn->error;
        }
        return $change;
    }
}





























