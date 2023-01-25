<?php
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link href="/evomas/css/login.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>My-shop</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script>
    function preventback() {
      window.history.forward();
    }
    setTimeout("preventback()", 0);
    window.onunload = function() {
      null
    };
  </script>
</head>

<body>
  <?php include('__template/__login.php') ?>
  <script src="js/validate.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    function checkLoginState() { // Called when a person is finished with the Login Button.
      FB.getLoginStatus(function(response) { // See the onlogin handler
        if (response.status === 'connected') { // Logged into your webpage and Facebook.
          FB.api('/me', function(response) {
            $.ajax({
              type: 'post',
              url: 'fb-login.php',
              data: {
                id: response.id,
                name: response.name,
              },
              success: function(data) {
                if (data == "Login successfully") {
                  window.location.href="index?user=<?php echo base64_encode(strrev(session::get('id')));?>";
                }else if("login successfully"){
                    alert('Something went wrong! try again login with facebook!');
                }else{
                  alert(data);
                  window.location.href="login";
                }
              }

            });
          });
        } else { // Not logged into your webpage or we are unable to tell.
          alert("Sorry. you can't login with facebook. try another option to login!");
        }


      });
    }
    window.fbAsyncInit = function() {
      FB.init({
        appId: 'YOUR_APP_ID', //Facebook app id
        cookie: true,
        xfbml: true, // Enable cookies to allow the server to access the session.
        version: 'v15.0' // Use this Graph API version for this call.
      });
    };
    if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
  </script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
</body>

</html>