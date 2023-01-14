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

$clientId="YOUR_CLIENT_ID";
$clientSecret="YOUR_SECRET_KEY";
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
	session::set('username', $username);
	header("Location: index?user=".base64_encode(strrev($username)));
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
    session::set('username', $user->getUsername());
    
    header("Location: index?user=".base64_encode(strrev($user->getUsername())));
} else {?>
<section class="vh-150" style="background-color: pink;">
	<div class="container-fluid h-custom py-3">
		<div class="row d-flex">
			<div class="col-md-8">
				<img src="/my-shop/img/shopping.webp" class="w-100 h-100 rounded" style="max-width:100%;" alt="Sample image">
			</div>
			<div class="col-md-3 mx-auto  rounded">
				<div><?php
          if (isset($_GET['exist'])) {?>
					<div class="text-danger text-center alert alert-danger" role="alert">
						<?php echo $_GET['exist']?>
					</div>
					<?php }?>
					<form action="login" method="post" class="needs-validation" novalidate>
						<h3 class="py-3 text-center">Login</h3>
						<div class="form-outline">
							<input type="email" name="email" id="form3Example3" class="form-control"
								placeholder="Enter a valid email address" required />
							<div class="invalid-feedback">Enter valid email!</div>
							<label class="form-label" for="form3Example3"></label>
						</div>
						<div class="form-outline">
							<input type="password" name="password" id="form3Example4" class="form-control"
								placeholder="Enter password" required />
							<div class="invalid-feedback">Enter valid password!</div>
							<label class="form-label" for="form3Example4"></label>
						</div>
						<div class="d-flex justify-content-between align-items-center">
            				<div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6Le-d1QjAAAAAKqh1JPMzZ_reMwUkdB32bUmB45N" required></div>
          				</div>
						<a href="email-verfication" class="text-body mt-2 col-md-12 text-center">Forgot password</a>
						<div class="text-center mt-4 col-md-12">
							<button type="submit" class="btn btn-primary" name="submit">Login</button>
							<button type="reset" class="btn btn-danger">Cancel</button>
								<p class="text-dark text-center mt-3">or</p>
								<div class="btn-group text-center mt-1">
									<button class="btn border-primary"><img class="rounded bg-white" style="width: 20px; background-color: none;" src="/img/OIP.jpeg"></button><button class="btn btn-primary"><a style="text-decoration: none;" class="text-white" href="<?php echo $client->createAuthUrl(); ?>">Login with google</a></button>
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