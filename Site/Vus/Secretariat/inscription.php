<main class="inscription-page">

    <section class="inscription-livre">

        <header class="inscription-titre">
            <h1>
                <span>Inscription</span>
            </h1>
        </header>

        <form id="formulaireInscription" class="inscription-formulaire" method="post">
            <div class="inscription-champ">
                <label for="pseudoInput" class="inscription-label">Pseudo :</label>
                <input type="text" class="inscription-input" id="pseudoInput" placeholder="Votre nom" name="pseudo" required>
            </div>

            <div class="inscription-champ">
                <label for="nomDeCompagnieInput" class="inscription-label">Nom de la compagnie :</label>
                <input type="text" class="inscription-input" id="nomDeCompagnieInput" placeholder="Nom de votre compagnie" name="nomDeCompagnie" required>
            </div>

            <div class="inscription-champ">
                <label for="emailInput" class="inscription-label">Email :</label>
                <input type="email" class="inscription-input" id="emailInput" placeholder="Votre email" name="email" required>
            </div>

            <div class="inscription-champ">
                <label for="motDePasseInput" class="inscription-label">Mot de passe :</label>
                <input type="password" class="inscription-input" id="motDePasseInput" placeholder="Votre mot de passe" name="motDePasse" required>
            </div>

            <div class="inscription-champ">
                <label for="verificationMotDePasseInput" class="inscription-label">Vérification du mot de passe :</label>
                <input type="password" class="inscription-input" id="verificationMotDePasseInput" placeholder="Confirmez votre mot de passe" name="verificationMotDePasse" required>
            </div>
        </form>

        <?php if ($messageErreur !== null): ?>
            <div class="message-erreur">
                <?= htmlspecialchars($messageErreur) ?>
            </div>
        <?php endif; ?>
        
        <div class="inscription-navigation">
            <a href="?page=secretariat" class="retour-secretariat"></a>

            <button type="submit" form="formulaireInscription" class="signature-inscription">Signature</button>
        </div>
        
    </section>

</main>