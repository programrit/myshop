<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" novalidate enctype="multipart/form-data">
                <?php
                $query = "SELECT * FROM user WHERE username='$user1'";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                $id = $row['id'];
                ?>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="col-md-12">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-12">
                        <label for="">Date of birth</label>
                        <input type="date" class="form-control" name="birth" required>
                    </div>
                    <div class="col-md-12">
                        <label for="">Address</label>
                        <textarea class="form-control" name="address" required minlength="5" maxlength="100"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="">Avatar</label>
                        <input type="file" class="form-control" name="avatar" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" name="save" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
                <p class="text-center text-danger mt-1 mx-auto ml-2">Update your profile!</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" novalidate enctype="multipart/form-data">
                <?php
                $query = "SELECT * FROM user WHERE username='$user1'";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                $id = $row['id'];
                $fetch = "SELECT * FROM profile WHERE user_id='$id'";
                $fetched = $conn->query($fetch);
                while ($rows = $fetched->fetch_assoc()) { ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="col-md-12">
                            <label for="">Name</label>
                            <input type="text" class="form-control" value="<?php if (isset($rows['name'])) {
                                                                                echo $rows['name'];
                                                                            } else {
                                                                                null;
                                                                            } ?>" name="name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="">Date of birth</label>
                            <input type="date" class="form-control" value="<?php if (isset($rows['date_of_birth'])) {
                                                                                echo $rows['date_of_birth'];
                                                                            } else {
                                                                                null;
                                                                            } ?>" name="birth" required>
                        </div>
                        <div class="col-md-12">
                            <label for="">Address</label>
                            <textarea class="form-control" name="address" required minlength="5" maxlength="100"><?php if (isset($rows['address'])) {
                                                                                                                        echo $rows['address'];
                                                                                                                    } else {
                                                                                                                        null;
                                                                                                                    } ?>
                </textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="">Avatar</label>
                            <input type="file" value="<?php if (isset($rows['avatar'])) {
                                                            echo $rows['avatar'];
                                                        } else {
                                                            null;
                                                        } ?>" class="form-control" name="avatar">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <?php
                        if (isset($rows['name']) && isset($rows["date_of_birth"])) { ?>
                            <button type="reset mt-2" class="btn btn-danger">Cancel</button>
                            <button type="submit mt-2" name="update" class="btn btn-info">Update</button>
                        <?php } else { ?>
                            <button disabled type="reset" class="btn btn-danger">Cancel</button>
                            <button disabled type="submit" name="update" class="btn btn-info">Update</button>
                        <?php }
                        ?>
                    <?php } ?>
                    <?php
                    $query2 = "SELECT * FROM user WHERE username='$user1'";
                    $result2 = $conn->query($query2);
                    $row2 = $result2->fetch_assoc();
                    if (empty($row2["password"])) { ?>
                        <button class="btn btn-success ml-2 mb-3 mt-3" disabled type="button" name="change_password">Change password</button>
                    <?php } else { ?>
                        <button class="btn btn-success ml-2 mb-3 mt-3" type="submit" name="change_password">Change password</button>
                    <?php }
                    ?>

                    </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
            <a href="" class="text-decoration-none d-block d-lg-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <?php
                        $query1 = "SELECT * FROM user WHERE username='$user1'";
                        $result1 = $conn->query($query1);
                        $row1 = $result1->fetch_assoc();
                        $id1 = $row1['id'];
                        $select = "SELECT * FROM profile WHERE user_id='$id1'";
                        $selected = $conn->query($select);
                        $row2 = $selected->fetch_assoc();
                        ?>
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <?php
                            if (isset($row2["avatar"])) { ?>
                                <img class="rounded-circle img-fluid" src="/my-shop/profile/<?php echo $row2["avatar"]; ?>" style="width: 20px;">
                            <?php } else {
                                echo "User";
                            }
                            ?>
                        </a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="profile" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Profile</a>
                            <a href="setting" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal1">Settings</a>
                            <a href="logout" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <?php
                $query1 = "SELECT * FROM user WHERE username='$user1'";
                $result1 = $conn->query($query1);
                $row1 = $result1->fetch_assoc();
                $id1 = $row1['id'];
                $select = "SELECT * FROM profile WHERE user_id='$id1'";
                $selected = $conn->query($select);
                $row2 = $selected->fetch_assoc();
                ?>
                <h5 class="mt-2 ml-5 mx-auto mr-auto">Welcome <?php if (isset($row2["name"])) {
                                                                    echo ucfirst($row2["name"]);
                                                                } else {
                                                                    echo ucfirst($user1);
                                                                } ?></h5>
            </div>

        </nav>
        <div id="carouselExampleControls" class="carousel slide py-3 carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" style="height: 30rem;">
                    <img class="d-flex w-100 h-100" src="/my-shop/img/img-1.jpg" alt="First slide">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3 ml-5 pl-5" style="max-width: 576px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-4">10% Off Your First Order</h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-5">Reasonable Price</h3>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height: 30rem;">
                    <img class="d-flex w-100 h-100" src="/my-shop/img/img-2.jpg" alt="Second slide">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3 ml-5 pl-5" style="max-width: 576px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="height: 30rem;">
                    <img class="d-flex w-100 h-100" src="/my-shop/img/img-3.jpg" alt="Third slide">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3 ml-5 pl-5" style="max-width: 576px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-4">Good Quantity</h3>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>