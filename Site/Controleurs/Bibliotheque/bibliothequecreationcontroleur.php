<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/ZonnesEffets/ZoneEffetModele.php";

if (!isset($_SESSION["utilisateur"]) || !in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
    header("Location: ?page=bibliothequeentree");
    exit;
}

$titre = "Bibliothèque : Création";

$css = [];

$javascript = [];

$zoneEffetModele = new ZoneEffetModele();

$zonesEffets = $zoneEffetModele->rechercherToutes();


ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequecreation.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>