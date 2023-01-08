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
$collection=false;
$men=null;
$msg=null;
$msg1=null;

if(admin_session::get('is_login')){
    $user1=admin_session::get('email');
    if(isset($_POST["mens"])){
        $category=$conn->real_escape_string($_POST["category"]);
        $type=$conn->real_escape_string($_POST["product_type"]);
        $name=$conn->real_escape_string(ucfirst($_POST["product_name"]));
        $location="C:/xampp/htdocs/my-shop/admin/men_img/";
        $data=null;
        $file=null;
        $tmp=null;
        foreach($_FILES['product_img']['name'] as $key=>$val){
            $file=$_FILES['product_img']['name'][$key];
            $tmp=$_FILES['product_img']['tmp_name'][$key];
            move_uploaded_file($tmp, $location.$file);
            $data .=$file." ";
        }
        $color=$conn->real_escape_string($_POST["color"]);
        $mrp=$conn->real_escape_string($_POST["mrp"]);
        $price=$conn->real_escape_string($_POST["price"]);
        $description=$conn->real_escape_string(ucfirst($_POST["description"]));
        $information=$conn->real_escape_string(ucfirst($_POST["information"]));
        $active=$conn->real_escape_string(ucfirst($_POST["active"])); 
        $category=htmlspecialchars($category);
        $type=htmlspecialchars($type);
        $name=htmlspecialchars($name);
        $color=htmlspecialchars($color);
        $mrp=htmlspecialchars($mrp);
        $price=htmlspecialchars($price);
        $description=htmlspecialchars($description);
        $information=htmlspecialchars($information);
        $active=htmlspecialchars($active);
        $men=product::mens($category,$type,$name,$data,$color,$mrp,$price,$description,$information,$active);
        $collection=true;
    }
    if($collection){
        admin_session::set('image', $men);
        $msg="collection add successfully!";
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
                   <p class="error msg text-white"><?php if(isset($msg1)){?>
                        <div class="alert alert-danger text-center" role="alert"><?php echo $msg1;?></div>
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
                                    <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                        <input type="hidden" name="id">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="category">Category</label>
                                                <select class="form-control" id="category" name="category" onclick="display()" required>
                                                    <option value="" selected disabled>Select category</option>
                                                    <?php  
                                                    $query="SELECT * FROM category";
                                                    $result=$conn->query($query);
                                                    foreach($result as $row){?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['category']; ?></option>
                                                    <?php }
                                                    ?>
                                                    
                                                </select>
                                                <div class="invalid-feedback">Please select anyone!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="type">Product Type</label>
                                                <select class="form-control" id="type" name="product_type" required>
                                                    <option value='' selected disabled>Select product type</option>
                                                </select>
                                                <div class="invalid-feedback">Please select anyone!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Product Name</label>
                                                <input type="text" name="product_name" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid name!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Product Image</label>
                                                <input type="file" name="product_img[]" multiple class="form-control" required>
                                                <div class="invalid-feedback">Please select images!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Color</label>
                                                <select class="form-control" name="color" required>
                                                    <option value="" selected disabled>Select color</option>
                                                    <option value="Red">Red</option>
                                                    <option value="Black">Black</option>
                                                    <option value="White">White</option>
                                                    <option value="Blue">Blue</option>
                                                </select>
                                                <div class="invalid-feedback">Please select color!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">MRP</label>
                                                <input type="number" name="mrp" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid MRP!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Price</label>
                                                <input type="number" name="price" class="form-control" required>
                                                <div class="invalid-feedback">Enter valid price!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Description</label>
                                                <textarea class="form-control" name="description" required minlength="5" maxlength="50"></textarea>
                                                <div class="invalid-feedback">Enter valid description!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Information</label>
                                                <textarea class="form-control" name="information" required minlength="5" maxlength="50"></textarea>
                                                <div class="invalid-feedback">Enter valid information!</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="">Active</label>
                                                <select class="form-control" name=active>
                                                    <option value="1">1</option>
                                                    <option value="0">0</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3 text-center">
                                                <button class="btn btn-primary" type="submit" name="mens">Add collection</button>
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
     <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
        function display(){
            $('#type').html('');
            var id=document.getElementById('category').value;
            //console.log(id);
            $.ajax({
                type:'post',
                url:'product.php',
                data: {category_id:id},
                success: function(data){
                    $('#type').html(data);
                    //console.log(data);
                }
            });
        }
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
<?php }else{
    header("Location: login");
}


?>
