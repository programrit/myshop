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
$user=null;
$add=null;
if(admin_session::get('is_login')){
	$user1=admin_session::get('email');
	if(isset($_POST["size"])){
		$id=base64_decode($_GET['id']);
		$product_id=$conn->real_escape_string($id);
		$category=$_POST["category"];
		$type=$_POST["product_type"];
		$size=$conn->real_escape_string($_POST["product_size"]);
		$quantity=$conn->real_escape_string($_POST["quantity"]);
        $mrp=$conn->real_escape_string($_POST["mrp"]);
		$price=$conn->real_escape_string($_POST["price"]);
		$active=$conn->real_escape_string($_POST["active"]);
		$id=htmlspecialchars($id);
		$product_id=htmlspecialchars($product_id);
		$size=htmlspecialchars($size);
		$quantity=htmlspecialchars($quantity);
		$mrp=htmlspecialchars($mrp);
		$price=htmlspecialchars($price);
		$active=htmlspecialchars($active);
		$sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$id'");
		$row=mysqli_fetch_array($sql);
		if(($row['active'])==1){
			$add=product::size($id,$category,$type,$product_id,$size,$quantity,$mrp,$price,$active);
			$update=true;
		}else{
			echo "<script>alert('This product not active')</script>";
        	header("refresh:1; url=mens");
		}
	}
	if($add && $update){
		echo "<script>alert('size  add successfully!')</script>";
        header("refresh:1; url=view-men-size");
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
							$query="SELECT * FROM mens WHERE product_id='$id'";
							$result=$conn->query($query);?>
                                    <form action="" method="POST" class="needs-validation" novalidate>
                                        <div class="row">
                                        <?php while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Product Id</label>
                                                <input type="text" disabled name="product_id" value="<?php echo $row['product_id']; ?>"   class="form-control">
                                            </div>
											<div class="col-md-6 mb-3">
                                                <label for="category">Category</label>
                                                <input type="text" readonly name="category" id="category"  value="<?php echo $row['category']; ?>"   class="form-control">
                                            </div>
											<div class="col-md-6 mb-3">
                                                <label for="type">Product Type</label>
                                                <input type="text" readonly name="product_type" id="type" value="<?php echo $row['product_type']; ?>"   class="form-control">
                                            </div>
                                            <?php }?>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Size</label>
                                                <select class="form-control " name="product_size" required>
                                                    <option value="" selected disabled>Select size</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                    <option value="X">X</option>
                                                    <option value="XL">XL</option>
                                                </select>
                                                <div class="invalid-feedback">Please select size!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Quantity</label>
                                                <input type="number" name="quantity"  pattern="[0-9]{1}" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid quantity</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">MRP</label>
                                                <input type="number" name="mrp" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid MRP</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Price</label>
                                                <input type="number" name="price" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid price</div>
                                            </div>
											<?php
											$query=mysqli_query($conn,"SELECT * FROM mens WHERE product_id='$id'");
											while($row=mysqli_fetch_array($query)){
												if($row['active']==1){?>
												<div class="col-md-6 mb-3">
                                                	<label for="">Active</label>
                                                	<select class="form-control" name=active>
                                                    	<option value="1">1</option>
                                                    	<option value="0">0</option>
                                                	</select>
                                            	</div>
												<?php }else{?>
													<div class="col-md-6 mb-3">
                                                		<label for="">Active</label>
                                                		<select class="form-control" name=active>
                                                    		<option value="0">0</option>
                                                		</select>
                                            		</div>
												<?php }
												}
											?>
                                            <div class="col-md-12 mb-3 text-center">
                                                <button class="btn btn-primary" type="submit" name="size">Added</button>
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
