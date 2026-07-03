<?php

$titre = "Inscription";

$css = [
    "style.css",
    "Secretariat/inscription.css"
];

ob_start();

require __DIR__ . '/../../Vus/Secretariat/inscription.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>