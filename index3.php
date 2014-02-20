<?php

session_start();

$_SESSION['url'] = $_GET['sip'];

$appBaseUrl = "http://189.203.102.52:1780/fblogin/acces.html?sip=".$_SESSION['url'];

require_once("fb-sdk-php/src/facebook.php");

$config = array(
	'appId' => '443525242405417',
	'secret' => '79a26666bce7a0b4570e85f770fd5e17',
	'fileUpload' => false, // optional
	'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
);

$params = array(
	'scope' => 'read_stream, friends_likes',
	'redirect_uri' => 'http://facebook.sensukho.com/fblogin/acces.html',
	'display' => ' popup'
);

$facebook = new Facebook($config);

$user = $facebook->getUser();

if (!$user){
  echo '<a href="<?php echo $facebook->getLoginUrl(); ?>">ENTRAR</a>';
}else{
  header("Location: " . $appBaseUrl);
}

?>