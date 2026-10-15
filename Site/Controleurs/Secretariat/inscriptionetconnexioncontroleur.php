<?php
if (isset($_SESSION["utilisateur"])) {
    header("Location: ?page=hall");
    exit;
}

$titre = "Inscription et connexion";

$css = ["Secretariat/inscriptionetconnexion.css",];

$javascript = ["Secretariat/formulaireconnexion.js", "Secretariat/formulaireinscription.js"];

ob_start();

require __DIR__ . '/../../Vus/Secretariat/inscriptionetconnexion.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>