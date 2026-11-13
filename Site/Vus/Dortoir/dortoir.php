<?php
/**@var array $dortoirs */
?>

<main class="dortoir-page">
    <header class="dortoir-titre">
        <h1>Dortoir</h1>
    </header>
    <div class="niche-dortoir">
        <?php if (!empty($dortoirs)): ?>
            <div class="zone-lits">
                <nav class="lits-aventuriers" aria-label="Lits des aventuriers">
                    <?php foreach ($dortoirs as $dortoir): ?>
                        <div class="dortoir">     
                            <?php foreach ($dortoir as $colonne): ?>
                                <div class="colonne-lits">
                                    <?php foreach ($colonne as $litAventurier): ?>
                                        <a href="?page=aventuriermodification&aventurier=<?= urlencode($litAventurier->getAventurierId()) ?>" class="lit-aventurier">
                                            <span><?= htmlspecialchars($litAventurier->getNom()) ?></span>
                                        </a>
                                    <?php endforeach ?> 
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                </nav>
            </div>
            <nav class="navigation-dortoir" aria-label="Dortoirs">
                <button type="button" id="dortoirPrecedent" class="dortoir-precedent" aria-label="Dortoir précédent" hidden></button>
                <button type="button" id="dortoirSuivant" class="dortoir-suivant" aria-label="Dortoir suivant" hidden></button>
            </nav>
        <?php else: ?>
            <div class="message-pas-aventurier">
                <p>Vous n'avez aucun aventurier.</p>
                <p>Pour créer un aventurier, rendez-vous à la <a href="?page=taverne">Taverne</a>.</p>
            </div>
       <?php endif ?>
    </div>
</main>