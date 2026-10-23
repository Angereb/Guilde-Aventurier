<?php
/**@var array $zonesEffets */
?>

<main class="bibliotheque-creation-page">
    <header class="bibliotheque-creation-titre">
        <h1>Bibliothèque : Création</h1>
    </header>
    <div class="bibliotheque-creation-zonage">
        <button type="button" class="ouverture-modale-zone-effet" id="ouvertureModaleZoneEffet"><span>Zone d'effet</span></button>
        <button type="button" class="ouverture-modale-equipement" id="ouvertureModaleEquipement"><span>Équipement</span></button>
        <button type="button" class="ouverture-modale-maitrise" id="ouvertureModaleMaitrise"><span>Maîtrise</span></button>
        <button type="button" class="ouverture-modale-competence" id="ouvertureModaleCompetence"><span>Compétence</span></button>
    </div>
</main>

<div id="modaleZoneEffet" class="modale-cachee">
    <h2 class="titre-modale">Zones d'effet</h2>
    <form id="formulaireZoneEffet" class="formulaire-zone-effet" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
        <div class="champ-select">
            <label for="selectionZoneEffet" class="selection-zone-effet-label">Zone d'effet : </label>
            <select class="selection-zone-effet" id="selectionZoneEffet" name="zoneEffetId">
                <option value="">Nouvelle Zone</option>
                <?php foreach ($zonesEffets as $zoneEffet): ?>
                    <?php
                    $iconeZoneEffet = "";
                    if ($zoneEffet->getIcone() !== null) {
                        $iconeZoneEffet = "data:" . $zoneEffet->getTypeIcone() . ";base64," . base64_encode($zoneEffet->getIcone());
                    }
                    ?>
                    <option value="<?= $zoneEffet->getZoneEffetId() ?>" data-zone-effet-nom="<?= htmlspecialchars($zoneEffet->getNom()) ?>" data-zone-effet-directions="<?= implode(",", $zoneEffet->getDirections()) ?>" data-zone-effet-portee="<?= $zoneEffet->getPortee() ?>" data-zone-effet-icone="<?= $iconeZoneEffet ?>"><?= htmlspecialchars($zoneEffet->getNom()) ?></option>
                <?php endforeach ?>
            </select>
            <label for="nomZoneEffet" class="zone-effet-label">Nom : </label>
            <input type="text" class="zone-effet-input" id="nomZoneEffet" placeholder="Nom de zone" name="zoneEffetNom" aria-describedby="nomZoneEffetErreur" required>
            <p id="nomZoneEffetErreur" class="message-champ"></p>
            <fieldset class="choix-directions" aria-describedby="zoneEffetDirectionsErreur">
                <legend>Directions :</legend>
                <?php foreach (ZoneEffet::DIRECTIONS_VALIDES as $direction): ?>
                    <label>
                        <input type="checkbox" name="zoneEffetDirections[]" value="<?= $direction ?>" class="case-direction">
                        <?= $direction ?>
                    </label>
                <?php endforeach ?>
            </fieldset>
            <p id="zoneEffetDirectionsErreur" class="message-champ"></p>
            <label for="porteeZoneEffet" class="zone-effet-label">Portée : </label>
            <input type="number" class="zone-effet-input" id="porteeZoneEffet" min="1" name="zoneEffetPortee" aria-describedby="porteeZoneEffetErreur" required>
            <p id="porteeZoneEffetErreur" class="message-champ"></p>
            <label for="iconeZoneEffet" class="zone-effet-label">Icône : </label>
            <input type="file" class="zone-effet-image-input" id="iconeZoneEffet" accept="image/png, image/jpeg, image/webp" name="zoneEffetIcone" aria-describedby="iconeZoneEffetErreur">
            <p id="iconeZoneEffetErreur" class="message-champ"></p>
            <img id="iconeZoneEffetImage" class="icone-zone-effet-image" alt="Icône actuelle de la zone d'effet" hidden>
            <p id="iconeZoneEffetAvertissement" class="avertissement-icone" hidden>En cas de non modification de l'image, laissez le champ d'entrée de l'icône vide.</p>
            <button type="submit" class="envoyer-zone-effet" name="action" value="zoneEffetEnvoyer">Envoyer</button>
            <button type="button" class="retour-zone-effet" id="fermetureModaleZoneEffet">Annuler</button>
        </div>
    </form>
</div>