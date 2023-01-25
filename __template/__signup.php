<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ('phpmailer/src/Exception.php'); 
require ('phpmailer/src/PHPMailer.php');
require ('phpmailer/src/SMTP.php');

include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
session::start();
$conn=DB::db();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$signup=false;
$user=false;
if(isset($_POST["submit"])){
    $username=$conn->real_escape_string($_POST["username"]);
    $email=$conn->real_escape_string($_POST["email"]);
    $phone=$conn->real_escape_string($_POST["phone"]);
    $password=$conn->real_escape_string($_POST["password"]);
    $password1=$conn->real_escape_string($_POST["password1"]);
	$username=htmlspecialchars($username);
	$email=htmlspecialchars($email);
	$phone=htmlspecialchars($phone);
	$password=htmlspecialchars($password);
	$password1=htmlspecialchars($password1);
	$token=md5(rand());
	if($password==$password1){
		$user=user::signup($username, $email, $phone, $password, $password1,$token);
		$signup=true;
	}else{
		header("Location: signup.php?exist=password not match!");
		echo"<script>window.location.href='/my-shop/signup'</script>";
	}
   
}
if($user==true && $signup==true){
	$subject="Email verfication";
	$body="
	<div style='border: 1px solid gray; border-radius: 5px;'>
		<p style='text-align: center;'>My-shop</p>
		<h3 style='text-align: center;'>Verfication email</h3>
		<hr>
		<p style='margin-left: 20px; margin-top: 30px;'>Please use the verfication button below to click login</p>
		<button style='background-color: red; border: 1px solid white; border-radius: 4px; width: 80px; height: 40px; margin-left: 45%;'><a href='http://localhost/my-shop/verify-email?token=$token' style='text-decoration: none; color: white; font-size: 18px;'>Active</a></button>
		<p style='margin-left: 20px;'>Don't share link with anyone.This link expire with in 15 minutes</p>
	</div>
	<p style='color: grey; margin-left: 20px;'>You receviwed this email to let you know about important login with My-shop</p>
	<p style='color: grey; margin-left: 20px;'>@ 2023 My-shop website Srivilliputhur Virudhunagar Tamilnadu,India</p>
	";
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host='smtp.gmail.com';
	$mail->SMTPAuth=true;
	$mail->Username='YOUR_EMAIL_ADDRESS';  
	$mail->Password='YOUR_APP_PASSWORD'; 
	$mail->SMTPSecure='ssl';
	$mail->Port=465;
	$mail->setFrom('YOUR_EMAIL_ADDRESS');
	$mail->addAddress($email);
	$mail->isHTML(true);
	$mail->Subject=$subject;
	$mail->Body=$body;
	$mail->send();
	if($mail->send()){
		echo "<script>alert('Registration successful!. please verify your email')</script>";
		header("refresh:1 url=signup");
	}else{
		echo "<script>alert('Registration failed!. please try again later')</script>";
		header("refresh:1 url=signup");
	}

}else{?>
<section class="vh-100" style="background-color: pink;">
		<div class="container-fluid py-3 h-custom">
			<div class="row d-flex">
				<div class="col-md-4 mx-auto rounded bg-white mt-1">
					<div><?php
                    if (isset($_GET['exist'])) {?>
						<div class="text-danger text-center alert alert-danger mt-2" role="alert">
							<?php 
							$exist=$conn->real_escape_string($_GET['exist']);
							$exist=htmlspecialchars($exist);
							echo $exist;
							?>
						</div>
						<?php }?>
					</div>
					<form action="signup" method="post" class="needs-validation" novalidate>
						<h3 class="text-center py-1 mt-1">Signup</h3>
						<div class="form-outline col-md-8 mx-auto">
							<input type="text" id="form1Example13" name="username" placeholder="Username"
								class="form-control" pattern="[a-zA-Z]{3,}[0-9]{2,}" required />
							<div class="invalid-feedback"> Must be 3 letter and 2 number!</div>
							<label class="form-label" for="form1Example13"></label>
						</div>
						<div class="form-outline col-md-8 mx-auto">
							<input type="email" id="form1Example13" name="email" placeholder="Email Address"
								class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required />
							<div class="invalid-feedback">Enter valid email!</div>
							<label class="form-label" for="form1Example13"></label>
						</div>
						<div class="form-outline col-md-8 mx-auto">
							<input type="number" id="form1Example13" name="phone" placeholder="Phone no"
								pattern="[6-9]{1}[0-9]{9}" class="form-control" required />
							<div class="invalid-feedback">Must be 10 numbers only!</div>
							<label class="form-label" for="form1Example13"></label>
						</div>
						<div class="form-outline col-md-8 mx-auto">
							<input type="password" id="password2" name="password" placeholder="Password"
								class="form-control" required
								pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$"/>
							<div class="invalid-feedback"> Must be use 1 special char and 1 capital letter!</div>
							<label class="form-label" for="password2" htmlFor="password"></label>
						</div>
						<div class="form-outline col-md-8 mx-auto">
							<input type="password" id="confirm_password" name="password1" placeholder="Repeat-password"
								class="form-control" required
								pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_+=-]).{8,15}$" />
							<div class="invalid-feedback">Must be use 1 special char and 1 capital letter!</div>
							<label class="form-label" for="confirm_password"></label>
						</div>
						<div class="text-center mt-1 col-md-12">
							<button type="submit" class="btn btn-primary" name="submit">Signup</button>
							<button type="reset" class="btn btn-danger">Cancel</button>	
						</div>
						<p class="small fw-bold mt-2 pt-1 mb-0 text-center mb-3">Already account <a href="login"
									class="link-danger">Login</a></p>
					</form>
				</div>
			</div>
		</div>
	</section>

<?php }?>
