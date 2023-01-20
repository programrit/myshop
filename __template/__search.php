<?php
if($_GET['search']==null){
    echo"<script>alert('Search field is empty!')</script>";
    header("Refresh:1;url=index?user=".base64_encode(strrev($user1)));
}else{
    $search= $conn->real_escape_string($_GET['search']);
    $search=htmlspecialchars($search);
    ?>
     <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Search <?php echo $search;?></span></h2>
        </div>
        <div class="row px-xl-5  pb-3">
            <div class="d-flex justify-content-between col-md-6 pb-1">
            <?php  
                $query="SELECT * FROM mens WHERE product_name LIKE '%$search%' OR product_type LIKE '%$search%' OR category LIKE '%$search%' OR price LIKE '%$search%' OR mrp LIKE '%$search%'";
                $result=$conn->query($query);
                while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <?php
                    $sql=mysqli_query($conn, "SELECT * FROM mens WHERE product_id='$row[product_id]'");
                    $row1=mysqli_fetch_array($sql);
                    $data=$row1['product_img'];
                    $data=explode(" ",$data);
                    $count=count($data)-1;
                    for($i=0;$i<$count;$i++){?>
                        <img class="img-fluid w-100" src="/my-shop/admin/men_img/<?php print_r($data[$i]); ?>"height="40" width="45" class="mt-1">
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

<?php }



?>