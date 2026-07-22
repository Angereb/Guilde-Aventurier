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
    $id= null;
    $titreAnnonce= $_POST["titre"];
    $contenu= $_POST["contenu"];
    $idCreateur = $_SESSION["utilisateur"]["id"];

    try{
        $annonce = new Annonce(
            $id,
            $titreAnnonce,
            $contenu,
            null,
            $idCreateur
        );

        $annonceModele->ajouter($annonce);

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