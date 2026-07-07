<main class="inscription-page">

    <section class="inscription-livre">

        <header class="inscription-titre">
            <h1>
                <span>Inscription</span>
            </h1>
        </header>

        <form class="inscription-formulaire">
            <div class="inscription-champ">
                <label for="nomInput" class="inscription-label">Nom :</label>
                <input type="text" class="inscription-input" id="nomInput" placeholder="Votre nom" name="nom" required>
            </div>

            <div class="inscription-champ">
                <label for="nomDeCompagnieInput" class="inscription-label">Nom de la compagnie :</label>
                <input type="text" class="inscription-input" id="nomDeCompagnieInput" placeholder="Nom de votre compagnie" name="nom_de_compagnie" required>
            </div>

            <div class="inscription-champ">
                <label for="emailInput" class="inscription-label">Email :</label>
                <input type="email" class="inscription-input" id="emailInput" placeholder="Votre email" name="email" required>
            </div>

            <div class="inscription-champ">
                <label for="motDePasseInput" class="inscription-label">Mot de passe :</label>
                <input type="password" class="inscription-input" id="motDePasseInput" placeholder="Votre mot de passe" name="mot_de_passe" required>
            </div>

            <div class="inscription-champ">
                <label for="verificationMotDePasseInput" class="inscription-label">Vérification du mot de passe :</label>
                <input type="password" class="inscription-input" id="verificationMotDePasseInput" placeholder="Confirmez votre mot de passe" name="verification_mot_de_passe" required>
            </div>
        </form>
        
        <div class="inscription-navigation">
            <a href="?page=secretariat" class="retour-secretariat"></a>

            <a href="?page=hall" class="signature-inscription">Signature</a>
        </div>
        
    </section>

</main>