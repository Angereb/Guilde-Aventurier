<?php
/**@var array $nomsCaracteristiques */
/**@var array $competencesDetailles */
/**@var array $equipementsDetailles */
/**@var array $nomsZonesEffets */
/**@var array $iconesZonesEffets */
/**@var array $caracteristiques */
/**@var array $maitrises */
?>

<script>
    const DONNEES_FICHE = <?= json_encode([
        "regles" => REGLES,
        "nomsCaracteristiques" => $nomsCaracteristiques,
        "competences" => $competencesDetailles,
        "equipements" => $equipementsDetailles,
        "nomsZonesEffets" => $nomsZonesEffets,
        "iconesZonesEffets" => $iconesZonesEffets,
        "libellesEtats" => EquipementAventurierModele::LIBELLES_ETATS
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>

<main class="creation-aventurier-page">
    <header class="creation-aventurier-titre">
        <h1>Fiche d'aventurier</h1>
    </header>
    <form id="formulaireAventurier" class="formulaire-aventurier" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
        <fieldset class="zone-information-base">
            <div class="zone-nom">
                <label for="nomAventurier" class="aventurier-label">Nom :</label>
                <input type="text" class="aventurier-input" id="nomAventurier" name="aventurierNom" aria-describedby="nomAventurierErreur" required>
                <p id="nomAventurierErreur" class="message-champ"></p>
            </div>
            <div class="zone-icone">
                <input type="file" class="visuellement-cache" id="iconeAventurier" accept="image/png, image/jpeg, image/webp" name="aventurierIcone" aria-describedby="iconeAventurierErreur">
                <div class="cadre-icone">
                    <label for="iconeAventurier" class="bouton-icone">
                        <img id="apercuIconeAventurier" class="apercu-icone" src="data:," alt="" hidden>
                        <span class="visuellement-cache">Choisir une icône</span>
                    </label>
                </div>
                <p id="iconeAventurierErreur" class="message-champ"></p>
            </div>
            <div class="zone-pv">
                <span class="aventurier-label">PV :</span>
                <output id="pvActuelAventurier" aria-label="Points de vie actuels"></output>
                <span aria-hidden="true"> / </span>
                <output id="pvMaxAventurier" aria-label="Points de vie maximum"></output>
            </div>
            <div class="zone-pe">
                <span class="aventurier-label">PE :</span>
                <output id="peActuelAventurier" aria-label="Points d'endurance actuels"></output>
                <span aria-hidden="true"> / </span>
                <output id="peMaxAventurier" aria-label="Points d'endurance maximum"></output>
            </div>
            <div class="zone-attaque">
                <span class="aventurier-label">Attaque :</span>
                <output id="attaqueAventurier" class="aventurier-attaque"></output>
            </div>
            <div class="zone-defense">
                <span class="aventurier-label">Défense :</span>
                <output id="defenseAventurier" class="aventurier-defense"></output>
            </div>
            <div class="zone-initiative">
                <span class="aventurier-label">Initiative :</span>
                <output id="initiativeAventurier" class="aventurier-initiative"></output>
            </div>
            <div class="zone-mouvement">
                <span class="aventurier-label">Mouvement :</span>
                <output id="mouvementAventurier" class="aventurier-mouvement"></output>
            </div>
        </fieldset>
        <fieldset class="zone-information-caracteristique">
            <legend>Caractéristiques</legend>
            <?php foreach ($caracteristiques as $caracteristique): ?>
                <div class="ligne-valeur">
                    <label for="caracteristique-<?= $caracteristique->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristique->getNom()) ?> : </label>
                    <div class="zone-valeur">
                        <button type="button" class="diminuer" data-pas="-10" aria-label="Diminuer <?= htmlspecialchars($caracteristique->getNom()) ?> de 10">▼▼</button>
                        <button type="button" class="diminuer" data-pas="-1" aria-label="Diminuer <?= htmlspecialchars($caracteristique->getNom()) ?> de 1">▼</button>
                        <input type="number" id="caracteristique-<?= $caracteristique->getCaracteristiqueId() ?>" name="caracteristiques[<?= $caracteristique->getCaracteristiqueId() ?>]" value="<?= REGLES["caracteristiques"]["depart"] ?>" min="<?= REGLES["caracteristiques"]["minimum"] ?>" max="<?= REGLES["caracteristiques"]["maximum"] ?>" class="valeur-caracteristique" aria-describedby="caracteristiquesErreur">
                        <button type="button" class="augmenter" data-pas="1" aria-label="Augmenter <?= htmlspecialchars($caracteristique->getNom()) ?> de 1">▲</button>
                        <button type="button" class="augmenter" data-pas="10" aria-label="Augmenter <?= htmlspecialchars($caracteristique->getNom()) ?> de 10">▲▲</button>
                    </div>
                </div>
            <?php endforeach ?>
            <p id="caracteristiquesErreur" class="message-champ"></p>
        </fieldset>
        <fieldset class="zone-information-maitrise">
            <legend>Maîtrises</legend>
            <?php foreach ($maitrises as $maitrise): ?>
                <div class="ligne-valeur">
                    <label for="maitrise-<?= $maitrise->getMaitriseId() ?>"><?= htmlspecialchars($maitrise->getNom()) ?> : </label>
                    <div class="zone-valeur">
                        <button type="button" class="diminuer" data-pas="-10" aria-label="Diminuer <?= htmlspecialchars($maitrise->getNom()) ?> de 10">▼▼</button>
                        <button type="button" class="diminuer" data-pas="-1" aria-label="Diminuer <?= htmlspecialchars($maitrise->getNom()) ?> de 1">▼</button>
                        <input type="number" id="maitrise-<?= $maitrise->getMaitriseId() ?>" name="maitrises[<?= $maitrise->getMaitriseId() ?>]" value="<?= REGLES["maitrises"]["depart"] ?>" min="<?= REGLES["maitrises"]["minimum"] ?>" max="<?= REGLES["maitrises"]["maximum"] ?>" class="valeur-maitrise" aria-describedby="maitrisesErreur">
                        <button type="button" class="augmenter" data-pas="1" aria-label="Augmenter <?= htmlspecialchars($maitrise->getNom()) ?> de 1">▲</button>
                        <button type="button" class="augmenter" data-pas="10" aria-label="Augmenter <?= htmlspecialchars($maitrise->getNom()) ?> de 10">▲▲</button>
                    </div>
                </div>
            <?php endforeach ?>
            <p id="maitrisesErreur" class="message-champ"></p>
        </fieldset>
        <fieldset class="zone-information-equipement">
            <legend>Équipements</legend>
            <div class="zone-bouton-magasin">
                <button type="button" class="ouverture-modale-magasin" id="ouvertureModaleMagasin"><span>Magasin</span></button>
            </div>
            <?php foreach (Equipement::CATEGORIES_VALIDES as $categorie): ?>
                <p class="label-categorie-equipement" id="nom<?= $categorie ?>"><?php $libelleCategorie = Equipement::LIBELLES_CATEGORIE[$categorie]; ?><?= htmlspecialchars($libelleCategorie) ?></p>
                <ul data-categorie="<?= $categorie ?>" aria-labelledby="nom<?= $categorie ?>"></ul>
            <?php endforeach ?>
            <template id="modeleLigneEquipement">
                <li class="ligne-equipement">
                    <p class="equipement-nom"></p>
                    <p class="equipement-quantite"></p>
                    <p class="equipement-etat"></p>
                    <button type="button" class="equiper-equipement"></button>
                </li>
            </template>
            <p id="messageEquipement" aria-live="polite"></p>
            <input type="hidden" id="inventaireAventurier" name="inventaireAventurier" value="[]"> 
        </fieldset>
        <fieldset class="zone-information-competence">
            <legend>Compétences</legend>
            <ul id="competence" aria-live="polite"></ul>
            <template id="modeleZoneCompetence">
                <li class="zone-competence">
                    <h2 class="nom-competence"></h2>
                    <p class="recueil-competence"></p>
                    <p class="descriptions-competence"></p>
                    <div class="modificateur-competence">
                        <ul class="modificateur-principaux-competence"></ul>
                        <p class="modificateur-attaque-competence"></p>
                        <p class="modificateur-defense-competence"></p>
                        <p class="modificateur-pv-competence"></p>
                        <p class="modificateur-pe-competence"></p>
                        <p class="modificateur-initiative-competence"></p>
                        <p class="modificateur-mouvement-competence"></p>
                    </div>
                    <img class="icone-zone-effet-competence" alt="Zone d'effet">
                    <p class="cout-pe-competence"></p>
                </li>
            </template>            
        </fieldset>
        <div class="bas-de-fiche">
            <nav class="retour-taverne" aria-label="Retour">
                <a href="?page=taverne" class="fleche-retour" aria-label="Retour vers la taverne"></a>
            </nav>
            <div class="zone-pc">
                <output id="pcAventurier" class="aventurier-pc" aria-label="Points de compagnie"></output>
            </div>
            <div class="zone-signature">
                <button type="submit" class="envoyer-aventurier" name="action" value="aventurierEnvoyer">Signature</button>
            </div>
        </div>
    </form>
</main>

<div id="modaleMagasin" class="modale-cachee">
    <?php require_once __DIR__ . "/../Magasin/magasin.php" ?>
</div>