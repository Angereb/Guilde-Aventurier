<?php

$titre = "Connexion";

$css = [
    "style.css",
    "Secretariat/connexion.css"
];

ob_start();

require __DIR__ . '/../../Vus/Secretariat/connexion.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>