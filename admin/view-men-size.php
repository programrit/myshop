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
$delete=false;
if(admin_session::get('is_login')){
    $user1=admin_session::get('email');
	if(isset($_POST["delete"])){
		$id=$conn->real_escape_string($_POST["delete"]);
		$id=htmlspecialchars($id);
		$sql=mysqli_query($conn, "SELECT * FROM mens_size WHERE id='$id'");
		$row=mysqli_fetch_array($sql);
		$size=$row['size'];
		$del=product::men_size_delete($id,$size);
		$delete=true;
	}
	if($del==true && $delete==true){
        $msg="Product deleted successfully!";
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
        <?php include "navbar.php"; ?>
        <div id="layoutSidenav">
            <?php  include "sidebar.php"; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index?user=<?php echo base64_encode(strrev($user1));?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                        </div>
                    <div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							User Table
						</div>
						<div class="card-body">
							<table id="datatablesSimple">
								<thead>
									<tr>
										<th>Id</th>
										<th>Product Id</th>
										<th>Category</th>
										<th>Product Type</th>
										<th>Size</th>
										<th>Quantity</th>
										<th>MRP</th>
										<th>Price</th>
										<th>Active</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Id</th>
                                        <th>Product Id</th>
										<th>Category</th>
										<th>Product Type</th>
										<th>Size</th>
										<th>Quantity</th>
										<th>MRP</th>
										<th>Price</th>
										<th>Active</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
								<?php
								$query="SELECT * FROM mens_size";
								$result=$conn->query($query);
								while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
									<tr>
										<td><?php echo $row['id']; ?></td>
										<td><?php echo $row['product_id']; ?></td>
										<td><?php echo $row['category']; ?></td>
										<td><?php echo $row['product_type']; ?></td>
										<td><?php echo $row['size']; ?></td>
										<td><?php echo $row['quantity']; ?></td>
										<td><?php echo $row['mrp']; ?></td>
										<td><?php echo $row['price']; ?></td>
										<td><?php echo $row['active']; ?></td>
										<td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary" style="height: 30px;"><a href="men-size-edit?id=<?php echo base64_encode($row['id']); ?>" style="text-decoration: none;" class="text-white"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                               <form action="" method="POST">
													<button class="btn btn-danger" onclick="return delete1()" name="delete" type="submit" value="<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
											   </form>
                                            </div>
                                        </td>
									</tr>
									<?php 
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
                    </div>
                </main>
                <?php include "footer.php"; ?>
            </div>
        </div>
		<script>
		function delete1(){
			return confirm("Are you sure you want to delete this data?");
		}
	</script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

<?php }else{
    header("Location: login");
}

?>
<