<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
?>

<main class="mon-compte-page">
    <section class="feuille-compte">
        <h1 class="titre"><?= htmlspecialchars($utilisateur->getPseudo()) ?></h1>
        <form id="formulaireGeneral" class="formulaire-general" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <div class="formulaire-champ">
                <label for="pseudoInput" class="modification-label">Pseudo : </label>
                <input type="text" class="modification-input" id="pseudoInput" value="<?= htmlspecialchars($utilisateur->getPseudo()) ?>" name="pseudo" aria-describedby="modificationPseudoErreur">
                <p id="modificationPseudoErreur" class="message-champ"></p>
            </div>
            <div class="formulaire-champ">
                <label for="nomDeCompagnieInput" class="modification-label">Nom de compagnie : </label>
                <input type="text" class="modification-input" id="nomDeCompagnieInput" value="<?= htmlspecialchars($utilisateur->getNomCompagnie()) ?>" name="nomDeCompagnie" aria-describedby="modificationNomCompagnieErreur">
                <p id="modificationNomCompagnieErreur" class="message-champ"></p>
            </div>
            <div class="formulaire-champ">
                <label for="emailInput" class="modification-label">Adresse e-mail : </label>
                <input type="email" class="modification-input" id="emailInput" value="<?= htmlspecialchars($utilisateur->getEmail()) ?>" name="email" aria-describedby="modificationEmailErreur">
                <p id="modificationEmailErreur" class="message-champ"></p>
            </div>
            <button type="button" class="modification-general" id="modifierGeneral">Modifier</button>
        </form>
        <form id="formulaireMotDePasse" class="formulaire-mot-de-passe" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <div class="formulaire-champ">
                <label for="motDePasseInput" class="modification-label">Nouveau mot de passe : </label>
                <input type="password" class="modification-input" id="motDePasseInput" placeholder="Nouveau mot de passe" name="motDePasse" aria-describedby="modificationMotDePasseErreur">
                <p id="modificationMotDePasseErreur" class="message-champ"></p>
            </div>
            <div class="formulaire-champ">
                <label for="modificationVerificationMotDePasseInput" class="modification-label">Vérification du nouveau mot de passe :</label>
                <input type="password" class="modification-input" id="modificationVerificationMotDePasseInput" placeholder="Confirmez votre nouveau mot de passe" name="verificationNouveauMotDePasse" aria-describedby="modificationVerificationNouveauMotDePasseErreur">
                <p id="modificationVerificationNouveauMotDePasseErreur" class="message-champ"></p>
            </div>
            <button type="button" class="modification-mot-de-passe" id="modifierMotDePasse">Modifier</button>
        </form>
        <button type="button" class="suppression-compte" id="supprimerCompte">Supprimer</button>
    </section>
</main>

<div id="modaleGeneral" class="modale-cachee">
    <section class="fenetre-verification">
        <h2 class="verification-titre">Vérification du mot de passe</h2>
        <div class="formulaire-champ">
            <label for="verifInputGeneral" class="verif-mot-de-passe">Mot de Passe :</label>
            <input form="formulaireGeneral" type="password" class="verif-mot-de-passe-input" id="verifInputGeneral" placeholder="Mot de Passe" name="verificationMotDePasse" aria-describedby="modaleGeneralMotDePasseErreur" required>
            <p id="modaleGeneralMotDePasseErreur" class="message-champ"></p>
        </div>
        <nav class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulaireGeneral" class="envoyer-general" name="action" value="modifierGeneral">Modifier</button>
            <button type="button" id="fermerModifierGeneral" class="retour-modifier-general">Annuler</button>
        </nav>    
    </section>
</div>

<div id="modaleMotDePasse" class="modale-cachee">
    <section class="fenetre-verification">
        <h2 class="verification-titre">Vérification du mot de passe</h2>
        <div class="formulaire-champ">
            <label for="verifInputMotDePasse" class="verif-mot-de-passe">Mot de Passe :</label>
            <input form="formulaireMotDePasse" type="password" class="verif-mot-de-passe-input" id="verifInputMotDePasse" placeholder="Mot de Passe" name="verificationMotDePasse" aria-describedby="modaleMotDePasseMotDePasseErreur" required>
            <p id="modaleMotDePasseMotDePasseErreur" class="message-champ"></p>
        </div>
        <nav class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulaireMotDePasse" class="envoyer-mot-de-passe" name="action" value="modifierMotDePasse">Modifier</button>
            <button type="button" id="fermerModifierMotDePasse" class="retour-modifier-mot-de-passe">Annuler</button>
        </nav>    
    </section>
</div>

<div id="modaleSupprimerCompte" class="modale-cachee">
    <section class="fenetre-verification-suppression">
        <h2 class="suppression-titre">ATTENTION</h2>
        <p class="text-avertissement">En cas de validation, votre compte ne sera plus accessible, et vos données d'aventuriers et de parties seront effacées.</p>
        <form id="formulaireSupprimerCompte" class="formulaire-supprimer-compte" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="verifInputSupprimerCompte" class="verif-mot-de-passe">Mot de Passe :</label>
            <input type="password" class="verif-supprimer-compte-input" id="verifInputSupprimerCompte" placeholder="Mot de Passe" name="verificationMotDePasse" aria-describedby="modaleSupprimerMotDePasseErreur" required>
            <p id="modaleSupprimerMotDePasseErreur" class="message-champ"></p>
        </form>
        <nav class="verification-mot-de-passe-navigation">
            <button type="submit" form="formulaireSupprimerCompte" class="supprimer-compte" name="action" value="supprimerCompte">Supprimer</button>
            <button type="button" id="fermerSupprimerCompte" class="retour-supprimer-compte">Annuler</button>
        </nav>    
    </section>
</div>