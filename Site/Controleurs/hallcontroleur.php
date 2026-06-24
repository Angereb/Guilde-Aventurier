<?php

$titre = "Hall";

ob_start();

require __DIR__ . '/../Vus/Hall/hall.php';

$contenu = ob_get_clean();

require __DIR__ . '/../Vus/calqueprincipale.php';

?>