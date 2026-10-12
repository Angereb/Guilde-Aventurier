<?php
/**@var string $origine */
?>
<section class="inscription-livre">
    <header class="inscription-titre">
        <h2>Inscription</h2>
    </header>
    <form id="formulaireInscription" class="inscription-formulaire" method="post" action="?page=inscription" novalidate>
        <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
        <input type="hidden" name="origine" value="<?= $origine ?>">
        <div class="inscription-champ">
            <label for="inscriptionPseudoInput" class="inscription-label">Pseudo :</label>
            <input type="text" class="inscription-input" id="inscriptionPseudoInput" placeholder="Votre pseudo" name="pseudo" aria-describedby="inscriptionPseudoErreur" required>
            <p id="inscriptionPseudoErreur" class="message-champ"></p>
        </div>

        <div class="inscription-champ">
            <label for="inscriptionNomDeCompagnieInput" class="inscription-label">Nom de la compagnie :</label>
            <input type="text" class="inscription-input" id="inscriptionNomDeCompagnieInput" placeholder="Nom de votre compagnie" name="nomDeCompagnie" aria-describedby="inscriptionNomDeCompagnieErreur" required>
            <p id="inscriptionNomDeCompagnieErreur" class="message-champ"></p>
        </div>

        <div class="inscription-champ">
            <label for="inscriptionEmailInput" class="inscription-label">Adresse e-mail :</label>
            <input type="email" class="inscription-input" id="inscriptionEmailInput" placeholder="Votre email" name="email" aria-describedby="inscriptionEmailErreur" required>
            <p id="inscriptionEmailErreur" class="message-champ"></p>
        </div>

        <div class="inscription-champ">
            <label for="inscriptionMotDePasseInput" class="inscription-label">Mot de passe :</label>
            <input type="password" class="inscription-input" id="inscriptionMotDePasseInput" placeholder="Votre mot de passe" name="motDePasse" aria-describedby="inscriptionMotDePasseErreur" required>
            <p id="inscriptionMotDePasseErreur" class="message-champ"></p>
        </div>

        <div class="inscription-champ">
            <label for="inscriptionVerificationMotDePasseInput" class="inscription-label">Vérification du mot de passe :</label>
            <input type="password" class="inscription-input" id="inscriptionVerificationMotDePasseInput" placeholder="Confirmez votre mot de passe" name="verificationMotDePasse" aria-describedby="inscriptionVerificationMotDePasseErreur" required>
            <p id="inscriptionVerificationMotDePasseErreur" class="message-champ"></p>
        </div>
    </form>
    <?php if ($messageErreurInscription !== null): ?>
        <div class="message-erreur">
            <?= htmlspecialchars($messageErreurInscription) ?>
        </div>
    <?php endif; ?>
    <div class="inscription-navigation">
        <a href="?page=secretariat" class="retour-secretariat-inscription" aria-label="Retour au secrétariat"></a>
        <button type="submit" form="formulaireInscription" class="signature-inscription">Signature</button>
    </div>
</section>