<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];
?>

<header class="entete">
    <div class="retour">
        <?php if (isset($page) && $page !== "hall"): ?>
            <a href="?page=hall" class="retour-hall"></a>
            <?php endif; ?>
    </div>

    <div>
        <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
            <a href="?page=administration" class="administrateur"></a>
        <?php endif; ?>
    </div>

    <div class="navigation">
        <a href="?page=moncompte" class="mon-compte"></a>

        <a href="?page=amis" class="amis"></a>

        <a href="?page=messages" class="messages"></a>

        <a href="?page=deconnexion" class="deconnexion"></a>
    </div>

</header>
