<?php 
require_once __DIR__ . "/../../Modeles/Aventuriers/AventurierModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Dortoir";

$css = ["Dortoir/dortoir.css"];

$javascript = ["Dortoir/dortoir.js"];

$aventurierModele = new AventurierModele();

$aventuriers = $aventurierModele->rechercherParCreerParId($_SESSION["utilisateur"]["id"]);
$colonnesLits = array_chunk($aventuriers, 3);
$dortoirs = array_chunk($colonnesLits, 2);

ob_start();
require __DIR__ . '/../../Vus/Dortoir/dortoir.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>