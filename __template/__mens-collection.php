<form action="" method="GET">
    <div class="d-flex ml-5 col-md-3">
        <label class="mt-2" for="filter">Sort By</label>
        <select class="form-control ml-2" required id="filter" onclick="sort()">
            <option value="" selected disabled>Sort List</option>
            <option value="low-to-high">Low to High</option>
            <option value="high-to-low">High to Low</option>
            <option value="new">Newest</option>
            <option value="old">Oldest</option>
        </select>
    </div>
</form>
<?php  


?>
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Mens collection</span></h2>
    </div>
    <div class="row px-xl-5  pb-3">
        <div class="d-flex justify-content-between col-md-6 pb-1">
        <?php  
        if(isset($_GET["sort"])){
            $sort=$conn->real_escape_string($_GET["sort"]);
            $sort=htmlspecialchars($sort);
            if($sort=="low-to-high"){
                $query="SELECT * FROM mens WHERE category='men' ORDER BY price ASC";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                    <div class="card product-item border-0 mb-4" id="main">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                            $row1=mysqli_fetch_array($sql);
                            $data=$row1['product_img'];
                            $data=explode(" ",$data);
                            $count=count($data)-1;
                            for($i=0;$i<$count;$i++){?>
                                <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                        <?php }?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>$ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
            <?php }
            }else if($sort=="high-to-low"){
                $query="SELECT * FROM mens WHERE category='men' ORDER BY price DESC";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                    <div class="card product-item border-0 mb-4" id="main">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                            $row1=mysqli_fetch_array($sql);
                            $data=$row1['product_img'];
                            $data=explode(" ",$data);
                            $count=count($data)-1;
                            for($i=0;$i<$count;$i++){?>
                                <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                        <?php }?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>$ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
            <?php }
            }else if($sort=="new"){
                $query="SELECT * FROM mens WHERE category='men' ORDER BY product_id DESC";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                    <div class="card product-item border-0 mb-4" id="main">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                            $row1=mysqli_fetch_array($sql);
                            $data=$row1['product_img'];
                            $data=explode(" ",$data);
                            $count=count($data)-1;
                            for($i=0;$i<$count;$i++){?>
                                <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                        <?php }?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>$ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
            <?php }
            }else if($sort=="old"){
                $query="SELECT * FROM mens WHERE category='men' ORDER BY product_id ASC";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                    <div class="card product-item border-0 mb-4" id="main">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                            $row1=mysqli_fetch_array($sql);
                            $data=$row1['product_img'];
                            $data=explode(" ",$data);
                            $count=count($data)-1;
                            for($i=0;$i<$count;$i++){?>
                                <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                        <?php }?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>$ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
            <?php }
            }else{
                echo "<script>alert('Something went wrong!')</script>";
                echo "<script>window.location.href='mens'</script>";
            }
        }else{
                $query="SELECT * FROM mens WHERE category='men'";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                <div class="card product-item border-0 mb-4" id="main">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                            $row1=mysqli_fetch_array($sql);
                            $data=$row1['product_img'];
                            $data=explode(" ",$data);
                            $count=count($data)-1;
                            for($i=0;$i<$count;$i++){?>
                                <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
                        <?php }?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>$ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
            <?php  }
        }?>
        </div>
    </div>
</div>
               

