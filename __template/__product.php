<div class="container pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">All collection</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="d-flex justify-content-between col-md-6 pb-1">
            <?php 
                $limit=5;
                $page=$conn->real_escape_string(isset($_GET["page"])?$_GET["page"]:1);
                $page=htmlspecialchars($page);
                if($page==null){
                    $location=base64_encode(strrev($user2));
                    echo "<script>alert('Page is not found!')</script>";
                    echo "<script>window.location.href='index?user=$location'</script>";
                }else{
                    $start=($page - 1)*$limit;
                    $query="SELECT * FROM mens LIMIT $start,$limit";
                    $result=$conn->query($query);
                    while($row=$result->fetch_array(MYSQLI_ASSOC)){
                        $query1="SELECT COUNT(product_id) FROM mens";
                        $result1=$conn->query($query1);
                        $row1=$result1->fetch_array(MYSQLI_ASSOC);
                        $total=$row1['COUNT(product_id)'];
                        $pages=ceil($total / $limit);
                        $previous=$page-1;
                        $next=$page+1;?>
                
                <div class="card product-item col-lg-6 border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <?php
                    $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                    $row1=mysqli_fetch_array($sql);
                    $data=$row1['product_img'];
                    $data=explode(" ",$data);
                    $count=count($data)-1;
                    for($i=0;$i<$count;$i++){?>
                        <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>">
                    <?php }
                    ?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3"><?php echo $row['product_name'] ?></h6>
                        <div class="d-flex justify-content-center">
                        <h6>₹ <?php  echo $row['price'];?></h6><h6 class="text-muted ml-2"><del>₹ <?php echo $row['mrp']; ?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                    <a href="detail?id=<?php echo base64_encode($row['product_id']); ?>" class="btn btn-sm text-dark  p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    </div>
                </div>
                <?php  }?>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php 
            $disabled='disabled';
            ?>
          <li class="page-item <?php if($page==1){ echo $disabled;} ?>">
            <a class="page-link" href="index?user=<?php echo base64_encode(strrev($user2));?>&page=<?php echo $previous;?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php 
          $active='active';
          if($pages){
            for($i=1;$i<=$pages;$i++){
                ?>
                <li class="page-item <?php if($i==$page){ echo $active;}?>"><a class="page-link" href="index?user=<?php echo base64_encode(strrev($user2));?>&page=<?php echo $i;?>"><?php echo $i;?></a></li>
              <?php }
          }else{
            $location=base64_encode(strrev($user2));
            echo "<script>alert('Page is not found!')</script>";
            echo "<script>window.location.href='index?user=$location'</script>";
          }
          ?> 
          <?php 
            $disabled='disabled';
            ?>
          <li class="page-item <?php if($page==$pages){ echo $disabled;} ?>">
            <a class="page-link" href="index?user=<?php echo base64_encode(strrev($user2));?>&page=<?php echo $next;?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
    </nav>
    <?php }?>