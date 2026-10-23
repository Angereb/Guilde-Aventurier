<?php

// Nom personnalisé du cookie de session
session_name("guilde_session");

// Sécurisation du cookie de session
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "httponly" => true,
    "samesite" => "Lax",
    "secure" => isset($_SERVER["HTTPS"]),
]);

session_start();

if (empty($_SESSION["jetonCsrf"])) {
    $_SESSION["jetonCsrf"] = bin2hex(random_bytes(32));
}

$page = $_GET['page'] ?? 'entree';

switch ($page)
{
    case 'entree':
        require_once __DIR__ . '/Site/Controleurs/Accueil/entreecontroleur.php';
        break;

    case 'information':
        require_once __DIR__ . '/Site/Controleurs/Accueil/informationcontroleur.php';
        break;

    case 'secretariat':
        require_once __DIR__ . '/Site/Controleurs/Secretariat/secretariatcontroleur.php';
        break;

    case 'inscription':
        require_once __DIR__ . '/Site/Controleurs/Secretariat/inscriptioncontroleur.php';
        break;

    case 'connexion':
        require_once __DIR__ . '/Site/Controleurs/Secretariat/connexioncontroleur.php';
        break;

    case 'inscriptionetconnexion':
        require_once __DIR__ . '/Site/Controleurs/Secretariat/inscriptionetconnexioncontroleur.php';
        break;

    case 'hall':
        require_once __DIR__ . '/Site/Controleurs/Hall/hallcontroleur.php';
        break;

    case 'moncompte' :
        require_once __DIR__ . '/Site/Controleurs/Compte/moncomptecontroleur.php';
        break;

    case 'administrateur' :
        require_once __DIR__ . '/Site/Controleurs/Compte/administrateurcontroleur.php';
        break;

    case "deconnexion":
        require_once __DIR__ . '/Site/Controleurs/deconnexioncontroleur.php';
        break;

    case "listeami":
        require_once __DIR__ . '/Site/Controleurs/Amis/listeamicontroleur.php';
        break;

    case "messages":
        require_once __DIR__ . '/Site/Controleurs/Messagerie/messageriecontroleur.php';
        break;

    case "bibliothequeentree":
        require_once __DIR__ . '/Site/Controleurs/Bibliotheque/bibliothequeentreecontroleur.php';
        break;

    case "bibliothequecreation":
        require_once __DIR__ . '/Site/Controleurs/Bibliotheque/bibliothequecreationcontroleur.php';
        break;
        
    default:
        echo "Page introuvable";
}
?>