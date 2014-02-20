<?php

session_start();

$_SESSION['url'] = $_GET['sip'];

$appBaseUrl = "http://facebook.sensukho.com/fblogin/acces.html?sip=".$_SESSION['url'];

require 'fb-sdk-php/src/facebook.php';
 
$facebook = new Facebook(array(
  'appId'  => '443525242405417',
  'secret' => '79a26666bce7a0b4570e85f770fd5e17',
));
 
$user = $facebook->getUser();
  
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
}else {
  $loginUrl = $facebook->getLoginUrl(array(
                'scope' => 'email,user_birthday'
            ));
}
 
if (!$user){
  echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
  exit;
}else{
  header("Location: " . $appBaseUrl);
}
 
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>FACEBOOK Auth.</title>
        <style typ="text/css">
            html, body { width: 520px;}
        </style>    
  </head>
  <body>
    <h1><?php echo $_SESSION['url']; ?></h1>
  </body>
</html>
