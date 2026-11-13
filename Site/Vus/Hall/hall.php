<?php
/**@var array $roles */
/**@var array $annonces */
/**@var array $auteurs */
?>

<main class="hall-page">
    <header class="hall-titre">
            <h1>Hall Principal</h1>
    </header>
    <nav class="passage-gauche" aria-label="Salles de gauche">
        <a href="?page=bibliothequeentree" class="nav-bibliotheque" aria-label="Bibliothèque"></a>
        <a href="?page=salledeguerre" class="nav-salle-de-guerre" aria-label="Salle de Guerre"></a>
    </nav>
    <nav class="passage-droite" aria-label="Salles de droite">
        <a href="?page=taverne" class="nav-taverne" aria-label="Taverne"></a>
        <a href="?page=dortoir" class="nav-dortoir" aria-label="Dortoir"></a>
    </nav>
    <aside class="information-hall">
        <div class="panneau-information">
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <button type="button" class="edition-information" id="ouvrirAnnonce" aria-label="Ouvrir éditeur d'annonce"></button>
            <?php endif; ?>
            <div class="zone-annonces">
                <?php foreach ($annonces as $annonce): ?>
                    <article class="annonce-recuperer" data-id="<?= $annonce->getAnnonceId() ?>" data-titre="<?= htmlspecialchars($annonce->getTitre()) ?>" data-date="<?= $annonce->getPublierLe()->format('d/m/Y') ?>" data-contenu="<?= htmlspecialchars($annonce->getContenu()) ?>" data-auteur="<?= htmlspecialchars($auteurs[$annonce->getAnnonceId()]) ?>">
                        <button type="button" class="ouverture-annonce">
                            <span class="date-annonce"><?= $annonce->getPublierLe()->format("d/m/Y") ?></span>
                            <span class="titre-annonce"><?= htmlspecialchars($annonce->getTitre()) ?></span>
                        </button>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </aside>
</main>

<div id="modaleAnnonce" class="modale-cachee">
    <section class="fenetre-annonce">
        <h2 class="entete-annonce">Nouvelle annonce</h2>
        <form id="formulaireAnnonce" class="annonce-formulaire" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <div class="annonce-champ">
                <label for="titreInput" class="annonce-label">Titre de l'annonce :</label>
                <input type="text" class="annonce-input" id="titreInput" placeholder="Annonce" name="titre" aria-describedby="titreErreur" required>
                <p id="titreErreur" class="message-champ"></p>
            </div>
            <div class="annonce-champ">
                <label for="texteInput" class="annonce-label">Contenu de l'annonce :</label>
                <textarea class="annonce-area" id="texteInput" placeholder="Nouvelle annonce ..." name="contenu" rows="10" maxlength="2500" aria-describedby="texteErreur" required></textarea>
                <p id="texteErreur" class="message-champ"></p>
            </div>
        </form>
        <div class="annonce-edition-navigation">
            <button type="submit" form="formulaireAnnonce" class="envoyer-annonce" name="action" value="creerAnnonce">Envoyer</button>
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
        <aside class="navigation-lecture-annonce">
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <button type="button" id="ouvrirModificationAnnonce" class="ouvrir-modification-annonce">Modifier</button>
            <?php endif; ?>
            <button type="button" id="fermerLectureAnnonce" class="retour-annonce">Retour</button>
            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                <button type="button" id="ouvrirSuppressionAnnonce" class="ouvrir-suppression-annonce">Supprimer</button>
            <?php endif; ?>
        </aside>
    </section>
</div>

<div id="modaleModificationAnnonce" class="modale-cachee">
    <section class="fenetre-modification-annonce">
        <h2 class="entete-modification-annonce">Modifier l'annonce</h2>
        <form id="formulaireModifierAnnonce" class="modifier-annonce-formulaire" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <input type="hidden" name="idCible" id="idCibleModifier">
            <div class="modifier-annonce-champ">
                <label for="titreModifierInput" class="modifier-annonce-label">Titre de l'annonce :</label>
                <input type="text" class="modifier-annonce-input" id="titreModifierInput" name="titreModifier" aria-describedby="titreModifierErreur" required>
                <p id="titreModifierErreur" class="message-champ"></p>
            </div>
            <div class="modifier-annonce-champ">
                <label for="texteModifierInput" class="modifier-annonce-label">Contenu de l'annonce :</label>
                <textarea class="annonce-area" id="texteModifierInput" name="contenuModifier" rows="10" maxlength="2500" aria-describedby="texteModifierErreur" required></textarea>
                <p id="texteModifierErreur" class="message-champ"></p>
            </div>
        </form>
        <div class="annonce-modification-navigation">
            <button type="submit" form="formulaireModifierAnnonce" class="envoyer-modification-annonce" name="action" value="modifierAnnonce">Envoyer</button>
            <button type="button" id="fermerModificationAnnonce" class="retour-modification-annonce">Annuler</button>
        </div>    
    </section>
</div>

<div id="modaleSuppressionAnnonce" class="modale-cachee"> 
    <section class="fenetre-suppression-annonce">
        <h2 class="entete-suppression-annonce">Suppression de l'annonce</h2>
        <p class="texte-preventif-annonce">ATTENTION : êtes-vous sûr de vouloir supprimer cette annonce ?</p>
        <form id="formulaireSupprimerAnnonce" class="supprimer-annonce-formulaire" method="post">
            <input type="hidden" name="idCible" id="idCibleSupprimer">
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <button type="submit" class="envoyer-suppression-annonce" name="action" value="supprimerAnnonce">Supprimer</button>
            <button type="button" id="fermerSuppressionAnnonce" class="retour-suppression-annonce">Annuler</button>
        </form>
    </section>
</div>