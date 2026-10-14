<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];
?>

<header class="entete">
    <?php if (isset($page) && $page !== "hall"): ?>
        <nav class="retour" aria-label="Menu retour au hall">
            <a href="?page=hall" class="retour-hall" aria-label="Retour au hall"></a>
        </nav>
    <?php endif; ?>
    <nav class="navigation" aria-label="Menu principal">
        <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
            <a href="?page=administrateur" class="administrateur" aria-label="Administration"></a>
        <?php endif; ?>
        <a href="?page=moncompte" class="mon-compte" aria-label="Mon compte"></a>
        <a href="?page=amis" class="amis" aria-label="Amis"></a>
        <a href="?page=messages" class="messages" aria-label="Messagerie"></a>
        <form id="formulaireDeconnexion" class="formulaire-deconnexion" method="post" action="?page=deconnexion">
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <button type="submit" class="deconnexion" aria-label="Déconnexion"></button>
        </form>
        </nav>
</header>
