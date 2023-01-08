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
                        <input class="form-control" name="name" type="text" required placeholder="Enter your name"> 
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Mobile No</label>
                        <input required class="form-control" pattern="[6-9]{1}[0-9]{9}" name="phone" type="number" required placeholder="Enter your mobile no">
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
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <input type="hidden" value="<?php echo "Colorful ".session::get("name");?>" name="product_name">
                            <p>Name: <?php echo "Colorful ".session::get("name");?></p>
                            <img src="/my-shop/admin/men_img/<?php echo session::get("img") ?>" class="img-fluid" height="30" width="30">
                        </div>
                        <div class="d-flex">
                            <p>Price: $ <?php echo session::get("price"); ?></p><br>
                            <p class="ml-3">Size: <?php echo session::get("size"); ?></p>
                            <p class="ml-3">Quantity: <?php echo session::get("quantity"); ?></p>
                            <p class="ml-3">Color: <?php echo session::get("color"); ?></p>
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$ <?php echo session::get("total");?></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium">$ <?php if(session::get('total')>=500){  echo "<p class='text-danger'>If price above 500.Free delivery</p>";}else{ echo 40;}  ?></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$ <?php if(session::get('total')>=500){  echo session::get("total");}else{ echo session::get("total")+40;}  ?></h5>
                        </div>
                    </div>
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
                                    <div class="col-md-6">
                                        <h5><b>Amount: </b> $ <?php if(session::get('total')>=500){  echo session::get("total");}else{ echo session::get("total")+40;}  ?></h5>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" name="online" class="btn btn-success" >Pay</button>
                                </div>            
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
<?php }else{
    header("Location: login");
}
?>
