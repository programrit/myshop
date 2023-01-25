<?php
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
require "vendor/autoload.php";

$clientId="677996261588-6rgn5350qrebmqptf01486e9e8eeeuhl.apps.googleusercontent.com";
$clientSecret="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";
$clientUri="http://localhost/my-shop/login";

$client=new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($clientUri);
$client->addScope("email");
$client->addScope("profile");
$login=false;
$user=null;
$users=null;
$update=null;
if(isset($_GET["code"])){
	$token=$client->fetchAccessTokenWithAuthCode($_GET["code"]);
	if(!isset($token["error"])){
		$client->setAccessToken($token["access_token"]);
		$_SESSION["access_token"]=$token["access_token"];
		$obj=new Google\Service\Oauth2($client);
		$data=$obj->userinfo->get();
		$email=$data["email"];
		$username=$data["name"];
		$pic=$data["picture"];
		$users=user::login_with_google($email,$username);
		$login=true;
	}else{
		header("Location: login?exist=Something went wrong please try agin later!");
		$login=false;
	}
}
if($users==true && $login==true){
	session::set('is_login', true);
	$sqls=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
	$row1=mysqli_fetch_array($sqls);
	$id=$row1["user_id"];
	session::set('username', $username);
	session::set('id', $id);
	header("Location: index?user=".base64_encode(strrev($id)));
}

if (isset($_POST["submit"])) {
    $email=$conn->real_escape_string($_POST["email"]);
    $password=$conn->real_escape_string($_POST["password"]);
	$email=htmlspecialchars($email);
	$password=htmlspecialchars($password);
	$captcha=$_POST["g-recaptcha-response"];
	$secretkey="YOUR_SECRET_KEY";
	$url='https://www.google.com/recaptcha/api/siteverify?secret='.urldecode($secretkey).'&response='.urldecode($captcha).'';
	$response=file_get_contents($url);
	$responseKey= json_decode($response, TRUE);
	if($responseKey["success"]){
		$sql="SELECT * FROM user WHERE email='$email'";
		$result=$conn->query($sql);
		$row=$result->fetch_assoc();
		if($row["token"] && $row["active_token"]=="1"){
			$user=user::login($email, $password);
    		$login=true;
    		$username=$user->getUsername();
    		$active=1;
    		$update=user::update($active,$username);
		}else{
			header("Location: login?exist=Your account is not active. please check your email!");
			$login=false;
		}
	}else{
		header("Location: login?exist=Please check capcha!");
		$login=false;
	}
}
if ($login==true && $user==true) {
    session::set('is_login', true);
	$username=$user->getUsername();
	$sqls=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
	$row1=mysqli_fetch_array($sqls);
	$user_id=$row1["user_id"];
	session::set('username',$user->getUsername());
    session::set('id',$user_id);
    header("Location: index?user=".base64_encode(strrev($user_id)));
} else {?>
<section class="vh-100" style="background-color: pink;">
<div class="col-md-12 text-center bg-danger">
    <p class="text-white">If using for login with facebook sorry it's not ready to work properly yet. Because it is under construction. Use another way to login!</p>
  </div>
	<div class="container-fluid h-custom py-3">
		<div class="row d-flex">
			<div class="col-md-4 mx-auto  rounded bg-white">
				<div><?php
          if (isset($_GET['exist'])) {?>
					<div class="text-danger text-center alert alert-danger mt-2" role="alert">
						<?php echo $_GET['exist']?>
					</div>
					<?php }?>
					<form action="login" method="post" class="needs-validation" novalidate>
						<h3 class="text-center mt-2">Login</h3>
						<div class="form-outline col-md-8 mx-auto">
							<input type="email" name="email" id="form3Example3" class="form-control"
								placeholder="Enter a valid email address" required />
							<div class="invalid-feedback">Enter valid email!</div>
							<label class="form-label" for="form3Example3"></label>
						</div>
						<div class="form-outline col-md-8 mx-auto">
							<input type="password" name="password" id="form3Example4" class="form-control"
								placeholder="Enter password" required />
							<div class="invalid-feedback">Enter valid password!</div>
							<label class="form-label" for="form3Example4"></label>
						</div>
						<div class="d-flex justify-content-center align-items-center col-md-12">
            				<div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="YOUR_SITE_KEY" required></div>
          				</div>
						<div class="col-md-12 text-center mt-2">
						<a href="email-verfication" class="text-body mt-2 text-center">Forgot password</a>
						</div>
						<div class="text-center mt-4 col-md-12">
							<button type="submit" class="btn btn-primary" name="submit">Login</button>
							<button type="reset" class="btn btn-danger">Cancel</button>
								<p class="text-dark text-center mt-3 ">or</p>
								<div class="btn-group text-center mt-1">
									<button class="btn border-primary"><img class="rounded bg-white" style="width: 20px; background-color: none;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIFzZ6yEc4GKVDZRDdAL4NFhF5dmaze8x4gw&usqp=CAU"></button><button class="btn btn-primary"><a style="text-decoration: none;" class="text-white" href="<?php echo $client->createAuthUrl(); ?>">Login with google</a></button>
								</div>
								<div class="btn-group text-center mt-1">
									<button class="btn border-primary btn-primary" type="button" onclick="checkLoginState();"><i class="fa-brands fa-facebook"></i> Login with facebook</button>
								</div>
						</div>
						<p class="small fw-bold mt-2 pt-1 mb-0 text-center">Don't have an account <a href="/my-shop/signup" class="link-danger">Register</a></p><br>

					</form>
				</div>
			</div>
		</div>
		<div>
</section>

<?php } ?>