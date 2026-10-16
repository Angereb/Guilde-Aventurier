<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"]) || !in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Administrateur";

$css = [
    "Compte/administrateur.css"
];

$javascript = [
    "Compte/administrateur.js"
];

$utilisateurModele = new UtilisateurModele();
$utilisateurs = [];

if (isset($_SESSION["rechercheAdmin"])){
    try{
        $trouver= false;
        if ($trouver === false && filter_var($_SESSION["rechercheAdmin"], FILTER_VALIDATE_EMAIL)) {   
            try{
                $utilisateurs[] = $utilisateurModele->rechercherParEmail($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }
        if ($trouver === false){
            try{
                $utilisateurs[] = $utilisateurModele->rechercherParPseudo($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }
        if ($trouver === false) {
            try{
                $utilisateurs = $utilisateurModele->rechercherToutesCompagnies($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }
        $utilisateursRetenus = [];
        foreach ($utilisateurs as $utilisateur) {
            if (!$utilisateur->getEstSupprime()) {
                $utilisateursRetenus[] = $utilisateur;
            }
        }
        $utilisateurs = $utilisateursRetenus;
        if (empty($utilisateurs)) {
            throw new Exception("Aucun résultat n'a été trouvé pour cette recherche.");
        }
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'rechercherUtilisateur':
                $recherche = $_POST["recherche"] ?? "";
                $_SESSION["rechercheAdmin"] = $recherche;
                break;
    
            case 'modifierActif' :
                $id = (int)($_POST["idCible"] ?? 0);
                if ($id === $_SESSION["utilisateur"]["id"]){
                    throw new Exception("Vous ne pouvez effectuer ce genre de modification sur ce compte.");
                }
                $utilisateur = $utilisateurModele->rechercherParId($id);
                if ($utilisateur->getEstSupprime()) {
                    throw new Exception("Vous ne pouvez modifier l'état d'un compte supprimé.");
                }
                if (isset($_POST["bloquer"])){$actif = false;}
                else {$actif = true;}
                $utilisateur->setActif($actif);
                $utilisateurModele->modifierActif($utilisateur);
                $_SESSION["notificationMessage"] = "L'état du compte ciblé a bien été modifié.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'modifierRoles' :
                $id = (int)($_POST["idCible"] ?? 0);
                if ($id === $_SESSION["utilisateur"]["id"]){
                    throw new Exception("Vous ne pouvez effectuer ce genre de modification sur ce compte.");
                }
                $utilisateur = $utilisateurModele->rechercherParId($id);
                if ($utilisateur->getEstSupprime()) {
                    throw new Exception("Vous ne pouvez modifier les rôles d'un compte supprimé.");
                }
                $roles = $_POST["roles"] ?? [];
                if (!in_array(Utilisateur::ROLE_UTILISATEUR, $roles, true)) {
                    $roles[] = Utilisateur::ROLE_UTILISATEUR;
                }
                $utilisateur->setRoles($roles);
                $utilisateurModele->modifierRoles($utilisateur);
                $_SESSION["notificationMessage"] = "Les rôles du compte ciblé ont bien été mis à jour.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=administrateur");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=administrateur");
        exit;
    } 
}

ob_start();

require __DIR__ . '/../../Vus/Compte/administrateur.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';
?>