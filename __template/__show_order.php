<div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Order date</th>
                            <th>Delivery Mood</th>
                            <th>Status</th>
                            <th>Cancel</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                            $rows=mysqli_fetch_array($sql);
                            $user=$rows['id'];
                            $query="SELECT * FROM checkout WHERE user_id='$user'";
                            $result=$conn->query($query);
                            while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                        <tr>
                            <td class="align-middle"><?php echo $row['order_id']; ?></td>
                            <td class="align-middle">Colorful <?php echo $row['product_name']; ?></td>
                            <td class="align-middle"><img src="/my-shop/admin/men_img/<?php echo $row['product_img']; ?>" alt="" style="width: 50px;"></td>
                            <td class="align-middle"><?php echo $row['color']; ?></td>
                            <td class="align-middle"><?php echo $row['size']; ?></td>
                            <td class="align-middle"><?php echo $row['quantity']; ?></td>
                            <td class="align-middle">₹<?php echo $row['price']; ?></td>
                            <td class=""><?php echo $row['time']; ?></td>
                            <td class=""><?php echo $row['delivery']; ?></td>
                            <td class="align-middle"><?php 
                            if($row['status']=="pending"){ 
                                echo "<p class='text-info mt-3'>Pending</p>";
                            } else if($row['status']=="confirm"){
                                echo "<p class='text-warning mt-3'>Confirmed</p>";
                            }else if($row['status']=="delivery"){
                                $query1="UPDATE cart SET active='0' WHERE user_id='$user' AND product_id='$row[product_id]' AND size='$row[size]'";
                                $result1=$conn->query($query1);
                                if($result1===TRUE){
                                    echo "<p class='text-success mt-3'>Deliverted</p>";
                                }else{
                                    echo "<p class='text-success mt-3'>Something went wrong</p>";
                                }
                            }else{
                                $query2="UPDATE cart SET active='0' WHERE user_id='$user' AND product_id='$row[product_id]' AND size='$row[size]'";
                                $result2=$conn->query($query2);
                                if($result2===TRUE){
                                echo "<p class='text-danger mt-3'>Cancelled</p>";
                                }else{
                                    echo "<p class='text-danger mt-3'>Something went wrong</p>";
                                }
                            }
                                ?></td>
                                <?php  
                                if($row['status']=="pending" || $row['status']=="confirm"|| $row['status']=="delivery"){?>
                                    <form action="" method="POST">
                                        <td class="align-middle"><button type="submit" onclick="return checkdelete()" name="remove" value="<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                                </form>
                                <?php }else{?>
                                    <td class="align-middle"><button type="button" disabled class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td> 
                                <?php }
                                ?>
                        </tr>
                        <?php }?>
                </table>
            </div>
            
        </div>
    </div>