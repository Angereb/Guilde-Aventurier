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

$css = [
    "style.css",
    "Hall/hall.css",
    "Composants/entete.css"
];

$javascript = [
    "Hall/hall.js"
];

$messageErreur = null;

$annonceModele = new AnnonceModele();

$annonces = $annonceModele->rechercherToutes();

$annonces = array_slice($annonces, 0, 6);

$auteurs =[];

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;

    try{
        if (!in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
            throw new Exception("Vous n'avez pas les droits nécessaires pour effectuer cette action.");
        }

        switch($formulaire){
            case 'creerAnnonce':
                $id= null;
                $titreAnnonce= $_POST["titre"];
                $contenu= $_POST["contenu"];
                $idCreateur = $_SESSION["utilisateur"]["id"];

                $annonce = new Annonce(
                    $id,
                    $titreAnnonce,
                    $contenu,
                    null,
                    $idCreateur
                );

                $annonceModele->ajouter($annonce);
                break;

            case 'modifierAnnonce':
                $idModification = (int) $_POST["idCible"];

                $titreAnnonceModifier = $_POST["titreModifier"];
                $contenuAnnonceModifier = $_POST["contenuModifier"];

                $annonceModifier = $annonceModele->rechercherParId($idModification);

                $annonceModifier->setTitre($titreAnnonceModifier);
                $annonceModele->modifierTitre($annonceModifier);

                $annonceModifier->setContenu($contenuAnnonceModifier);
                $annonceModele->modifierContenu($annonceModifier);
                break;

            case 'supprimerAnnonce':
                $idSuppression = (int) $_POST["idCible"];

                $annonceModele->supprimer($idSuppression);
                break;

            default:
                throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=hall");
        exit;
    }
    catch(Exception $e){$messageErreur = $e->getMessage();}
}

$utilisateurModele = new UtilisateurModele();

foreach ($annonces as $annonce) {

    $utilisateur = $utilisateurModele->rechercherParId(
        $annonce->getCreerParId()
    );

    $auteurs[$annonce->getId()] = $utilisateur->getPseudo();
}

ob_start();

require __DIR__ . '/../../Vus/Hall/hall.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>