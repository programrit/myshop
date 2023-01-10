<?php
$id=base64_decode($_GET['id']);
$id1=$conn->real_escape_string($id);
$id1=htmlspecialchars($id1);
if($id1){?>
<form class="container-fluid pt-5 needs-validation" novalidate action="" method="POST">
    <div class="row px-xl-5">
        <div class="col-lg-6">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4 text-center">Billing Address</h4>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" type="text" required placeholder="Enter your name"> 
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Mobile No</label>
                        <input required class="form-control" name="phone" type="number" required placeholder="Enter your mobile no">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Address Line 1</label>
                        <textarea class="form-control" name="address" required minlength="20" maxlength="100" placeholder="Enter full address detail"></textarea>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0 text-center">Order Total</h4>
                </div>
                <div class="card-body">
                    <?php 
                        $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                        $rows=mysqli_fetch_array($sql);
                        $user=$rows['id']; ?>
                        <input type="hidden" name="user_id" value="<?php echo $user; ?>">
                        <?php $query="SELECT * FROM cart WHERE user_id='$user' AND active='0'";
                        $result=$conn->query($query);
                        $count=1;
                        while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                        <div class="container-fluid">
                            <input type="hidden" name="product_id[]" value="<?php echo $row['product_id']; ?>">
                            <div class="row">
                                <div class="col-lg-6 pb-3">
                                <input type="hidden" name="user_id" value="<?php echo $user; ?>">
                                    <input type="hidden" name="img[]" value="<?php echo $row['product_img']; ?>">
                                    <img src="/my-shop/admin/men_img/<?php echo $row['product_img'];?>" class="img-fluid w-100">
                                </div>
                                <div class="col-lg-6">
                                    <input type="hidden" name="product_name[]" value="<?php echo $row['product_name']; ?>">
                                    <input type="hidden" name="size[]" value="<?php echo $row['size']; ?>">
                                    <input type="hidden" name="quantity[]" value="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="color[]" value="<?php echo $row['color']; ?>">
                                    <p class="ml-5">Product No: <?php echo $count++; ?></p>
                                    <p class="ml-5">Name: <?php echo $row['product_name']; ?></p>
                                    <p class="ml-5">Price: $ <?php echo $row['price']; ?></p>
                                    <p class="ml-5">Size: <?php echo $row['size']; ?></p>
                                    <p class="ml-5">Color: <?php echo $row['color']; ?></p>
                                    <p class="ml-5">Quantity: <?php echo $row['quantity']; ?></p>
                                </div>
                            </div>    
                        </div>

                    <hr class="mt-0">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 pb-3">
                                    <h6 class="font-weight-medium ml-5">Subtotal</h6>
                                </div>
                                <div class="col-lg-6">
                                <input type="hidden" name="price[]" value="<?php echo $row['total']; ?>">
                                <h6 class="font-weight-medium ml-5">$ <?php echo $row['total']; ?></h6>
                                </div>
                            </div>    
                        </div>
                   <?php }?>
                    <hr class="mt-0">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 pb-3">
                                    <h6 class="font-weight-medium ml-5">Delivery Fees</h6>
                                </div>
                                <div class="col-lg-6">
                                <h6 class="font-weight-medium ml-5">$ 40</h6>
                                </div>
                            </div>    
                        </div>
                        
                </div>
                <?php
                $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                $rows=mysqli_fetch_array($sql);
                $user=$rows['id'];
                $query="SELECT SUM(total) FROM cart WHERE user_id='$user' AND active='0'";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 pb-3">
                                <h6 class="font-weight-medium ml-5">Total</h6>
                            </div>
                            <div class="col-lg-6">
                            <h6 class="font-weight-medium ml-5">$ <?php if($row['SUM(total)']>=500){ echo $row['SUM(total)'];}else{ echo $row['SUM(total)']+40;} ?></h6>
                            </div>
                        </div>    
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="place" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Cash on delivery</button>
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Cart to pay</button>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content" style="background-color: #00BFFF;">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Cart Detail</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <label for="">Cart number</label>
                                        <input type="number" name="card_no" pattern="[0-9]{9}[0-9]{4}" class="form-control" required>
                                        <div class="invalid-feedback">Enter valid card no!</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Expire Date</label>
                                            <input type="month" name="" class="form-control" required>
                                            <div class="invalid-feedback">Enter valid date!</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">CVV</label>
                                            <input type="password" name="cvv" pattern="[0-9]{3}" class="form-control" required>
                                            <div class="invalid-feedback">Enter valid cvv!</div>
                                        </div>
                                    </div>
                                    <?php
                                     $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                                     $rows=mysqli_fetch_array($sql);
                                     $user=$rows['id'];
                                     $query="SELECT SUM(total) FROM cart WHERE user_id='$user' AND active='0'";
                                     $result=$conn->query($query);
                                     while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                                    <div class="col-md-6">
                                        <h5><b>Amount: </b> $ <?php if ($row['SUM(total)']>=500) {
                                            echo $row['SUM(total)'];
                                        } else {
                                            echo $row['SUM(total)']+40;
                                        } ?></h5>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="modal-footer">
                                  <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button> -->
                                  <button type="submit" name="online" class="btn btn-success" >Pay</button>
                                </div>            
                          </div>
                        </div>
                    </div>
                </div>   
        </div>
    </div>
</form>

<?php }

