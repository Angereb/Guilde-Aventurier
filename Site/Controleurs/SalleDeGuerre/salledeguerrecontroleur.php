<?php 
if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Salle de guerre : Entrée";

$css = ["SalleDeGuerre/salledeguerre.css"];

$javascript = [];

ob_start();
require __DIR__ . '/../../Vus/SalleDeGuerre/salledeguerre.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>