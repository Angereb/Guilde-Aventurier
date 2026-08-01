<?php

session_start();

$page = $_GET['page'] ?? 'entree';

switch ($page)
{
    case 'entree':
        require_once __DIR__ . '\Site\Controleurs\Accueil\entreecontroleur.php';
        break;

    case 'information':
        require_once __DIR__ . '\Site\Controleurs\Accueil\informationcontroleur.php';
        break;

    case 'secretariat':
        require_once __DIR__ . '\Site\Controleurs\Secretariat\secretariatcontroleur.php';
        break;

    case 'inscription':
        require_once __DIR__ . '\Site\Controleurs\Secretariat\inscriptioncontroleur.php';
        break;

    case 'connexion':
        require_once __DIR__ . '\Site\Controleurs\Secretariat\connexioncontroleur.php';
        break;

    case 'hall':
        require_once __DIR__ . '\Site\Controleurs\Hall\hallcontroleur.php';
        break;

    case 'moncompte' :
        require_once __DIR__ . '\Site\Controleurs\Compte\moncomptecontroleur.php';
        break;

    case 'administrateur' :
        require_once __DIR__ . '\Site\Controleurs\Compte\administrateurcontroleur.php';
        break;

    case "deconnexion":
        require_once __DIR__ . '\Site\Controleurs\deconnexioncontroleur.php';
        break;    

    default:
        echo "Page introuvable";
}
?>