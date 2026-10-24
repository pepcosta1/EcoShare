<?php
// includes/session.php
// funcions per controlar la sessio i els rols

// iniciem la sessio si encara no esta iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// mira si l'usuari ha fet login
function estaLogejat()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        return true;
    }
    return false;
}

// mira si l'usuari es admin
function esAdmin()
{
    if (estaLogejat() && $_SESSION['user']['rol'] == 'admin') {
        return true;
    }
    return false;
}

// si no ha fet login el porta al login
// $ruta es per les pagines de dins de admin/ que han de pujar una carpeta ("../")
function comprovarLogin($ruta = "")
{
    if (!estaLogejat()) {
        header("Location: " . $ruta . "login.php");
        exit();
    }
}

// si no es admin el porta a l'inici
function comprovarAdmin($ruta = "")
{
    comprovarLogin($ruta);

    if (!esAdmin()) {
        header("Location: " . $ruta . "index.php");
        exit();
    }
}
