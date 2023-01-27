<?php
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
error_reporting(0);
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$update=false;
$user=null;

if(admin_session::get('is_login')){
	$user1=admin_session::get('email');
	if(isset($_POST["update"])){
		$id=$conn->real_escape_string($_POST["id"]);
		$username=$conn->real_escape_string($_POST["username"]);
		$email=$conn->real_escape_string($_POST["email"]);
		$phone=$conn->real_escape_string($_POST["phone"]);
		$id=htmlspecialchars($id);
		$username=htmlspecialchars($username);
		$email=htmlspecialchars($email);
		$phone=htmlspecialchars($phone);
		$user=admin::update($id, $username, $email, $phone);
		$update=true;
	}
	if($update){
		echo "<script>alert('User data update successfully!')</script>";
        header("refresh:1; url=index?user=".base64_encode(strrev($user1)));
	}
	?>
	<!DOCTYPE php>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Admin Page</title>
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php  include "navbar.php";  ?>
	<div id="layoutSidenav">
		<?php include "sidebar.php"; ?>
		<div id="layoutSidenav_content">
        <main>
	<div class="container-fluid px-4">
					<h1 class="mt-4">Users</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item active">Dashboard / User</li>
					</ol>
					<p class="error msg text-white"><?php if(isset($msg)){?>
                        <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
                   <?php  } ?></p>
                    <p class="error msg text-white"><?php if(isset($msg1)){?>
                        <div class="alert alert-danger text-center" role="alert"><?php echo $msg1;?></div>
                    <?php } ?></p>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							Edit Table
						</div>
						<div class="card-body">
							<?php
							$id1=base64_decode($_GET['id']);
							$id=$conn->real_escape_string($id1);
							$id=htmlspecialchars($id);
							$query="SELECT * FROM user WHERE id='$id'";
							$result=$conn->query($query);
							while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                                    <form action="" method="POST" class="needs-validation" novalidate>
                                        <div class="row">
											<input type="hidden" name="id" value="<?php echo $id ?>" >
                                            <div class="col-md-12 mb-3">
                                                <label for="">Username</label>
                                                <input type="text" name="username" value="<?php echo $row['username']; ?>"  pattern="[a-zA-Z]{3,}[0-9]{2,}"  class="form-control" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="">Email</label>
                                                <input type="email" name="email" value="<?php echo $row['email']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="">Phone no</label>
                                                <input type="number" name="phone" value="<?php echo $row['phone'];?>" pattern="[6-9]{1}[0-9]{9}" class="form-control" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button class="btn btn-primary" type="submit" name="update">Update</button>
                                            </div>
                                        </div>
                                    </form>
									<?php }?>
						</div>
					</div>
				</div>
			</main>
			<?php include "footer.php"; ?>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
	</script>
    <script src="../js/validate.js"></script>
	<script>
		setTimeout("preventback()", 0);
    window.onunload=function(){ null };
    if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
    }
	</script>
	<script src="js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	<script src="assets/demo/chart-area-demo.js"></script>
	<script src="assets/demo/chart-bar-demo.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
<?php } else{
	header("Location: login");
}?>
