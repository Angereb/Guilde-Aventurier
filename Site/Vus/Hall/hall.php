<?php
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';
$roles = $_SESSION["utilisateur"]["roles"] ?? [];

/**@var array $annonces */
/**@var array $auteurs */
?>

<main class="hall-page">
    <header class="navigation-hall">
        <div class="passage-gauche">
            <a href="?page=bibliotheque" class="nav-bibliotheque" aria-label="Bibliothèque"></a>
            <a href="?page=salledeguerre" class="nav-salle-de-guerre" aria-label="Salle de Guerre"></a>
        </div>

        <div class="hall-titre">
            <h1>Hall Principal</h1>
        </div>

        <div class="passage-droite">
            <a href="?page=taverne" class="nav-taverne" aria-label="Taverne"></a>
            <a href="?page=dortoir" class="nav-dortoir" aria-label="Dortoir"></a>
        </div>
    </header>

    <aside class="information-hall">
        <div class="panneau-information">
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <a href="#" class="edition-information" id="ouvrirAnnonce"></a>
            <?php endif; ?>
            <div class="zone-annonces">
                <?php foreach ($annonces as $annonce): ?>
                    <article class="annonce-recuperer" data-id="<?= $annonce->getId() ?>" data-titre="<?= htmlspecialchars($annonce->getTitre()) ?>" data-date="<?= $annonce->getCreerLe()->format('d/m/Y') ?>" data-contenu="<?= htmlspecialchars($annonce->getContenu()) ?>" data-auteur="<?= htmlspecialchars($auteurs[$annonce->getId()]) ?>">
                        <h3><?= $annonce->getCreerLe()->format("d/m/Y") ?></h3>

                        <p><?= htmlspecialchars($annonce->getTitre()) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </aside>
</main>

<div id="modaleAnnonce" class="modale-cachee">
    <section class="fenetre-annonce">
        <h2 class="entete-annonce">Nouvelle annonce</h2>

        <form id="formulaireAnnonce" class="annonce-formulaire" method="post">
            <div class="annonce-champ">
                <label for="titreInput" class="annonce-label">Titre de l'annonce :</label>
                <input type="text" class="annonce-input" id="titreInput" placeholder="Annonce" name="titre" required>
            </div>

            <div class="annonce-champ">
                <label for="texteInput" class="annonce-label">Contenu de l'annonce :</label>
                <textarea class="annonce-area" id="texteInput" placeholder="Nouvelle annonce ..." name="contenu" rows="10" maxlength="2500" required></textarea>
            </div>
        </form>

        <div class="annonce-edition-navigation">
            <button type="submit" form="formulaireAnnonce" class="envoyer-annonce">Envoyer</button>

            <button type="button" id="fermerCreationAnnonce" class="retour-annonce">Annuler</button>
        </div>    
    </section>
</div>

<div id="modaleLecture" class="modale-cachee">
    <section class="fenetre-annonce">
        <h2 class="lecture-titre-annonce" id="lectureTitre"></h2>
        <br>
        <h3 class="lecture-date-annonce" id="lectureDate"></h3>
        <br>
        <h3 class="lecture-auteur-annonce" id="lectureAuteur"></h3>
        <br><hr><br>
        <div class="lecture-contenu-annonce" id="lectureContenu"></div>
        <br><hr><br>
        <button type="button" id="fermerLectureAnnonce" class="retour-annonce">Retour</button>
    </section>
</div>