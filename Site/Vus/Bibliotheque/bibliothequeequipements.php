<main class="bibliotheque-equipement-page">
    <header class="bibliotheque-equipement-titre">
        <h1>Bibliothèque : Équipements</h1>
    </header>
    <nav class="etageres-equipements" aria-label="Catégories d'équipements">
        <?php foreach (Equipement::CATEGORIES_VALIDES as $categorie): ?>
            <a href="?page=bibliothequelivreequipements&categorie=<?= $categorie ?>" class="etagere-categorie etagere-categorie-<?= $categorie ?>">
                <span class="panneau-categorie"><?= htmlspecialchars(Equipement::LIBELLES_CATEGORIE[$categorie]) ?></span>
            </a>
        <?php endforeach ?>
    </nav>
    <nav class="retour-bibliotheque" aria-label="Retour">
        <a href="?page=bibliothequeentree" class="retour-fleche-droite" aria-label="Retour vers l'entrée de la bibliothèque"></a>
    </nav>
</main>