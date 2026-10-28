<?php 
require_once __DIR__ . "/../../Modeles/Equipements/Equipement.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Bibliothèque : Équipements";

$css = ["Bibliotheque/bibliothequeequipements.css"];

$javascript = [];

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequeequipements.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>