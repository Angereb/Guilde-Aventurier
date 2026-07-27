<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
?>

<main class="mon-compte-page">
    <section class="feuille-compte">
        <h1 class="titre"><?= htmlspecialchars($utilisateur->getPseudo()) ?></h1>
        
        <form id="formulairePseudo" class="formulaire-pseudo" method="post">
            <div class="formulaire-champ">
                <label for="pseudoInput" class="modification-label">Pseudo : </label>
                <input type="text" class="modification-input" id="pseudoInput" placeholder="<?= htmlspecialchars($utilisateur->getPseudo()) ?>" name="pseudo">
            </div>
            <a href="#" class="modification-pseudo" id="modifierPseudo">Modifier</a>
        </form>

        <form id="formulaireNomDeCompagnie" class="formulaire-nom-de-compagnie" method="post">
            <div class="formulaire-champ">
                <label for="nomDeCompagnieInput" class="modification-label">Nom de Compagnie : </label>
                <input type="text" class="modification-input" id="nomDeCompagnieInput" placeholder="<?= htmlspecialchars($utilisateur->getNomDeCompagnie()) ?>" name="nomDeCompagnie">
            </div>
            <button type="submit" class="modification-nom-de-compagnie" name="action" value="modifierNomDeCompagnie">Modifier</button>
        </form>

        <form id="formulaireEmail" class="formulaire-email" method="post">
            <div class="formulaire-champ">
                <label for="emailInput" class="modification-label">Email : </label>
                <input type="email" class="modification-input" id="emailInput" placeholder="<?= htmlspecialchars($utilisateur->getEmail()) ?>" name="email">
            </div>
            <a href="#" class="modification-email" id="modifierEmail">Modifier</a>
        </form>

        <form id="formulaireMotDePasse" class="formulaire-mot-de-passe" method="post">
            <div class="formulaire-champ">
                <label for="motDePasseInput" class="modification-label">Mot De Passe : </label>
                <input type="password" class="modification-input" id="motDePasseInput" placeholder="Nouveau mot de passe" name="motDePasse">
            </div>
            <a href="#" class="modification-mot-de-passe" id="modifierMotDePasse">Modifier</a>
        </form>

        <?php if ($messageErreur !== null): ?>
            <div class="message-erreur">
                <?= htmlspecialchars($messageErreur) ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<div id="modalePseudo" class="modale-cachee">
    <section class="fenetre-verification">
        <h2 class="verification-titre">Vérification du mot de passe</h2>

        <label for="verifInputPseudo" class="verif-mot-de-passe">Mot de Passe :</label>
        <input form="formulairePseudo" type="password" class="verif-mot-de-passe-input" id="verifInputPseudo" placeholder="Mot de Passe" name="verificationMotDePasse" required>

        <div class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulairePseudo" class="envoyer-pseudo" name="action" value="modifierPseudo">Modifier</button>

            <button type="button" id="fermerModifierPseudo" class="retour-modifier-pseudo">Annuler</button>
        </div>    
    </section>
</div>

<div id="modaleEmail" class="modale-cachee">
    <section class="fenetre-verification">
        <h2 class="verification-titre">Vérification du mot de passe</h2>

        <label for="verifInputEmail" class="verif-mot-de-passe">Mot de Passe :</label>
        <input form="formulaireEmail" type="password" class="verif-mot-de-passe-input" id="verifInputEmail" placeholder="Mot de Passe" name="verificationMotDePasse" required>

        <div class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulaireEmail" class="envoyer-email" name="action" value="modifierEmail">Modifier</button>

            <button type="button" id="fermerModifierEmail" class="retour-modifier-email">Annuler</button>
        </div>    
    </section>
</div>

<div id="modaleMotDePasse" class="modale-cachee">
    <section class="fenetre-verification">
        <h2 class="verification-titre">Vérification du mot de passe</h2>

        <label for="verifInputMotDePasse" class="verif-mot-de-passe">Mot de Passe :</label>
        <input form="formulaireMotDePasse" type="password" class="verif-mot-de-passe-input" id="verifInputMotDePasse" placeholder="Mot de Passe" name="verificationMotDePasse" required>

        <div class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulaireMotDePasse" class="envoyer-mot-de-passe" name="action" value="modifierMotDePasse">Modifier</button>

            <button type="button" id="fermerModifierMotDePasse" class="retour-modifier-mot-de-passe">Annuler</button>
        </div>    
    </section>
</div>