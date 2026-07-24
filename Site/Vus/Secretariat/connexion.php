<main class="connexion-page">

    <section class="connexion-livre">

        <header class="connexion-titre">
            <h1>
                <span>Connexion</span>
            </h1>
        </header>

        <form id="formulaireConnexion" class="connexion-formulaire" method="post">
            <div class="connexion-champ">
                <label for="identifiantInput" class="connexion-label">Identifiant :</label>
                <input type="text" class="connexion-input" id="identifiantInput" placeholder="Email ou Pseudo" name="identifiant" required>
            </div> 

            <div class="connexion-champ">
                <label for="motDePasseInput" class="connexion-label">Mot de passe :</label>
                <input type="password" class="connexion-input" id="motDePasseInput" placeholder="Votre mot de passe" name="motDePasse" required>
            </div>
        </form>

        <?php if ($messageErreur !== null): ?>
            <div class="message-erreur">
                <?= htmlspecialchars($messageErreur) ?>
            </div>
        <?php endif; ?>        
        
        <div class="connexion-navigation">
            <a href="?page=secretariat" class="retour-secretariat"></a>

            <button type="submit" form="formulaireConnexion" class="signature-connexion">Signature</button>
        </div>
        
    </section>

</main>