<?php
$get_id=$_GET["id"];
$id=base64_decode($get_id);
$id=$conn->real_escape_string($id);
$id=htmlspecialchars($id);
$sql="SELECT * FROM checkout WHERE order_id='$id'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();
if($id==isset($row["order_id"])){
    ?>
   <div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-9 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Order Id</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Product rice</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Cancel</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                        $rows=mysqli_fetch_array($sql);
                        $user=$rows['id'];
                        $query="SELECT * FROM checkout WHERE user_id='$user' AND order_id='$id'";
                        $result=$conn->query($query);
                        while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                    <tr>
                        <td class="align-middle"><?php echo $row['order_id']; ?></td>
                        <td class="align-middle"><?php echo $row['product_name']; ?></td>
                        <td class="align-middle"><img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" alt="" style="width: 50px;"></td>
                        <td class="align-middle"><?php echo $row['color']; ?></td>
                        <td class="align-middle"><?php echo $row['size']; ?></td>
                        <td class="align-middle"><?php echo $row['quantity']; ?></td>
                        <td class="align-middle"><?php echo $row['price']/$row['quantity']; ?></td>
                        <td class="align-middle"><?php echo $row['price']; ?></td>
                        <td class="align-middle"><?php 
                        if($row['status']=="pending"){ 
                            echo "<p class='text-info mt-3'>Pending</p>";
                        } else if($row['status']=="confirm"){
                            echo "<p class='text-warning mt-3'>Confirm</p>";
                        }else if($row['status']=="delivery"){
                            echo "<p class='text-success mt-3'>Delivery</p>";
                        }else if($row['status']=="remove"){
                            echo "<p class='text-danger mt-3'>Cancel</p>";
                        }else{
                            echo "<p class='text-danger mt-3'>Sorry this product is not available. product comming soon</p>";
                        }
                            ?></td>
                            <?php  
                            if($row['status']=="pending" || $row['status']=="confirm"){?>
                                <form action="" method="POST">
                                    <td class="align-middle"><button type="submit" onclick="return checkdelete()"  name="remove" value="<?php echo $row['id']; ?>" class="btn btn-sm btn-primary rounded"><i class="fa fa-times"></button></td>
                                </form>
                            <?php }else{?>
                                <td class="align-middle"><button type="button" disabled class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td> 
                            <?php }
                            ?>
                    </tr>
                    <?php }?>
            </table>     
        </div>
        <div class="col-lg-3 mb-5">
            <div class="card border-secondary mb-5">
               <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Summary</h4>
                </div>
                <?php
                    $query="SELECT SUM(price),price FROM checkout WHERE user_id='$user' AND order_id='$id' AND status IN('confirm','pending','delivery')";
                    $result=$conn->query($query);
                   while($row=$result->fetch_assoc()){?>
                        <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        
                        <h6 class="font-weight-medium">₹<?php 
                        echo $row['SUM(price)'];
                        ?></h6>
                        
                    </div>
                    <?php if($row['SUM(price)']>=500){  
                    }else{ ?>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium">₹40</h6>
                        </div>
                    <?php }  ?>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">₹ <?php if($row['SUM(price)']>=500){ echo $row['SUM(price)'];}else{ echo $row['SUM(price)']+40;} ?></h5>
                    </div>
                </div>
                    <?php 
                    }
                    ?>
                    
            </div>
        </div>
        
    </div>
</div>
<?php }else{
    echo "<script>alert('Something went wrong!')</script>";
    header("refresh:1; url=order");
    }
?>
