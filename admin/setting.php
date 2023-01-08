<?php
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if(admin_session::get('is_login')){
	$user1=admin_session::get('email');
	$password=false;
	$change=false;
	$msg=null;
	$msg1=null;
	if(isset($_POST["update"])){
		$old=$conn->real_escape_string($_POST["old"]);
		$old=htmlspecialchars($old);
		$new=$conn->real_escape_string($_POST["new"]);
		$new=htmlspecialchars($new);
		$confirm=$conn->real_escape_string($_POST["confirm"]);
		$confirm=htmlspecialchars($confirm);
		$username=$user1;
		$sql=mysqli_query($conn,"SELECT * FROM admin_user WHERE email='$user1'");
		$row=mysqli_fetch_array($sql);
		if($row["password"]!=$old){
			$msg1="Please enter correct old password!";
		}else{
			if($new != $confirm){
				$msg1="Password doesn't match!";
			}else{
				$change=admin::update_password($username, $new);
				$password=true;
			}
		}	
	}
	if($change==true && $password==true){
		$msg="Password update successfully!";
		header("refresh:3; url=index?user=".base64_encode(strrev($user1)));
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
					<h1 class="mt-4">Settings</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item active">Dashboard / Settings</li>
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
							Admin Update Table
						</div>
						<div class="card-body">
                                        <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                        <input type="hidden" name="id">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="">Old Password</label>
                                                <input type="password" name="old" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$"  class="form-control" required>
                                                <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">New Password</label>
                                                <input type="password" name="new"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" class="form-control" required>
                                                <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Confirm Password</label>
                                                <input type="password" name="confirm" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" class="form-control" required>
                                                <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                                            </div>
											<div class="col-md-12 mb-3 mt-2 text-center">
                                                <button class="btn btn-primary" type="submit" name="update">Change Password</button>
												<button class="btn btn-danger" type="reset">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
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
	<script src="js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	<script src="assets/demo/chart-area-demo.js"></script>
	<script src="assets/demo/chart-bar-demo.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="js/datatables-simple-demo.js"></script>
	<script>
		setTimeout("preventback()", 0);
    window.onunload=function(){ null };
    if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
    }
	</script>
</body>

</html>
<?php }else{
	header("Location: login");
}?>
