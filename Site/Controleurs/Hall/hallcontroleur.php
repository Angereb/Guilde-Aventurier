<?php

$titre = "Hall";

$css = [
    "style.css",
    "Secretariat/connexion.css"
];

session_start();

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

ob_start();

require __DIR__ . '/../../Vus/Hall/hall.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>