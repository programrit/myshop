<?php  
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$add=false;
$admin=null;
$msg=null;
$msg1=null;

if(admin_session::get('is_login')){
    $user1=admin_session::get('email');
    if(isset($_POST["add"])){
        $email=$conn->real_escape_string($_POST["email"]);
        $phone=$conn->real_escape_string($_POST["phone"]);
        $password=$conn->real_escape_string($_POST["password"]);
        $email=htmlspecialchars($email);
        $phone=htmlspecialchars($phone);
        $password=htmlspecialchars($password);
        $admin=admin::add_admin($email, $phone, $password);
        $add=true;
    }
    if($add && $admin){
        echo "<script>alert('Admin add successfully!')</script>";
        header("refresh:1; url=view-admin");
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
						<li class="breadcrumb-item active">Dashboard / Add User</li>
					</ol>
					<p class="error msg text-white"><?php if(isset($msg)){?>
                        <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
                   <?php  } ?></p>
                   <div><?php
                    if (isset($_GET['exist'])) {?>
						<div class="text-danger text-center alert alert-danger" role="alert">
							<?php 
                            $exist=$conn->real_escape_string($_GET['exist']);
                            $exist=htmlspecialchars($exist);
                            echo $exist;
                            ?>
						</div>
						<?php }?>
					</div>
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							Edit Table
						</div>
						<div class="card-body">
                            <form action="" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="id">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Username</label>
                                        <input type="email" name="text" class="form-control" required>
                                        <div class="invalid-feedback">Enter valid username!</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Phone no</label>
                                        <input type="text" name="phone" pattern="[6-9]{1}[0-9]{9}" class="form-control" required>
                                        <div class="invalid-feedback">Must be 10 numbers only and start no 9 or 8 or 7 or 6!</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Password</label>
                                        <input type="password" name="password"  class="form-control" required>
                                        <div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <button class="btn btn-primary" type="submit" name="add">Add Admin</button>
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
</body>

</html>
<?php }else{
    header("Location: login");
}


?>
