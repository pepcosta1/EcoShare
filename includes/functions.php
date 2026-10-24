<?php
// includes/functions.php
// funcions que fem servir a diverses pagines

// posem l'hora d'espanya perque date() no doni una hora diferent
date_default_timezone_set('Europe/Madrid');

// per mostrar text a l'html sense que es pugui posar codi (XSS)
function e($text)
{
    // si es null htmlspecialchars dona un avis, per aixo retornem buit
    if ($text === null) {
        return "";
    }
    return htmlspecialchars($text);
}

// llegeix el tema de la cookie, si no es dark posem light
function getTema()
{
    if (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        return 'dark';
    }
    return 'light';
}

// canvia la data de la bbdd (2026-10-25 10:00) a format normal (25/10/2026 10:00)
function formatData($data)
{
    return date('d/m/Y H:i', strtotime($data));
}
