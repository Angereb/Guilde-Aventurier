<?php

$titre = "Information";

$css = ["Accueil/information.css",];

$javascript = [];

ob_start();

require __DIR__ . '/../../Vus/Accueil/information.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>