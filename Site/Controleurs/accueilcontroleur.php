<?php

$titre = "Accueil";

/*Ouvre une mémoire tampon pour stocker le contenu de la page*/
ob_start();

require __DIR__ . '/../Vus/Accueil/entree.php';

/*Récupère le contenu de la mémoire tampon et le stocke dans la variable $contenu*/
$contenu = ob_get_clean();

require __DIR__ . '/../Vus/calqueprincipale.php';

?>
