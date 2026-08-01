<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
?>

<main class="administrateur-page">
    <section class="feuille-administrateur">
        <h1 class="titre">Panneau de gestion administratif</h1>

        <form id="formulaireRecherche" class="formulaire-recherche" method="post">
            <label for="rechercherInput" class="rechercher-label">Recherche :</label>
            <input type="text" class="rechercher-input" id="rechercherInput" name="recherche">
            <button type="submit" class="rechercher-identifiant" name="action" value="rechercherUtilisateur">Rechercher</button>
        </form>

        <?php if ($messageErreur !== null): ?>
            <div class="message-erreur">
                <?= htmlspecialchars($messageErreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($utilisateurs)): ?>
            <aside class="resultat-recherche">
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <article class="utilisateur-recuperer" data-id="<?= $utilisateur->getId() ?>" data-roles="<?= implode(", ", $utilisateur->getRoles()) ?>" data-est-supprimer="<?= (int) $utilisateur->getEstSupprimer() ?>">
                        <p class="pseudo-recuperer"><?= htmlspecialchars($utilisateur->getPseudo()) ?></p>
                        <p class="nom-de-compagnie-recuperer"><?= htmlspecialchars($utilisateur->getNomDeCompagnie()) ?></p>
                        <p class="roles-recuperer"><?= implode(", ", $utilisateur->getRoles()) ?></p>

                        <?php if ($utilisateur->getEstSupprimer()): ?>
                            <p class="est-supprimer-recuperer">Bloquer</p>
                        <?php else: ?>
                            <p class="est-supprimer-recuperer">Valide</p>
                        <?php endif; ?>

                    </article>
                <?php endforeach; ?>
            </aside>
        <?php endif; ?>
    </section>
</main>

<div id="modaleAdmin" class="modale-cachee">
    <section class="fenetre-modification-utilisateur">
        <h2 class="titre-modale">Gestion du compte</h2>

        <form id="formulaireRoles" class="formulaire-roles" method="post">
            <input type="hidden" name="idCible" id="idCibleRoles">

            <label><input type="checkbox" class="checkboxUtilisateur" checked disabled>ROLE_UTILISATEUR</label>

            <label><input type="checkbox" class="checkbox-admin" name="roles[]" value="ROLE_ADMINISTRATEUR" id="checkboxAdmin">ROLE_ADMINISTRATEUR</label>

            <input type="hidden" name="roles[]" value="ROLE_UTILISATEUR">

            <button type="submit" class="roles-envoyer" name="action" value="modifierRoles">Modifier les rôles</button>
        </form>

        <form id="formulaireBlocage" class="formulaire-blocage" method="post">
            <input type="hidden" name="idCible" id="idCibleBlocage">

            <label><input type="checkbox" class="checkbox-est-supprimer" name="estSupprimer" id="checkboxEstSupprimer">Bloquer ce compte</label>

            <button type="submit" class="blocage-envoyer" name="action" value="modifierEstSupprimer">Modifier le blocage</button>
        </form>

        <button type="button" id="fermerModaleAdmin" class="retour-admin">Annuler</button>
    </section>
</div>