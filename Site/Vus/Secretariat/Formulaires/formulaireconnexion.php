<?php
/**@var string $origine */
?>
<section class="connexion-livre">
    <header class="connexion-titre">
        <h2>Connexion</h2>
    </header>
    <form id="formulaireConnexion" class="connexion-formulaire" method="post" action="?page=connexion" novalidate>
        <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
        <input type="hidden" name="origine" value="<?= $origine ?>">
        <div class="connexion-champ">
            <label for="connexionIdentifiantInput" class="connexion-label">Identifiant :</label>
            <input type="text" class="connexion-input" id="connexionIdentifiantInput" placeholder="Email ou Pseudo" name="identifiant" aria-describedby="connexionIdentifiantErreur" required>
            <p id="connexionIdentifiantErreur" class="message-champ"></p>
        </div> 
        <div class="connexion-champ">
            <label for="connexionMotDePasseInput" class="connexion-label">Mot de passe :</label>
            <input type="password" class="connexion-input" id="connexionMotDePasseInput" placeholder="Votre mot de passe" name="motDePasse" aria-describedby="connexionMotDePasseErreur" required>
            <p id="connexionMotDePasseErreur" class="message-champ"></p>
        </div>
    </form>
    <?php if ($messageErreurConnexion !== null): ?>
        <div class="message-erreur">
            <?= htmlspecialchars($messageErreurConnexion) ?>
        </div>
    <?php endif; ?>        
    <div class="connexion-navigation">
        <a href="?page=secretariat" class="retour-secretariat-connexion" aria-label="Retour au secrétariat"></a>
        <button type="submit" form="formulaireConnexion" class="signature-connexion">Signature</button>
    </div>
</section>