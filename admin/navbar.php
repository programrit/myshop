<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
	<!-- Navbar Brand-->
	<a class="navbar-brand ps-3" href="index?user=<?php echo base64_encode(strrev($user1)); ?>">Admin Panel</a>
	<!-- Sidebar Toggle-->
	<button style="color: white;" class="btn btn-link  btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href=""><i 
			class="fas fa-bars"></i></button>
			<div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
		<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<?php  
				$sql="SELECT * FROM admin_user WHERE email='$user1'";
				$results=$conn->query($sql);
				$rows=$results->fetch_assoc();
				if(isset($rows["profile"])==null || empty($rows["profile"])){?>
				<i class="fas fa-user fa-fw"></i>
				<?php }else{?>
					<img src="/my-shop/admin/avatar/<?php echo $rows["profile"]; ?>" style="width: 30px;">
				<?php }
				?>
				</a>
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
					<li><a class="dropdown-item" href="profile.php">Profile</a></li>
					<li><a class="dropdown-item" href="setting">Settings</a></li>
					<li>
						<hr class="dropdown-divider" />
					</li>
					<li><a class="dropdown-item" href="logout">Logout</a></li>
				</ul>
			</li>
		</ul>
</nav>