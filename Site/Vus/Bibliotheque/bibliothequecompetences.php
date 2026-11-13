<?php
/**@var array $rangees */
?>

<main class="bibliotheque-competence-page">
    <header class="bibliotheque-competence-titre">
        <h1>Bibliothèque : Compétences</h1>
    </header>
    <div class="niche-etageres">
        <nav class="etageres-competences" aria-label="Recueils de compétences">
            <?php foreach ($rangees as $rangee): ?>
                <div class="rangee-etageres">
                    <?php foreach ($rangee as $bibliotheque): ?>
                        <div class="bibliotheque-competences">
                            <?php foreach ($bibliotheque as $recueil): ?>
                                <a href="?page=bibliothequelivrecompetences&recueil=<?= urlencode($recueil["cle"]) ?>" class="etagere-recueil">
                                    <span class="panneau-recueil"><?= htmlspecialchars($recueil["libelle"]) ?></span>
                                </a>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </nav>
    </div>
    <nav class="navigation-bibliotheques" aria-label="Bibliothèque">
        <button type="button" id="bibliothequePrecedente" class="bibliotheque-precedente" aria-label="Bibliothèque précédente" hidden></button>
        <button type="button" id="bibliothequeSuivante" class="bibliotheque-suivante" aria-label="Bibliothèque suivante" hidden></button>
    </nav>
    <nav class="retour-bibliotheque" aria-label="Retour">
        <a href="?page=bibliothequeentree" class="retour-fleche-gauche" aria-label="Retour vers l'entrée de la bibliothèque"></a>
    </nav>
</main>