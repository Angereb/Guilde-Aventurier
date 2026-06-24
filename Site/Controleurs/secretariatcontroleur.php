<?php

$titre = "Secrétariat";

ob_start();

require __DIR__ . '/../Vus/Secretariat/secretariat.php';

$contenu = ob_get_clean();

require __DIR__ . '/../Vus/calqueprincipale.php';

?>