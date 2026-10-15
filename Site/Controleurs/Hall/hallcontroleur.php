<?php
require_once __DIR__ . "/../../Modeles/Annonces/Annonce.php";
require_once __DIR__ . "/../../Modeles/Annonces/AnnonceModele.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Hall";

$css = ["Hall/hall.css"];

$javascript = ["Hall/hall.js"];

$annonceModele = new AnnonceModele();
$annonces = $annonceModele->rechercherDernieres(6);

$auteurs =[];

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
            throw new Exception("Vous n'avez pas les droits nécessaires pour effectuer cette action.");
        }
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'creerAnnonce':
                $id= null;
                $titreAnnonce= $_POST["titre"] ?? "";
                $contenu= $_POST["contenu"] ?? "";
                $idCreateur = (int)($_SESSION["utilisateur"]["id"] ?? 0);
                $annonce = new Annonce(
                    $id,
                    $titreAnnonce,
                    $contenu,
                    null,
                    $idCreateur
                );
                $annonceModele->ajouter($annonce);
                $_SESSION["notificationMessage"] = "Votre annonce a bien été créée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'modifierAnnonce':
                $idModification = (int)($_POST["idCible"] ?? 0);
                $titreAnnonceModifier = $_POST["titreModifier"] ?? "";
                $contenuAnnonceModifier = $_POST["contenuModifier"] ?? "";
                $annonceModifier = $annonceModele->rechercherParId($idModification);
                $annonceModifier->setTitre($titreAnnonceModifier);
                $annonceModifier->setContenu($contenuAnnonceModifier);
                $annonceModele->modifier($annonceModifier);
                $_SESSION["notificationMessage"] = "L'annonce a bien été modifiée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'supprimerAnnonce':
                $idSuppression = (int)($_POST["idCible"] ?? 0);
                $annonceModele->supprimer($idSuppression);
                $_SESSION["notificationMessage"] = "L'annonce a bien été supprimée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
                throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=hall");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=hall");
        exit;
    }
}

$utilisateurModele = new UtilisateurModele();
foreach ($annonces as $annonce) {
    $utilisateur = $utilisateurModele->rechercherParId(
        $annonce->getPublierParId()
    );
    $auteurs[$annonce->getAnnonceId()] = $utilisateur->getPseudo();
}

ob_start();

require __DIR__ . '/../../Vus/Hall/hall.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>