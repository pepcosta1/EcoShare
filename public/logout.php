<?php
session_start();

// Destruïm totes les variables de la sessió
$_SESSION = array();
session_destroy();

// El tornem a enviar a la pantalla de login
header("Location: login.php");
exit();
?>
