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
$update=false;
$men=null;
if (admin_session::get('is_login')) {
    $user1=admin_session::get('email');
    if (isset($_POST["update"])) {
		$id=base64_decode($_GET['id']);
        $id1=$conn->real_escape_string($id);
		$id1=htmlspecialchars($id1);
        $sizes=$conn->real_escape_string($_POST["size1"]);
        $quantity=$conn->real_escape_string($_POST["quantity1"]);
        $mrp=$conn->real_escape_string($_POST["mrp1"]);
        $price=$conn->real_escape_string($_POST["price1"]);
        $active=$conn->real_escape_string($_POST["active1"]);
		$sizes=htmlspecialchars($sizes);
		$quantity=htmlspecialchars($quantity);
		$mrp=htmlspecialchars($mrp);
		$price=htmlspecialchars($price);
		$active=htmlspecialchars($active);					
        $men=product::size_update($id1, $sizes, $quantity, $mrp, $price, $active);
        $update=true;
    }
    if ($men==true && $update==true) {
        $msg="Men's size & price update successfully!";
        header("refresh:2; url=view-men-size");
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
					<p class="error msg text-white">
						<?php if (isset($msg)) {?>
					<div class="alert alert-success text-center" role="alert">
						<?php echo $msg;?></div>
					<?php  } ?></p>
					<p class="error msg text-white">
						<?php if (isset($msg1)) {?>
					<div class="alert alert-danger text-center" role="alert">
						<?php echo $msg1;?></div>
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
    						$query="SELECT * FROM mens_size WHERE id='$id'";
    						$result=$conn->query($query);
    						while ($row=$result->fetch_array(MYSQLI_ASSOC)) {?>
							<form action="" method="POST" class="needs-validation" novalidate>
								<div class="row">
								<div class="col-md-6 mb-3">
										<label for="">No</label>
										<input type="number" name="product_id" value="<?php echo $row['id'];?>" class="form-control" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Product Id</label>
										<input type="number" name="product_id" value="<?php echo $row['product_id'];?>" class="form-control" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Category</label>
										<input type="text" name="category" value="<?php echo $row['category'];?>" class="form-control" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Product Id</label>
										<input type="text" name="product_type" value="<?php echo $row['product_type'];?>" class="form-control" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Size</label>
										<select class="form-control" name="size1">
											<option value="<?php echo $row['size'] ?>" selected><?php echo $row['size']; ?></option>
										</select>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Quantity</label>
										<input type="number" name="quantity1"
											value="<?php echo $row['quantity']; ?>"
											class="form-control" required>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">MRP</label>
										<input type="number" name="mrp1"
											value="<?php echo $row['mrp'];?>"
											class="form-control" required>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Price</label>
										<input type="number" name="price1"
											value="<?php echo $row['price'];?>"
											class="form-control" required>
									</div>
									<div class="col-md-6 mb-3">
										<label for="">Active</label>
										<select class="form-control" name="active1">
											<option value="1">1</option>
											<option value="0">0</option>
										</select>
									</div>
									<div class="col-md-12 mb-3 text-center">
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
<?php } else {
    header("Location: login");
}?>