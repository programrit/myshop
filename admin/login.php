<?php
include('../include/admin_session.class.php');
include('../include/admin.class.php');
include('../include/databse.class.php');
$conn=DB::db();
admin_session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
$signup=false;
$user=null;
if(isset($_POST["submit"])){
    $email=$conn->real_escape_string($_POST["email"]);
    $password=$conn->real_escape_string($_POST["password"]);
    $email=htmlspecialchars($email);
    $password=htmlspecialchars($password);
    $captcha=$_POST["g-recaptcha-response"];
	  $secretkey="6Le-d1QjAAAAAASzHIfv9FVcbT7vk2le67vmj8dh";
	  $url='https://www.google.com/recaptcha/api/siteverify?secret='.urldecode($secretkey).'&response='.urldecode($captcha).'';
	  $response=file_get_contents($url);
	  $responseKey= json_decode($response, TRUE);
    if($responseKey["success"]){
      $user=admin::admin_users($email, $password);
      $signup=true;
    }else{
      header("Location: login?exist=Please check capcha!");
		  $login=false;
    }
}
if($signup){
  admin_session::set('is_login', true);
  admin_session::set('email',$user->getEmail());
  $update=mysqli_query($conn,"UPDATE admin_user SET active='1' WHERE email='$email'");
  header("Location: index?user=".base64_encode(strrev($user->getEmail())));
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/evomas/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Eshop</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    function preventback(){
      window.history.forward();
    }
    setTimeout("preventback()", 0);
    window.onunload=function(){ null };
  </script>
  </head>
  <body>
    <section class="vh-100">
  <div class="container-fluid h-custom py-2">
    <div class="row d-flex justify-content-center align-items-center h-50">
      <div class="col-md-9 col-lg-7 col-xl-6">
        <img src="/evomas/img/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-3  mx-auto">
      <div>
      <form action="login" method="POST" class="needs-validation" novalidate> 
      <div><?php
                    if (isset($_GET['exist'])) {?>
						<div class="text-danger text-center alert alert-danger" role="alert">
							<?php echo $_GET['exist']?>
						</div>
						<?php }?>
					</div>
      <h3 class="py-3 text-center">Admin Login</h3>
          <div class="form-outline">
            <input type="text" name="email" id="form3Example3" class="form-control"
              placeholder="Enter your username" required />
              <div class="invalid-feedback">Enter valid username!</div>
            <label class="form-label" for="form3Example3"></label>
          </div>
          <div class="form-outline">
            <input type="password" name="password" id="form3Example4" class="form-control"
              placeholder="Enter your password" required/>
              <div class="invalid-feedback">Enter valid password!</div>
            <label class="form-label" for="form3Example4"></label>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6Le-d1QjAAAAAKqh1JPMzZ_reMwUkdB32bUmB45N" required></div>
          </div>
          <a href="forget-password" class="text-body mt-1">Forgot password</a>

          <div class="mt-3 col-md-12 text-center">
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
            <button type="reset" class="btn btn-danger">Cancel</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div>
</section>
<script src="../js/validate.js"></script>
	<script>
		setTimeout("preventback()", 0);
    window.onunload=function(){ null };
    if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
    }
	</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
