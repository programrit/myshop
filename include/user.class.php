<?php
class user{
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

    public static function signup($username,$email,$phone,$password,$password1,$token){
        $conn = DB::db();
        $option=[
            'cost'=>8,
        ];
        $password=password_hash($password, PASSWORD_BCRYPT, $option);
        $password1=password_hash($password1, PASSWORD_BCRYPT, $option);
        $sqli=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
        $sqli1=mysqli_query($conn, "SELECT * FROM user WHERE phone='$phone'");
        $sqli2=mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
        date_default_timezone_set('Asia/Kolkata');
        $current_date_time=date("Y:m:d H:i:s");
        if(mysqli_num_rows($sqli)>0){
            header("Location: signup.php?exist=$username already exist");
            echo"<script>window.location.href='/my-shop/signup'</script>";
            $user=false;
        }else if(mysqli_num_rows($sqli1)>0){
            header("Location: signup.php?exist=$phone already exist");
            echo"<script>window.location.href='/my-shop/signup'</script>";
            $user=false;
        }
        else if(mysqli_num_rows($sqli2)>0){
            header("Location: signup.php?exist=$email already exist");
            echo"<script>window.location.href='/my-shop/signup'</script>";
            $user=false;
        }
        else{
            $insert="INSERT INTO user (username,email,phone,password,cofirm_password,token,active_token,active_time) VALUES ('$username','$email','$phone','$password','$password1','$token','0','$current_date_time')";
            if($conn->query($insert)===TRUE){
                $user=true;
            }else{
                $user=false;
                $user=$conn->error;
            }
        }
        return $user;
    }
    public static function login($email,$password){
        $conn = DB::db();
        $query="SELECT * FROM user WHERE email='$email'";
        $result=$conn->query($query);
        if ($result->num_rows ==1) {
            $row=$result->fetch_assoc();
            // if($row['password']==$password){
            if (password_verify($password, $row['password'])) {
                $user= $row['username'];
                return new user($row['username'],['email']);
            }
            else {
                header("Location: login?exist=Please enter correct password!");
                echo"<script>window.location.href='/my-shop/login.php'</script>";
                return false;
            }
        }else{
            header("Location: login?exist=Please enter correct email or not user signup after login!");
            echo"<script>window.location.href='/my-shop/login.php'</script>";
        }
    }
    public static function update($active,$username){
        $conn = DB::db();
        $sqli=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
        $result1=mysqli_fetch_array($sqli);
        $get=$result1['active'];
        if($get==0){
            $query1="UPDATE user SET active='$active' WHERE username='$username'";
            if($conn->query($query1)===TRUE){
                $update=true;
            }else{
                $update=false;
                $update=$conn->error;
            }
        }else{
            $update=true;
        }
        return $update;
    }
    public static function profile($id,$name,$date_of_birth,$address,$avatar){
        $conn = DB::db();
        $select="SELECT * FROM profile WHERE user_id='$id'";
        $selected=$conn->query($select);
        $select1="SELECT * FROM user WHERE id='$id'";
        $selected1=$conn->query($select1);
        $fetch=$selected1->fetch_assoc();
        $user=$fetch["username"];
        if($selected->num_rows>0){
            echo "<script>alert('Data already exist!')</script>";
            header("refresh:1; url=index?user=".base64_encode(strrev($user)));
            $profile=false;
        }else{
            $insert="INSERT INTO profile (user_id,name,date_of_birth,address,avatar) VALUES ('$id','$name','$date_of_birth','$address','$avatar')";
            if($conn->query($insert)===TRUE){
                $profile=true;
            }else{
                $profile=false;
                $profile=$conn->error;
            }
        }
        return $profile;
    }
    public static function profile_update($id,$name,$date_of_birth,$address,$avatar){
        $conn = DB::db();
        $update="UPDATE profile SET name='$name',date_of_birth='$date_of_birth',address='$address',avatar='$avatar' WHERE user_id='$id'";
        if($conn->query($update)===TRUE){
            $profile1=true;
        }else{
            $profile1=false;
            $profile1=$conn->error;
        }
        return $profile1;
    }
    public static function login_with_google($email,$username){
        $conn = DB::db();
        $query="SELECT * FROM user WHERE email='$email'";
		$result=$conn->query($query);
		$row=$result->fetch_assoc();
		if(isset($row["email"])==$email){
			if($row["username"]==$username){
                session::set('is_login', true);
                $sqls=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
	            $row1=mysqli_fetch_array($sqls);
	            $id=$row1["user_id"];
	            session::set('username', $username);
	            session::set('id', $id);
				header("Location: index?user=".base64_encode(strrev($id)));
			}else{
				header("Location: login?exist=Email already exist you can't login with google!");
                $users=false;
			}
        }else{
            $insert="INSERT INTO user (username,email) VALUES ('$username','$email')";
            if($conn->query($insert)===TRUE){
                $users=true;
            }else{
                $users=false;
                $users=$conn->error;
            }
        }
        return $users;
    }
    public static function reset_password($password,$password1,$user1){
        $conn = DB::db();
        $option=[
            'cost'=>8,
        ];
        $password=password_hash($password, PASSWORD_BCRYPT, $option);
        $password1=password_hash($password1, PASSWORD_BCRYPT, $option);
        $update="UPDATE user SET password='$password',cofirm_password='$password1' WHERE username='$user1'";
        if($conn->query($update)===TRUE){
            $reset_password=true;
        }else{
            $reset_password=false;
            $reset_password=$conn->error;
        }
        return $reset_password;
    }

    public static function contact($id,$name,$email,$phone,$message){
        $conn = DB::db();
        date_default_timezone_set('Asia/Kolkata');
        $current_date_time=date("Y:m:d H:i:s");
        $sql="SELECT * FROM contact WHERE user_id='$id'";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            echo "<script>alert('Message already received. contact us soon!')</script>";
            header("refresh:1; url=contact");
            $contact=false;
        }else{
            $insert="INSERT INTO contact (user_id,name,email,phone,message) VALUES ('$id','$name','$email','$phone','$message')";
            if($conn->query($insert)===TRUE){
                $contact=true;
            }else{
                $contact=false;
                $contact=$conn->error;
            }
        }
        return $contact;
    }

    public function __construct($username){
        $this->username=$username;
        $this->conn=DB::db();
        $sql="SELECT id FROM user WHERE username='$username'";
        $result=$this->conn->query($sql);
        if ($result->num_rows>0) {
            while ($row=$result->fetch_assoc()) {
                $this->id=$row["id"];
            }
        } else {
            throw new Exception("User not found!");
        }
    }
    public function getUsername(){
        return $this->username;
    }
    public static function authenticate(){

    }
}