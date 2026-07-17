<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];
?>

<header class="entete">
    <div class="retour">
        <a href="?page=hall" class="retour-hall">Hall</a>
    </div>

    <div class="administrateur">
        <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
            <a href="?page=administration">
                Administration
            </a>
        <?php endif; ?>
    </div>

    <div class="navigation">
        <a href="?page=compte" class="mon-compte">Mon compte</a>

        <a href="?page=amis" class="amis">Amis</a>

        <a href="?page=messages" class="messages">Messages</a>

        <a href="?page=deconnexion" class="deconnexion">Déconnexion</a>
    </div>

</header>
