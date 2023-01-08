<div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                            $rows=mysqli_fetch_array($sql);
                            $user=$rows['id'];
                            $query="SELECT * FROM cart WHERE user_id='$user' AND active='0'";
                            $result=$conn->query($query);
                            while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                        <tr>
                            <td class="align-middle">Colorful <?php echo $row['product_name']; ?></td>
                            <td class="align-middle"><img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" alt="" style="width: 50px;"></td>
                            <td class="align-middle"><?php echo $row['color']; ?></td>
                            <td class="align-middle"><?php echo $row['size']; ?></td>
                            <td class="align-middle"><?php echo $row['quantity']; ?></td>
                            <td class="align-middle">$<?php echo $row['price']; ?></td>
                            <td class="align-middle">$<?php echo $row['total'] ?></td>
                            <form action="" method="POST">
                                <td class="align-middle"><button type="submit" onclick="return checkdelete()" name="remove" value="<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                            </form>
                        </tr>
                        <?php }?>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <?php
                            $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                            $rows=mysqli_fetch_array($sql);
                            $user=$rows['id'];
                            $query="SELECT SUM(total) FROM cart WHERE user_id='$user' AND active='0'";
                            $result=$conn->query($query);
                            while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                        <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            
                            <h6 class="font-weight-medium">$<?php 
                            echo $row['SUM(total)'];
                            ?></h6>
                            
                        </div>
                    <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium"><?php if($row['SUM(total)']>=500){  echo "<p class='text-danger'>If price above 500.Free delivery</p>";}else{ echo "$ 40";}  ?></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$ <?php if($row['SUM(total)']>=500){ echo $row['SUM(total)'];}else{ echo $row['SUM(total)']+40;} ?></h5>
                        </div>
                        <?php
                            if($row['SUM(total)']<=40){?>
                                <button class="btn btn-block btn-primary my-3 py-3" disabled>Proceed To Checkout</button>
                            <?php }else{?>
                                <button class="btn btn-block btn-primary my-3 py-3"><a href="cart-to-checkout?id=<?php echo base64_encode($user);?>" style="text-decoration: none;" class="text-dark">Proceed To Checkout</a></button>
                            <?php }
                        ?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>