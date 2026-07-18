<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];
?>

<main class="hall-page">
    <header class="navigation-hall">
        <div class="passage-gauche">
            <a href="?page=bibliotheque" class="nav-bibliotheque" aria-label="Bibliothèque"></a>
            <a href="?page=salledeguerre" class="nav-salle-de-guerre" aria-label="Salle de Guerre"></a>
        </div>

        <div class="hall-titre">
            <h1>Hall Principal</h1>
        </div>

        <div class="passage-droite">
            <a href="?page=taverne" class="nav-taverne" aria-label="Taverne"></a>
            <a href="?page=dortoir" class="nav-dortoir" aria-label="Dortoir"></a>
        </div>
    </header>

    <aside class="information-hall">
        <div>
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <a href="?page=editioninformation" class="edition-information"></a>
            <?php endif; ?>
        </div>
    </aside>
</main>