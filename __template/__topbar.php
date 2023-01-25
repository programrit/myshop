<div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="index?user=<?php echo base64_encode(strrev($user2)); ?>" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="font-weight-bold border px-3 mr-1" style="color: #c5837c;">my</span>shop</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="/my-shop/search" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <button class="btn bg-transparent" type="submit" style="color: #c5837c;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="order" class="btn border">
                    <?php
                    $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                    $rows=mysqli_fetch_array($sql);
                    $user=$rows['id'];
					$query="SELECT * FROM checkout WHERE user_id='$user'";
					$result=$conn->query($query);
                    $count=0;
					if ($row=$result->num_rows){
						$count=$row;
					}
                    ?>
                    <i class="fas fa-store" style="color: #c5837c;"></i>
                    <span class="badge text-dark"><?php echo $count; ?></span>
                </a>
                <a href="cart" class="btn border">
                <?php
                    $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                    $rows=mysqli_fetch_array($sql);
                    $user=$rows['id'];
					$query="SELECT * FROM cart WHERE user_id='$user' AND active='0'";
					$result=$conn->query($query);
                    $count=0;
					if ($row=$result->num_rows){
						$count=$row;
					}
					?>
                    <i class="fas fa-shopping-cart" style="color: #c5837c;"></i>
                    <span class="badge text-dark"><?php echo $count; ?></span>
                </a>
            </div>
        </div>
    </div>