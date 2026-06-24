<?php
/**@var string $titre */
/**@var string $contenu */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $titre ?? 'Guilde des Aventuriers' ?></title>

    <link rel="stylesheet" href="Publique/CSS/style.css">
</head>

<body>

    <?= $contenu ?? '' ?>

</body>

</html>