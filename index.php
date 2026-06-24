<?php

$page = $_GET['page'] ?? 'accueil';

switch ($page)
{
    case 'accueil':
        require_once __DIR__ . '/Site/Controleurs/accueilcontroleur.php';
        break;

    case 'secretariat':
        require_once __DIR__ . '/Site/Controleurs/secretariatcontroleur.php';
        break;

    case 'hall':
        require_once __DIR__ . '/Site/Controleurs/hallcontroleur.php';
        break;

    default:
        echo "Page introuvable";
}
?>