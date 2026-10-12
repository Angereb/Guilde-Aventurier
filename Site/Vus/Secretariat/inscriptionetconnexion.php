<main class="inscription-connexion-page">
    <?php $origine = "inscriptionetconnexion"; ?>
    <h1 class="titre-general">Registre de la guilde</h1>
    <div class="zone-livre">
        <div class="livre-ouvert">
            <div class="partie-inscription">
                <?php require __DIR__ . "/Formulaires/formulaireinscription.php" ?>
            </div>
            <div class="partie-connexion">
                <?php require __DIR__ . "/Formulaires/formulaireconnexion.php" ?>
            </div>
        </div>
    </div>
</main>