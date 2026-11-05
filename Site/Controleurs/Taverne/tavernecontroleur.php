<?php 
if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Taverne";

$css = ["Taverne/taverne.css"];

$javascript = [];

ob_start();
require __DIR__ . '/../../Vus/Taverne/taverne.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>