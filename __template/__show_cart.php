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
                            while($row=$result->fetch_array(MYSQLI_ASSOC)){
                                ?>
                        <form action="" method="POST">
                        <tr>
                            <td class="align-middle">Colorful <?php echo $row['product_name']; ?></td>
                            <input type="hidden" name="name" value="<?php echo $row["product_name"];?>">
                            <input type="hidden" name="id" value="<?php echo $row["product_id"];?>">
                            <td class="align-middle"><img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" alt="" style="width: 50px;"></td>
                            <td class="align-middle"><?php echo $row['color']; ?></td>
                            <td class="align-middle"><?php echo $row['size']; ?></td>
                            <input type="hidden" name="size" value="<?php echo $row["size"];?>">
                            <td class="align-middle">
                                <?php
                                $query1=mysqli_query($conn,"SELECT quantity,product_id FROM mens_size WHERE product_id='$row[product_id]' AND size='$row[size]'");
                                $qty=mysqli_fetch_array($query1);
                                if($row["product_id"]==$qty["product_id"]){?>
                                    <input type="number" class="form-control quantity" name="quantity" onchange="this.form.submit();" value="<?php echo $row["quantity"]; ?>" min="1" max="<?php if($qty['quantity']>=10){ echo 10;}else if($qty['quantity']==0){ echo "<script>alert('Product stock is not available!')</script>";}else{ echo $qty['quantity'];}?>">
                                <?php }?>
                            </td>
                            <td class="align-middle">???<?php echo $row['price']; ?></td>
                            <input type="hidden" name="price" class="price" value="<?php echo $row["price"];?>">
                            <td class="align-middle total">???<?php echo $row['total'] ?></td>
                            <td class="align-middle"><button type="submit" onclick="return checkdelete()" name="remove" value="<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                        </tr>
                        </form>
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
                            
                            <h6 class="font-weight-medium">???<?php 
                            echo $row['SUM(total)'];
                            ?></h6>
                            
                        </div>
                        <?php if($row['SUM(total)']>=500){  

                        }else{ ?>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Delivery Fees</h6>
                                <h6 class="font-weight-medium">???40</h6>
                            </div>
                        <?php }  ?>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">??? <?php if($row['SUM(total)']>=500){ echo $row['SUM(total)'];}else{ echo $row['SUM(total)']+40;} ?></h5>
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