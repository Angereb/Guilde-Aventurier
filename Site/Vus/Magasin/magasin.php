<?php
/**@var array $caracteristiques */
/**@var array $maitrises */
?>

<div class="fenetre-magasin">
    <div class="zone-filtre">
        <label for="filtreCategorie" class="visuellement-cache">Catégorie : </label>
        <select class="bouton-filtre" id="filtreCategorie">
            <option value="">Catégorie</option>
            <?php foreach (Equipement::CATEGORIES_VALIDES as $categorie): ?>
                <option value="<?= $categorie ?>"><?php $libelleCategorie = Equipement::LIBELLES_CATEGORIE[$categorie]; ?><?= htmlspecialchars($libelleCategorie) ?></option>
            <?php endforeach ?>
        </select>
        <label for="filtreCaracteristique" class="visuellement-cache">Caractéristique : </label>
        <select class="bouton-filtre" id="filtreCaracteristique">
            <option value="">Caractéristique</option>
            <?php foreach ($caracteristiques as $caracteristique): ?>
                <option value="<?= $caracteristique->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristique->getNom()) ?></option>
            <?php endforeach ?>
        </select>
        <label for="filtreMaitrise" class="visuellement-cache">Maîtrise : </label>
        <select class="bouton-filtre" id="filtreMaitrise">
            <option value="">Maîtrise</option>
            <?php foreach ($maitrises as $maitrise): ?>
                <option value="<?= $maitrise->getMaitriseId() ?>"><?= htmlspecialchars($maitrise->getNom()) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="zone-catalogue" id="zoneCatalogue">
        <ul id="equipementCatalogue"></ul>
        <template id="modeleEquipementdetaille">
            <li class="zone-equipement-detaille">
                <ul class="affichage-requis"></ul>
                <div class="equipement-detaille">
                    <h3 class="affichage-nom"></h3>
                    <p class="affichage-description"></p>
                    <ul class="affichage-modificateur-principaux"></ul>
                    <p class="affichage-modificateur-attaque"></p>
                    <p class="affichage-modificateur-defense"></p>
                    <p class="affichage-modificateur-pv"></p>
                    <p class="affichage-modificateur-pe"></p>
                    <p class="affichage-modificateur-initiative"></p>
                    <p class="affichage-modificateur-mouvement"></p>
                    <p class="affichage-cout"></p>
                </div>
                <button type="button" class="ajouter-equipement">Ajouter</button>
            </li>
        </template>
    </div>
    <div class="zone-inventaire" id="zoneInventaire">
        <ul id="equipementInventaire" aria-live="polite"></ul>
        <template id="modeleEquipementInventaire">
            <li class="equipement-inventaire">
                <p class="equipement-nom"></p>
                <label class="quantite-label">Quantité : 
                    <input type="number" class="quantite-input" min="1">
                </label>
                <p class="equipement-etat"></p>
                <p class="equipement-cout"></p>
                <button type="button" class="supprimer-equipement">Supprimer</button>
            </li>
        </template>
        <p class="total-pc" id="totalPC"></p>
    </div>
    <div class="zone-navigation-magasin">
        <button type="button" class="retour-magasin" id="fermetureMagasin">Annuler</button>
        <button type="button" class="validation-magasin" id="validationMagasin">Acheter</button>
    </div>
</div>