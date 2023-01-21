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
$msg=null;
$msg1=null;
if(admin_session::get('is_login')){
	$user1=admin_session::get('email');
	if(isset($_POST["status"])){
		$status=$conn->real_escape_string($_POST["status"]);
        $id=$conn->real_escape_string($_POST["id"]);
		$id=htmlspecialchars($id);
		$status=htmlspecialchars($status);
		$order=$conn->real_escape_string($_POST["order_id"]);
		$order=htmlspecialchars($order);
		$update="UPDATE checkout SET status='$status' WHERE id='$id'";
        if($conn->query($update)===TRUE){
			$msg="Order status update successfully!";
        	header("refresh:2; url=order-edit?id=".base64_encode($order));
		}else{
			$msg1="Something went wrong!";
        	header("refresh:2; url=order-list");
		}
	}
	if(isset($_POST["delete"])){
		$id=$conn->real_escape_string($_POST["delete"]);
		$id=htmlspecialchars($id);
		$del=product::order_del($id);
		$delete=true;
	}
	if($del==true && $delete==true){
		$msg="Order deleted successfully!";
		header("refresh:2; url=order-list");
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
					<h1 class="mt-4">Order</h1>
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
						<table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order Id</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Color</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order Id</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Color</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
								       $id1=base64_decode($_GET['id']);
									   $id=$conn->real_escape_string($id1);
									   $id=htmlspecialchars($id);
									   $query="SELECT * FROM checkout WHERE order_id='$id'";
									   $result=$conn->query($query);
									   while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['product_id']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" alt="" style="width: 50px;"></td>
                                            <td><?php echo $row['size']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
											<td><?php echo $row['color']; ?></td>
											<td>
											<form action="" method="POST">
												<input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
												<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
												<select name="status" class="form-control" onchange="this.form.submit();">
												<?php
												if($row["status"]=="pending"){?>
													<option value="pending">pending</option>
													<option value="confirm">confirm</option>
													<option value="delivery">delivery</option>
													<option value="cancel">cancel</option>
												<?php }else if($row["status"]=="confirm"){?>
													<option value="confirm">confirm</option>
													<option value="delivery">delivery</option>
													<option value="pending">pending</option>
													<option value="cancel">cancel</option>
												<?php }else if($row["status"]=="delivery"){?>
													<option value="delivery">delivery</option>
													<option value="confirm">confirm</option>
													<option value="pending">pending</option>
													<option value="cancel">cancel</option>
												<?php }else if($row["status"]=="cancel"){?>
													<option value="cancel">cancel</option>
													<option value="pending">pending</option>
													<option value="confirm">confirm</option>
													<option value="delivery">delivery</option>
												<?php }
												?>
												</select>
												</form>
											</td>
                                            <td>
                                            <div class="btn-group">
                                            <button class="btn btn-primary" style="height: 30px;"><a href="order-edit?id=<?php echo base64_encode($row['id']); ?>" style="text-decoration: none;" class="text-white"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                                <form action="" method="POST">
													<button class="btn btn-danger" onclick="return order_delete()" name="delete" type="submit" value="<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
											   </form>
                                            </div>
                                            </td>
                                        </tr> 
                                        <?php }?>
                                    </tbody>
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
    function order_delete(){
        return confirm("Are you sure you want to delete this data?");
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
