<main class="administrateur-page">
    <section class="feuille-administrateur">
        <h1 class="titre">Panneau de gestion administratif</h1>
        <form id="formulaireRecherche" class="formulaire-recherche" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="rechercherInput" class="rechercher-label">Recherche :</label>
            <input type="text" class="rechercher-input" id="rechercherInput" name="recherche" aria-describedby="rechercherUtilisateur">
            <p id="rechercherUtilisateur" class="message-champ"></p>
            <button type="submit" class="rechercher-identifiant" name="action" value="rechercherUtilisateur">Rechercher</button>
        </form>
        <div class="zone-tableau">
             <?php if (!empty($utilisateurs)): ?>
                <table class="resultat-recherche">
                    <caption>Résultats de la recherche</caption>
                    <thead>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Nom de compagnie</th>
                            <th scope="col">Rôles</th>
                            <th scope="col">État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <tr class="utilisateur-recuperer" data-id="<?= $utilisateur->getUtilisateurId() ?>" data-roles="<?= implode(", ", $utilisateur->getRoles()) ?>" data-actif="<?= (int) $utilisateur->getActif() ?>">
                                <th scope="row">
                                    <button type="button" class="ouverture-modification-statut"><?= htmlspecialchars($utilisateur->getPseudo()) ?></button>
                                </th>
                                <td><?= htmlspecialchars($utilisateur->getNomCompagnie()) ?></td>
                                <td><?php $libellesRoles = []; foreach ($utilisateur->getRoles() as $role) { $libellesRoles[] = Utilisateur::LIBELLES_ROLES[$role]; } ?><?= implode(", ", $libellesRoles) ?></td>
                                <td><?= $utilisateur->getActif() ? "Valide" : "Bloqué" ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>
</main>

<div id="modaleAdmin" class="modale-cachee">
    <section class="fenetre-modification-utilisateur">
        <h2 class="titre-modale">Gestion du compte</h2>
        <form id="formulaireRoles" class="formulaire-roles" method="post">
            <input type="hidden" name="idCible" id="idCibleRoles">
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label><input type="checkbox" class="checkboxUtilisateur" checked disabled>Utilisateur</label>
            <label><input type="checkbox" class="checkbox-admin" name="roles[]" value="ROLE_ADMINISTRATEUR" id="checkboxAdmin">Administrateur</label>
            <input type="hidden" name="roles[]" value="ROLE_UTILISATEUR">
            <button type="submit" class="roles-envoyer" name="action" value="modifierRoles">Modifier les rôles</button>
        </form>
        <form id="formulaireBlocage" class="formulaire-blocage" method="post">
            <input type="hidden" name="idCible" id="idCibleBlocage">
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label><input type="checkbox" class="checkbox-actif" name="bloquer" id="checkboxActif">Bloquer ce compte</label>
            <button type="submit" class="blocage-envoyer" name="action" value="modifierActif">Modifier le blocage</button>
        </form>
        <button type="button" id="fermerModaleAdmin" class="retour-admin">Annuler</button>
    </section>
</div>