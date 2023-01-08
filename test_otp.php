<?php

if(isset($_POST["otp"])){
    $num='91'.$_POST["num"];
    $otp=rand(100000, 999999);
    $otps=strval($otp);
    // Account details
   $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://2factor.in/API/V1/a925524e-8aa7-11ed-9158-0200cd936042/SMS/+91{$num}/{$otps}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

if($responseKey["Status"]=="Success"){
    echo "ok";
}else{
    echo "no";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    <input style="text-align:center" name="num" type="number">
    <input type="submit" name="otp" style="text-align:center">
    </form>
     
</body>
</html>

<!-- // $fields = array(
    //     "variables_values" => "$otp",
    //     "route" => "otp",
    //     "numbers" => "$num",
    // );
    
    // $curl = curl_init();
    
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 30,
    //   CURLOPT_SSL_VERIFYHOST => 0,
    //   CURLOPT_SSL_VERIFYPEER => 0,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "POST",
    //   CURLOPT_POSTFIELDS => json_encode($fields),
    //   CURLOPT_HTTPHEADER => array(
    //     "authorization: PISMXmvitHzE2N8TxVQW6BRUkr0ace5gJjA37pfyF9DCbO4KGsop6tX3xcJr9zebgB2AUGWLsHPdhiYl",
    //     "accept: */*",
    //     "cache-control: no-cache",
    //     "content-type: application/json"
    //   ),
    // ));
    
    // $response = curl_exec($curl);
    // $err = curl_error($curl);
    
    // curl_close($curl);
    
    // if ($err) {
    //   echo "cURL Error #:" . $err;
    // } else {
    //   echo $response;
    // } -->