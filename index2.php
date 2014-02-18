<?php
    $appBaseUrl =   "http://facebook.sensukho.com/fblogin/acces.html";
 
  /* 
     * Facebook dirige al usuario a la baseUrl tras autentificarlo
     * Comprobamos si nos ha devuelto un $_GET['code']
     * para redirigirlo al appBaseUrl 
     */
    if (isset($_GET['code'])){
        header("Location: " . $appBaseUrl);
        exit;
    }    
    
    
// Incluimos el PHP SDK v.3.0.0 de Facebook    
require 'fb-sdk-php/src/facebook.php';
 
// Creamos un nuevo objeto Facebook con los datos de nuestra aplicación (cambia los datos por los de tu App ID y tu App Secret).
$facebook = new Facebook(array(
  'appId'  => '443525242405417',
  'secret' => '79a26666bce7a0b4570e85f770fd5e17',
));
 
// Obtener el ID del Usuario
$user = $facebook->getUser();
 
// Podemos obtener o no este dato dependiendo de si el usuario se ha identificado en Facebook o no
 
if ($user) {
  try {
    // Procedemos a saber si tenemos a un usuario que se ha identificado en Facebook que está autentificado.
    // Si hay algún error se guarda en un archivo de texto (error_log)   
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
 
// la url de Login o Logout dependerá del estado actual del usuario, si está autentificado o no en nuestra aplicación
// Aquí obtenemos los permisos del usuario. Por defecto obtenemos una serie de permisos básicos
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(            array(
                'scope'         => 'email,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown'
            ));
}
 
    if (!$user) {
        echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
        exit;
    }
 
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk 3.0.0</title>
        <style typ="text/css">
            html, body { width: 520px;}
        </style>    
  </head>
  <body>
    <h1>php-sdk</h1>
 
    <h3>PHP Session</h3>
 
      <?php foreach($_SESSION as $key=>$value){
          echo '<strong>' . $key . '</strong> => ' . $value . '<br />';
      }
      ?>
      <h3>Tu</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
 
      <h3>Tus datos (/me)</h3>
      <?php foreach($user_profile as $key=>$value){
          echo '<strong>' . $key . '</strong> => ' . $value . '<br />';
      }
      ?>
 
  </body>
</html>
