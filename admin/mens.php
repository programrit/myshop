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
$del=false;
if(admin_session::get('is_login')){
    $user1=admin_session::get('email');
    if(isset($_POST["delete"])){
        $id=$conn->real_escape_string($_POST["delete"]);
        $id=htmlspecialchars($id);
        $del=product::men_delete($id);
        $delete=true;
    }
    if($del==true && $delete==true){
        $msg="Product deleted successfully!";
        header("refresh:2; url=mens");
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
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>
                        <p class="error msg text-white"><?php if(isset($msg)){?>
                        <div class="alert alert-success text-center" role="alert"><?php echo $msg;?></div>
                   <?php  } ?></p>
                    <p class="error msg text-white"><?php if(isset($msg1)){?>
                        <div class="alert alert-danger text-center" role="alert"><?php echo $msg1;?></div>
                    <?php } ?></p>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="text-center mt-2"><button class="btn btn-primary"><a href="add-men" style="text-decoration: none;" class="text-white">Add collection</a></button></div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Product Id</th>
                                            <th>Category</th>
                                            <th>Product Type</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>MRP</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Information</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Product Id</th>
                                            <th>Category</th>
                                            <th>Product Type</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>MRP</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Information</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $query="SELECT * FROM mens";
                                        $result=$conn->query($query);
                                        while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                                        <tr>
                                            <td><?php echo $row['product_id'] ?></td>
                                            <td><?php echo $row['category'] ?></td>
                                            <td><?php echo $row['product_type'] ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td>
                                                <?php
                                                $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                                                $row1=mysqli_fetch_array($sql);
                                                $data=$row1['product_img'];
                                                $data=explode(" ",$data);
                                                $count=count($data)-1;
                                                for($i=0;$i<$count;$i++){?>
                                                    <img src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                                                <?php }
                                                ?>
                                            </td>
                                            <td><?php echo $row['color'] ?></td>
                                            <td>
                                            <a href="men-size?id=<?php echo base64_encode($row['product_id']); ?>" style="text-decoration: none;" class="text-primary">Add size</a>
                                            </td>
                                            <td><?php echo $row['mrp'] ?></td>
                                            <td><?php echo $row['price'] ?></td>
                                            <td><?php echo $row['description'] ?></td>
                                            <td><?php echo $row['information'] ?></td>
                                            <td><?php echo $row['active'] ?></td>
                                            <td>
                                            <div class="btn-group">
                                            <button class="btn btn-primary" style="height: 30px;"><a href="men-edit?id=<?php echo base64_encode($row['product_id']); ?>" style="text-decoration: none;" class="text-white"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                                <form action="" method="POST">
													<button class="btn btn-danger" onclick="return deleted()" name="delete" type="submit" value="<?php echo $row['product_id']; ?>"><i class="fa-solid fa-trash"></i></button>
											   </form>
                                            </div>
                                            </td>
                                        </tr>
                                        <?php }?> 
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
		function deleted(){
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
