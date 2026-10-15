<?php
/**@var string $titre */
/**@var string $contenu */
/**@var array $css */
/**@var array $javascript */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titre ?? 'Guilde des Aventuriers' ?></title>

    <link rel="stylesheet" href="/Site/Publique/CSS/style.css?v=<?= filemtime(__DIR__ . "/../Publique/CSS/style.css") ?>">
    <link rel="stylesheet" href="/Site/Publique/CSS/Composants/entete.css?v=<?= filemtime(__DIR__ . "/../Publique/CSS/Composants/entete.css") ?>">
    <link rel="stylesheet" href="/Site/Publique/CSS/Composants/notification.css?v=<?= filemtime(__DIR__ . "/../Publique/CSS/Composants/notification.css") ?>">
    <?php foreach($css as $fichierCSS): ?>
        <link rel="stylesheet" href="/Site/Publique/CSS/<?= $fichierCSS ?>?v=<?= filemtime(__DIR__ . "/../Publique/CSS/" . $fichierCSS) ?>">
    <?php endforeach; ?>

    <script defer src="/Site/Publique/JS/validation.js?v=<?= filemtime(__DIR__ . "/../Publique/JS/validation.js") ?>"></script>
    <script defer src="/Site/Publique/JS/Composants/notification.js?v=<?= filemtime(__DIR__ . "/../Publique/JS/Composants/notification.js") ?>"></script>
    <?php foreach($javascript as $script): ?>
        <script defer src="/Site/Publique/JS/<?= $script ?>?v=<?= filemtime(__DIR__ . "/../Publique/JS/" . $script) ?>"></script>
    <?php endforeach; ?>
</head>

<body>
    <?php
    if (isset($_SESSION["utilisateur"])) {
        require __DIR__ . "/Composants/entete.php";
    }
    ?>
    <?php
    $notificationMessage = $_SESSION["notificationMessage"] ?? null;
    $typeNotification = $_SESSION["typeNotification"] ?? null;
    unset($_SESSION["notificationMessage"]);
    unset($_SESSION["typeNotification"]);
    require __DIR__ . "/Composants/notification.php";
    ?>

    <?= $contenu ?? '' ?>

</body>

</html>