<?php 
require_once __DIR__ . "/../../Modeles/Relations/RelationModele.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Liste d'amis";

$css = ["Amis/listeami.css"];

$javascript = ["Amis/listeami.js"];

$relationModele = new RelationUtilisateurModele;
$utilisateurModele = new UtilisateurModele;

$listeAmis = $relationModele->voirRelation($_SESSION["utilisateur"]["id"]);
$relations = [];
foreach ($listeAmis as $relation) {
    $contact = $utilisateurModele->rechercherParId($relation->getContactId());
    $relations[] = [
        "contactId" => $relation->getContactId(),
        "pseudo" => $contact->getPseudo(),
        "typeRelation" => $relation->getStatut(),
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'demandeContact':
                $contact = $_POST["contact"] ?? "";
                try{
                    $contactTrouve = $utilisateurModele->rechercherParPseudo($contact);
                    if ($contactTrouve->getActif() === false || $contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Aucun joueur ne porte ce pseudo.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Vous ne pouvez pas vous demander en ami vous-même.");
                }
                $nouvelleRelation = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "en_attente"
                );
                try {
                    $relationModele->envoyerDemande($nouvelleRelation);
                } catch (Exception $e) {}
                $_SESSION["notificationMessage"] = "Votre demande de contact a bien été envoyée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'blocageContact':
                $contact = $_POST["contact"] ?? "";
                try{
                    $contactTrouve = $utilisateurModele->rechercherParPseudo($contact);
                    if ($contactTrouve->getActif() === false || $contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Aucun joueur ne porte ce pseudo.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Vous ne pouvez pas vous bloquer vous-même.");
                }
                $nouvelleRelation = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "bloque"
                );
                $relationModele->bloquer($nouvelleRelation);
                $_SESSION["notificationMessage"] = "Le contact a bien été bloqué.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'validerAmi':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "ami"
                );
                $relationModele->accepter($relationModifier);
                $_SESSION["notificationMessage"] = "La demande de contact a bien été validée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'refuserAmi':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "en_attente"
                );
                $relationModele->refuser($relationModifier);
                $_SESSION["notificationMessage"] = "La demande de contact a bien été refusée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'changerVersRival':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "rival"
                );
                $relationModele->modifierEtiquette($relationModifier);
                $_SESSION["notificationMessage"] = "Le contact est maintenant un rival.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'changerVersAmi':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "ami"
                );
                $relationModele->modifierEtiquette($relationModifier);
                $_SESSION["notificationMessage"] = "Le contact est maintenant un ami.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'retirerContact':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "ami"
                );
                $relationModele->retirer($relationModifier);
                $_SESSION["notificationMessage"] = "Le contact a bien été retiré.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'debloquerContact':
                $contactId = (int)($_POST["contactId"] ?? 0);
                try{
                    $contactTrouve = $utilisateurModele->rechercherParId($contactId);
                    if ($contactTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun contact n'a été trouvé.");
                    }
                } catch(Exception $e) {
                    throw new Exception("Ce contact est introuvable.");
                    }
                if ($contactTrouve->getUtilisateurId() === $_SESSION["utilisateur"]["id"]) {
                    throw new Exception("Action impossible.");
                }
                $relationModifier = new RelationUtilisateur(
                    $_SESSION["utilisateur"]["id"],
                    $contactTrouve->getUtilisateurId(),
                    null,
                    "bloque"
                );
                $relationModele->debloquer($relationModifier);
                $_SESSION["notificationMessage"] = "Vous avez bien débloqué ce contact.";
                $_SESSION["typeNotification"] = "succes";
                break;
        
            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=listeami");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=listeami");
        exit;
    } 
}

ob_start();
require __DIR__ . '/../../Vus/Amis/listeami.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>