<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];
?>

<main class="bibliotheque-entree-page">
    <header class="bibliotheque-entree-titre">
        <h1>Bibliothèque : Entrée</h1>
    </header>
    <nav class="navigation-bibliotheque" aria-label="Sections de la bibliothèque">
        <div class="colonne-equipements">
            <a href="?page=bibliothequeequipements" class="nav-bibliotheque-equipements" aria-label="Bibliothèque équipements"></a>
        </div>
        <div class="colonne-creation">
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <a href="?page=bibliothequecreation" class="nav-bibliotheque-creation" aria-label="Bibliothèque création"></a>
            <?php endif; ?>
        </div>
        <div class="colonne-competences">
        <a href="?page=bibliothequecompetences" class="nav-bibliotheque-competences" aria-label="Bibliothèque compétences"></a>
        </div>
    </nav>
</main>