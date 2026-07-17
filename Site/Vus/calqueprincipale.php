<?php
/**@var string $titre */
/**@var string $contenu */
/**@var array $css */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $titre ?? 'Guilde des Aventuriers' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Joti+One&display=swap" rel="stylesheet">

    <?php foreach($css as $fichierCSS): ?>

        <link rel="stylesheet" href="Site/Publique/css/<?= $fichierCSS ?>">

    <?php endforeach; ?>
</head>

<body>
    <?php
    if (isset($_SESSION["utilisateur"])) {
        require __DIR__ . "/Composants/entete.php";
    }
    ?>

    <?= $contenu ?? '' ?>

</body>

</html>