<?php

include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn = DB::db();
session::start();
if (session_status() === PHP_SESSION_NONE) {
    echo "<script>alert('Session not start')</script>";
}

if (isset($_POST["id"]) && isset($_POST["name"])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $id = $conn->real_escape_string($_POST["id"]);
    $name = htmlspecialchars($name);
    $id = htmlspecialchars($id);
    $sql = "SELECT * FROM user WHERE username='$name' AND email='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session::set('is_login', true);
        $sqls = mysqli_query($conn, "SELECT * FROM user WHERE username='$name' AND email='$id'");
        $row1 = mysqli_fetch_array($sqls);
        $id1 = $row1["user_id"];
        session::set('username', $name);
        session::set('id', $id1);
        echo "Login successfully";
    } else {
        $query = "INSERT INTO user (username,email) VALUES ('$name','$id')";
        if ($conn->query($query) === true) {
            echo "login successfully";
        } else {
            echo "Something went wrong!";
        }
    }
} else {
    echo "Sorry. you can't login with facebook. try another option to login!";
}
