<?php
    $id=base64_decode($_GET['id']);
    $id1=$conn->real_escape_string($id);
    $id1=htmlspecialchars($id1);
    if($id1){?>
    <div class="container-fluid py-5">
        <?php  
        $query="SELECT * FROM mens WHERE product_id='$id'";
        $result=$conn->query($query);
        while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
        <form class="row px-xl-5 needs-validation" action="" method="POST" novalidate>
            <input type="hidden" value="<?php echo $id; ?>" name="id1">
            <div class="col-lg-5 pb-5">
                <div id="demo" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <?php 
                        $i=0;
                        foreach($result as $row){
                            $actives='';
                            if($i==0){
                                $actives='active';
                            }
                        ?>
                      <li data-target="#demo" data-slide-to="<?php echo $i; ?>" class="<?php echo $actives; ?>"></li>
                      <?php  $i++;
                        } ?>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                    <?php 
                        $i=0;
                        foreach($result as $row){
                            $actives='';
                            if($i==0){
                                $actives='active';
                            }
                        ?>
                      <div class="carousel-item <?php echo $actives; ?>">
                      <input type="hidden" value="<?php echo $row['product_img']; ?>" name="img">
                        <img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" class="w-100 h-100">
                      </div>
                      <?php  $i++;
                        } ?>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                      <span class="carousel-control-prev-icon bg-dark"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                      <span class="carousel-control-next-icon bg-dark"></span>
                    </a>

                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <input type="hidden" value="<?php echo $row['product_name'];?>" name="name1">
                <h3 class="font-weight-semi-bold" >Colorful <?php echo $row['product_name'];?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <?php 
                        $avg=mysqli_query($conn,"SELECT AVG(rating) FROM review WHERE product_id='$row[product_id]'");
                        while($average=mysqli_fetch_array($avg)){?>
                            <div class="rateyo" id= "rating"
                                data-rateyo-rating="<?php echo $average['AVG(rating)']; ?>"
                                data-rateyo-num-stars="5"
                                data-rateyo-score="3">
                            </div>
                        <?php }
                        ?>

                    </div>
                    <?php 
                    $review=0;
                    $count="SELECT * FROM review WHERE product_id='$row[product_id]'";
                    $connect=$conn->query($count);
                    if($total=$connect->num_rows){
                        $review=$total;
                    }
                    ?>
                    <h5 class="pt-1">( 
                    <?php if($review <= 1){
                        echo $review ." Review";
                    }else{
                        echo $review ." Reviews";
                    } ?>)</h5>
                </div>
                <input type="hidden" name="price1" id="price1">
                <h3 class="font-weight-semi-bold mb-4" id="price">$ <?php if(isset($_POST['price'])){ echo $_POST['price'];}else{ echo $row['price'];} ?></h3>
                <p class="mb-4" id="words">Buy what you don’t have yet, or what you really want, which can be mixed with what you already own. Buy only because something excites you, not just for the simple act of shopping.</p>
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Color:</p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="color" value="<?php echo $row['color']; ?>" checked class="custom-control-input" id="color-1" name="color">
                            <label class="custom-control-label" for="color-1"><?php echo $row['color']; ?></label>
                        </div>
                </div>
                <div class="d-flex mb-4">
                    <label class="text-dark font-weight-medium mb-0 mr-3 mt-2" for="size">Size:</label>
                        <div class="custom-control  custom-control-inline">
                            <?php
                            $querys="SELECT * FROM mens_size WHERE product_id='$row[product_id]'";
                            $results=$conn->query($querys);
                            foreach($results as $rows){
                                echo "<input type='hidden' value='$rows[product_id]' id='ids'>";
                            }
                            ?>
                            <select class="form-control size" required id="size" name="size1" onclick="display()">
                                <option value="" disabled selected>Select size</option>
                                <?php  
                                $query1="SELECT * FROM mens_size WHERE product_id='$row[product_id]'";
                                $result1=$conn->query($query1);
                                foreach($result1 as $row1){
                                    echo "<option value='$row1[size]'>$row1[size]</option>";
                                }
                                ?>
                            </select>
                        </div>
                            </div>
                <div class="d-flex align-items-center mb-4 pt-2">

                    <div class="input-group quantity mr-3" id="quantity" style="width: 130px;">
                        <input type="number" name="quantity" class="form-control bg-secondary text-center" min="1" max="1"  value="1">
                    </div>
                    <button type="submit" name="cart" onclick="return checkQuantity()" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                    <button type="submit" name="order"  class="ml-2 btn btn-primary px-3"><i class="fa fa-credit-card mr-1"></i> Place order</button>
                </div>
            </div>
        </form>
        <?php }?>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <?php 
                    $review=0;
                    $count="SELECT * FROM review WHERE product_id='$id'";
                    $connect=$conn->query($count);
                    if($total=$connect->num_rows){
                        $review=$total;
                    }
                    ?>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">
                        <?php if($review <= 1){
                        echo "Review (".$review.")";
                    }else{
                        echo "Reviews (".$review.")";
                    } ?></a>
                </div>
                <div class="tab-content">
                <?php  
                    $query2="SELECT * FROM mens WHERE product_id='$id'";
                    $result2=$conn->query($query2);
                    while($row2=$result2->fetch_array(MYSQLI_ASSOC)){?>
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p><?php echo $row2['description']; ?></p>
                        
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p><?php echo $row2['information']; ?></p>
                    </div>
                    <?php  }?>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <?php 
                        $query="SELECT  * FROM mens WHERE product_id='$id'";
                        $result=$conn->query($query);
                        while($rows=$result->fetch_array(MYSQLI_ASSOC)){
                            $sql="SELECT * FROM review WHERE product_id='$id'";
                            $result1=$conn->query($sql);
                            while($row1=$result1->fetch_array(MYSQLI_ASSOC)){?>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">Review for "<?php echo $row1['product_name']; ?>"</h4>
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h6><?php echo $row1['name']; ?><small> - <i><?php echo $row1['date']; ?></i></small></h6>
                                        <div class="text-primary mb-2">
                                            <div class="rateyo" id= "rating"
                                                data-rateyo-rating="<?php echo $row1['rating'] ?>"
                                                data-rateyo-num-stars="5"
                                                data-rateyo-score="3">
                                            </div>
                                        </div>
                                        <p><?php echo $row1['message']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <form class="mt-3" method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $rows['product_id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $rows['product_name']; ?>">
                                    <div class="form-group d-flex post-action">
                                        <p class="mb-0 mr-2 mt-2">Your Rating * :</p>
                                            <div class="rateyo" id= "rating"
                                            data-rateyo-rating="0"
                                            data-rateyo-num-stars="5"
                                            data-rateyo-score="3">
                                            </div>
                                            <span class='ml-3 result mt-2'>Rating: 0</span>
                                            <input type="hidden" name="rating">
                                        </div>
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea name="message" required cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" name="save" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php }
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }else{
        header("Location: login");
    }
    ?>
<!-- <i class="fas fa-star star-light submit_star" data-rating="1" id="submit_star-1"></i>
<i class="fas fa-star star-light submit_star" data-rating="2" id="submit_star-2"></i>
<i class="fas fa-star star-light submit_star" data-rating="3" id="submit_star-3"></i>
<i class="fas fa-star star-light submit_star" data-rating="4" id="submit_star-4"></i>
<i class="fas fa-star star-light submit_star" data-rating="5" id="submit_star-5"></i> -->