<?php
$id=base64_decode($_GET['id']);
$id1=$conn->real_escape_string($id);
$id1=htmlspecialchars($id1);
if($id){?>
    <form class="container-fluid pt-5 needs-validation" action="" method="POST" novalidate>
        <div class="row px-xl-5">
            <div class="col-lg-6">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Name</label>
                            <input class="form-control"  name="name" pattern="[a-zA-Z]{3,}" type="text" required placeholder="Enter your name"> 
                            <div class="invalid-feedback">Enter valid name</div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Mobile No</label>
                            <input required class="form-control" name="phone" pattern="[6-9]{1}[0-9]{9}" type="text" required placeholder="Enter your mobile no">
                            <div class="invalid-feedback">Enter valid phone no</div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Address Line 1</label>
                            <textarea class="form-control" name="address" required minlength="20" maxlength="100" placeholder="Enter full address detail"></textarea>
                            <div class="invalid-feedback">Enter valid full address</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <input type="hidden" value="<?php echo "Colorful ".session::get("name");?>" id="product_name" name="product_name">
                            <p>Name: <?php echo "Colorful ".session::get("name");?></p>
                            <input type="hidden" value="<?php echo session::get("img") ?>" id="img">
                            <img src="/my-shop/admin/men_img/<?php echo session::get("img") ?>" class="img-fluid" height="30" width="30">
                        </div>
                        <div class="d-flex">
                            <p>Price: ₹ <?php echo session::get("price"); ?></p><br>
                            <p class="ml-3">Size: <?php echo session::get("size"); ?></p>
                            <p class="ml-3">Quantity: <?php echo session::get("quantity"); ?></p>
                            <p class="ml-3">Color: <?php echo session::get("color"); ?></p>
                            <input type="hidden" value="<?php echo session::get("price") ?>" id="price">
                            <input type="hidden" value="<?php echo session::get("size") ?>" id="size">
                            <input type="hidden" value="<?php echo session::get("quantity") ?>" id="quantity">
                            <input type="hidden" value="<?php echo session::get("color") ?>" id="color">
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">₹ <?php echo session::get("total");?></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium">₹ <?php if(session::get('total')>=500){  echo "<p class='text-danger'>If price above 500.Free delivery</p>";}else{ echo 40;}  ?></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <input type="hidden" id="amount" value="<?php if(session::get('total')>=500){  echo session::get("total");}else{ echo session::get("total")+40;}?>">
                            <h5 class="font-weight-bold">₹ <?php if(session::get('total')>=500){  echo session::get("total");}else{ echo session::get("total")+40;}  ?></h5>
                            <input type="hidden" id="product_id" value="<?php echo $id1;?>">
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="place" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Cash on delivery</button>
                        <!-- <button type="submit" id="rzp-button1" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Order</button> -->
                    </div>
                </div>
            </div>
        </div>
    </form>
    
<?php }else{
    header("Location: login");
}?>

