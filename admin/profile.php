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
	$msg=null;
	$msg1=null;
	$update=false;
	$profile=false;
	if(isset($_POST["update"])){
		$img=$_FILES["image"]["name"];
		if(empty($img)){
			echo "<script>alert('Please select your profile!')</script>";
		}else{
			$sql="SELECT * FROM admin_user WHERE email='$user1'";
			$results=$conn->query($sql);
			$rows=$results->fetch_assoc();
			$id=$rows["id"];
			$sql1="SELECT * FROM admin_user WHERE email='$user1'";
			$result1=$conn->query($sql1);
			$row1=$result1->fetch_assoc();
			$delete="C:/xampp/htdocs/my-shop/admin/avatar/$row1[profile]";
			if(is_file($delete)){
				unlink($delete);
				$img=$_FILES["image"]["name"];
				move_uploaded_file($_FILES["image"]["tmp_name"], "C:/xampp/htdocs/my-shop/admin/avatar/".$_FILES["image"]["name"]);
			}else{
				$msg1="Something went wrong. please try again later!";
			}
			$profile=admin::profile_update($id,$img);
			$update=true;
		}
	}
	if($profile==true && $update==true){
		$msg="Profile update successfully!";
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
					<h1 class="mt-4">Profile</h1>
					<ol class="breadcrumb mb-4">
						<li class="breadcrumb-item active">Dashboard / Profile</li>
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
							Add admin
						</div>
						<div class="card-body">
							<?php  
							$query="SELECT * FROM admin_user WHERE email='$user1'";
							$result=$conn->query($query);
							while($row=$result->fetch_assoc()){?>
                        <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                        <input type="hidden" name="id">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="">Username</label>
                                                <input type="text" name="username" disabled value="<?php echo $row["email"]; ?>"  pattern="[a-zA-Z]{3,}[0-9]{2,}" class="form-control">
                                                <div class="invalid-feedback"> Must be 3 letter and 2 number!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Phone no</label>
                                                <input type="text" name="phone" disabled value="<?php echo $row["phone"]; ?>" pattern="[6-9]{1}[0-9]{9}" class="form-control" >
                                                <div class="invalid-feedback">Must be 10 numbers only and start no 9 or 8 or 7 or 6!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Avatar</label>
                                                <input type="file" name="image"  class="form-control" required>
                                                <div class="invalid-feedback">Select Image</div>
                                            </div>
                                            <div class="col-md-12 mb-3 mt-2 text-center">
                                                <button class="btn btn-primary" type="submit" name="update">Update</button>
												<button class="btn btn-danger" type="reset">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
									<?php }

							?>
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

<?php } else{
	header("Location: login");
}?>
