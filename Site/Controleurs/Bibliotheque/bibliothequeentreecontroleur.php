<?php 
if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Bibliothèque : Entrée";

$css = ["Bibliotheque/bibliothequeentree.css"];

$javascript = [];

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequeentree.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>