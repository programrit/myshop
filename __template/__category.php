<div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">All Categories</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <?php
                $query="SELECT * FROM mens WHERE category='men'";
                $result=$conn->query($query);
                if ($row=$result->num_rows){
                    $count=$row;
                }
                if($count <=1){?>
                    <p class="text-right"> <?php  echo $count; ?> Product</p>
                <?php }else if($count==null){?>
                        <p class="text-right">0 Product</p>
                    <?php }else{?>
                    <p class="text-right"> <?php  echo $count; ?> Products</p>
                <?php }
                ?>
                    <a href="mens" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-1.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Men's dresses</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <?php
                $count1=null;
                $query1="SELECT * FROM mens WHERE category='women'";
                $result1=$conn->query($query1);
                if ($row1=$result1->num_rows){
                    $count1=$row1;
                }
                if($count1 ==1){?>
                    <p class="text-right"> <?php  echo $count1; ?> Product</p>
                <?php }else if($count1==null){?>
                        <p class="text-right">0 Product</p>
                    <?php }else{?>
                    <p class="text-right"> <?php  echo $count1; ?> Products</p>
                <?php }
                ?>
                    <a href="womens" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-2.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Women's dresses</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <?php
                $count2=null;
                if( $query2="SELECT * FROM mens WHERE category='kid'"){
                    $result2=$conn->query($query2);
                    if ($row2=$result2->num_rows){
                        $count2=$row2;
                    }
                    if($count2 ==1 ){?>
                        <p class="text-right"> <?php  echo $count2; ?> Product</p>
                    <?php }else if($count2==null){?>
                        <p class="text-right">0 Product</p>
                    <?php }else{?>
                        <p class="text-right"> <?php  echo $count2; ?> Products</p>
                    <?php }?>
                <?php }else{?>
                    <p class="text-right"> 0 Products</p>
               <?php  }?>
                    <a href="kids" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-3.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Kid's dresses</h5>
                </div>
            </div>
        </div>
    </div>