<div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Order Id</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Time</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                            $sql=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
                            $rows=mysqli_fetch_array($sql);
                            $user=$rows['id'];
                            $query="SELECT * FROM orders WHERE user_id='$user'";
                            $result=$conn->query($query);
                            while($row=$result->fetch_array(MYSQLI_ASSOC)){?>
                        <tr>
                            <td class="align-middle"><?php echo $row['order_id']; ?></td>
                            <td class="align-middle"><?php echo $row['name']; ?></td>
                            <td class="align-middle"><?php echo $row["phone"] ?></td>
                            <td class="align-middle"><?php echo $row['address']; ?></td>
                            <td class="align-middle"><?php echo $row['time']; ?></td>
                            <td class="align-middle"><button type="button" name="view" class="btn btn-sm btn-primary rounded"><a style="text-decoration: none;" class="text-white" href="order-detail?id=<?php echo base64_encode($row['order_id']); ?>">View detail</a></button></td>
                        </tr>
                        <?php }?>
                </table>
            </div>
            
        </div>
    </div>