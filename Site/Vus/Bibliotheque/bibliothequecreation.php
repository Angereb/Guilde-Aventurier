<?php
/**@var array $zonesEffets */
/**@var array $caracteristiques */
/**@var array $maitrises */
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
    <section class="fenetre-zone-effet">
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
            </div>
            <label for="nomZoneEffet" class="zone-effet-label">Nom : </label>
            <input type="text" class="zone-effet-input" id="nomZoneEffet" placeholder="Nom de zone" name="zoneEffetNom" aria-describedby="nomZoneEffetErreur" required>
            <p id="nomZoneEffetErreur" class="message-champ"></p>
            <fieldset class="choix-directions" id="directionsZoneEffet" aria-describedby="zoneEffetDirectionsErreur">
                <legend>Directions :</legend>
                <?php foreach (ZoneEffet::DIRECTIONS_VALIDES as $direction): ?>
                    <label class="direction-<?= $direction ?>">
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
            <input type="file" class="visuellement-cache" id="iconeZoneEffet" accept="image/png, image/jpeg, image/webp" name="zoneEffetIcone" aria-describedby="iconeZoneEffetErreur">
            <label for="iconeZoneEffet" class="bouton-fichier">Choisir une icône</label>
            <p id="nomFichierZoneEffet" class="nom-fichier">Aucun fichier choisi</p>
            <p id="iconeZoneEffetErreur" class="message-champ"></p>
            <img id="iconeZoneEffetImage" class="icone-zone-effet-image" alt="Icône actuelle de la zone d'effet" hidden>
            <p id="iconeZoneEffetAvertissement" class="avertissement-icone" hidden>En cas de non modification de l'image, laissez le champ d'entrée de l'icône vide.</p>
            <button type="submit" class="envoyer-zone-effet" id="envoyerZoneEffet" name="action" value="zoneEffetEnvoyer">Envoyer</button>
            <button type="button" class="retour-zone-effet" id="fermetureModaleZoneEffet">Annuler</button>
        </form>
    </section>
</div>

<div id="modaleEquipement" class="modale-cachee">
    <section class="fenetre-equipement">
        <h2 class="titre-modale">Équipement</h2>
        <form id="formulaireEquipement" class="formulaire-equipement" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="nomEquipement" class="equipement-label">Nom : </label>
            <input type="text" class="equipement-input" id="nomEquipement" placeholder="Nom de l'équipement" name="equipementNom" aria-describedby="nomEquipementErreur" required>
            <p id="nomEquipementErreur" class="message-champ"></p>
            <label for="categorieEquipement" class="equipement-label">Catégorie : </label>
            <select class="selection-equipement" id="categorieEquipement" name="equipementCategorie">
                <?php foreach (Equipement::CATEGORIES_VALIDES as $categorie): ?>
                    <option value="<?= $categorie ?>"><?php $libelleCategorie = Equipement::LIBELLES_CATEGORIE[$categorie]; ?><?= htmlspecialchars($libelleCategorie) ?></option>
                <?php endforeach ?>
            </select>
            <label for="descriptionsEquipement" class="equipement-label">Description : </label>
            <textarea class="equipement-input" id="descriptionsEquipement" name="equipementDescriptions" rows="10" maxlength="2500" aria-describedby="descriptionsEquipementErreur"></textarea>
            <p id="descriptionsEquipementErreur" class="message-champ"></p>
            <label for="coutPCEquipement" class="equipement-label">Coût en PC : </label>
            <input type="number" class="equipement-input" id="coutPCEquipement" name="equipementCoutPC" min="1" aria-describedby="coutPCEquipementErreur">
            <p id="coutPCEquipementErreur" class="message-champ"></p>
            <div class="zone-requis-equipement" id="zoneRequisEquipement">
                <p class="message-requis">Veuillez sélectionner un ou plusieurs prérequis pour cet équipement</p>
                <template id="modeleLigneRequisEquipement">
                    <div class="ligne-requis">
                        <label>
                            Prérequis :
                            <select name="equipementRequisCibles[]" class="selection-requis">
                                <option value="">Aucun</option>
                                <optgroup label="Caractéristiques">
                                    <?php foreach ($caracteristiques as $caracteristiqueRequise): ?>
                                        <option value="caracteristique-<?= $caracteristiqueRequise->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristiqueRequise->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <optgroup label="Maîtrises">
                                    <?php foreach ($maitrises as $maitriseRequise): ?>
                                        <option value="maitrise-<?= $maitriseRequise->getMaitriseId() ?>"><?= htmlspecialchars($maitriseRequise->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            </select>
                        </label>
                        <label>
                            Valeur :
                            <input type="number" name="equipementRequisValeurs[]" class="valeur-requis" min="1" aria-describedby="requisEquipementErreur">
                        </label>
                    </div>
                </template>
            </div>
            <p id="requisEquipementErreur" class="message-champ"></p>
            <div class="zone-modificateur-equipement" id="zoneModificateurEquipement">
                <p class="message-modificateur">Veuillez sélectionner un ou plusieurs modificateurs pour cet équipement</p>
                <template id="modeleLigneModificateurEquipement">
                    <div class="ligne-modificateur">
                        <label>
                            Modificateur :
                            <select name="equipementModificateurCibles[]" class="selection-modificateur">
                                <option value="">Aucun</option>
                                <optgroup label="Caractéristiques">
                                    <?php foreach ($caracteristiques as $caracteristiqueModificateur): ?>
                                        <option value="caracteristique-<?= $caracteristiqueModificateur->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristiqueModificateur->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <optgroup label="Maîtrises">
                                    <?php foreach ($maitrises as $maitriseModificateur): ?>
                                        <option value="maitrise-<?= $maitriseModificateur->getMaitriseId() ?>"><?= htmlspecialchars($maitriseModificateur->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            </select>
                        </label>
                        <label>
                            Valeur :
                            <input type="number" name="equipementModificateurValeurs[]" class="valeur-modificateur" aria-describedby="modifEquipementErreur">
                        </label>
                    </div>
                </template>
            </div>
            <p id="modifEquipementErreur" class="message-champ"></p>
            <fieldset class="zone-caracteristiques-secondaires-equipement">
                <legend>Modificateurs des caractéristiques secondaires : </legend>
                <label for="modifAttaqueEquipement" class="equipement-label">Modificateur d'attaque : </label>
                <input type="number" class="equipement-input" id="modifAttaqueEquipement" name="equipementModifAttaque" aria-describedby="modifAttaqueEquipementErreur">
                <p id="modifAttaqueEquipementErreur" class="message-champ"></p>
                <label for="modifDefenseEquipement" class="equipement-label">Modificateur de défense : </label>
                <input type="number" class="equipement-input" id="modifDefenseEquipement" name="equipementModifDefense" aria-describedby="modifDefenseEquipementErreur">
                <p id="modifDefenseEquipementErreur" class="message-champ"></p>
                <label for="modifPVEquipement" class="equipement-label">Modificateur de PV : </label>
                <input type="number" class="equipement-input" id="modifPVEquipement" name="equipementModifPV" aria-describedby="modifPVEquipementErreur">
                <p id="modifPVEquipementErreur" class="message-champ"></p>
                <label for="modifPEEquipement" class="equipement-label">Modificateur de PE : </label>
                <input type="number" class="equipement-input" id="modifPEEquipement" name="equipementModifPE" aria-describedby="modifPEEquipementErreur">
                <p id="modifPEEquipementErreur" class="message-champ"></p>
                <label for="modifInitiativeEquipement" class="equipement-label">Modificateur d'initiative : </label>
                <input type="number" class="equipement-input" id="modifInitiativeEquipement" name="equipementModifInitiative" aria-describedby="modifInitiativeEquipementErreur">
                <p id="modifInitiativeEquipementErreur" class="message-champ"></p>
                <label for="modifMouvementEquipement" class="equipement-label">Modificateur de mouvement : </label>
                <input type="number" class="equipement-input" id="modifMouvementEquipement" name="equipementModifMouvement" aria-describedby="modifMouvementEquipementErreur">
                <p id="modifMouvementEquipementErreur" class="message-champ"></p>
            </fieldset>
            <button type="submit" class="envoyer-equipement" name="action" value="equipementEnvoyer">Envoyer</button>
            <button type="button" class="retour-equipement" id="fermetureModaleEquipement">Annuler</button>
        </form>
    </section>
</div>

<div id="modaleMaitrise" class="modale-cachee">
    <section class="fenetre-maitrise">
        <h2 class="titre-modale">Maîtrises</h2>
        <form id="formulaireMaitrise" class="formulaire-maitrise" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="nomMaitrise" class="maitrise-label">Nom : </label>
            <input type="text" class="maitrise-input" id="nomMaitrise" placeholder="Nom de la maîtrise" name="maitriseNom" aria-describedby="nomMaitriseErreur" required>
            <p id="nomMaitriseErreur" class="message-champ"></p>
            <label for="descriptionsMaitrise" class="maitrise-label">Description : </label>
            <textarea class="maitrise-input" id="descriptionsMaitrise" name="maitriseDescriptions" rows="10" maxlength="2500" aria-describedby="descriptionsMaitriseErreur"></textarea>
            <p id="descriptionsMaitriseErreur" class="message-champ"></p>
            <button type="submit" class="envoyer-maitrise" name="action" value="maitriseEnvoyer">Envoyer</button>
            <button type="button" class="retour-maitrise" id="fermetureModaleMaitrise">Annuler</button>
        </form>
    </section>
</div>

<div id="modaleCompetence" class="modale-cachee">
    <section class="fenetre-competence">
        <h2 class="titre-modale">Compétences</h2>
        <form id="formulaireCompetence" class="formulaire-competence" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="nomCompetence" class="competence-label">Nom : </label>
            <input type="text" class="competence-input" id="nomCompetence" placeholder="Nom de la compétence" name="competenceNom" aria-describedby="nomCompetenceErreur" required>
            <p id="nomCompetenceErreur" class="message-champ"></p>
            <label for="typeCompetence" class="competence-label">Type : </label>
            <select class="selection-competence" id="typeCompetence" name="competenceType">
                <?php foreach (Competence::TYPES_VALIDES as $type): ?>
                    <option value="<?= $type ?>"><?php $libelleType = Competence::LIBELLES_TYPES[$type]; ?><?= htmlspecialchars($libelleType) ?></option>
                <?php endforeach ?>
            </select>
            <label for="descriptionsCompetence" class="competence-label">Description : </label>
            <textarea class="competence-input" id="descriptionsCompetence" name="competenceDescriptions" rows="10" maxlength="2500" aria-describedby="descriptionsCompetenceErreur"></textarea>
            <p id="descriptionsCompetenceErreur" class="message-champ"></p>
            <label for="coutPECompetence" class="competence-label">Coût en PE : </label>
            <input type="number" class="competence-input" id="coutPECompetence" name="competenceCoutPE" aria-describedby="coutPECompetenceErreur">
            <p id="coutPECompetenceErreur" class="message-champ"></p>
            <label for="zoneEffetCompetence" class="competence-label">Zone d'effet : </label>
            <select class="selection-zone-effet-competence" id="zoneEffetCompetence" name="competenceZoneEffetId" aria-describedby="zoneEffetCompetenceErreur">
                <option value="">Aucune (compétence passive)</option>
                <?php foreach ($zonesEffets as $zoneEffet): ?>
                    <option value="<?= $zoneEffet->getZoneEffetId() ?>"><?= htmlspecialchars($zoneEffet->getNom()) ?></option>
                <?php endforeach ?>
            </select>
            <p id="zoneEffetCompetenceErreur" class="message-champ"></p>
            <div class="zone-requis-competence" id="zoneRequisCompetence">
                <p class="message-requis">Veuillez sélectionner un ou plusieurs prérequis pour cette compétence</p>
                <template id="modeleLigneRequisCompetence">
                    <div class="ligne-requis">
                        <label>
                            Prérequis :
                            <select name="competenceRequisCibles[]" class="selection-requis">
                                <option value="">Aucun</option>
                                <optgroup label="Caractéristiques">
                                    <?php foreach ($caracteristiques as $caracteristiqueRequise): ?>
                                        <option value="caracteristique-<?= $caracteristiqueRequise->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristiqueRequise->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <optgroup label="Maîtrises">
                                    <?php foreach ($maitrises as $maitriseRequise): ?>
                                        <option value="maitrise-<?= $maitriseRequise->getMaitriseId() ?>"><?= htmlspecialchars($maitriseRequise->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            </select>
                        </label>
                        <label>
                            Valeur :
                            <input type="number" name="competenceRequisValeurs[]" class="valeur-requis" min="1" aria-describedby="requisCompetenceErreur">
                        </label>
                    </div>
                </template>
            </div>
            <p id="requisCompetenceErreur" class="message-champ"></p>
            <div class="zone-modificateur-competence" id="zoneModificateurCompetence">
                <p class="message-modificateur">Veuillez sélectionner un ou plusieurs modificateurs pour cette compétence</p>
                <template id="modeleLigneModificateurCompetence">
                    <div class="ligne-modificateur">
                        <label>
                            Modificateur :
                            <select name="competenceModificateurCibles[]" class="selection-modificateur">
                                <option value="">Aucun</option>
                                <optgroup label="Caractéristiques">
                                    <?php foreach ($caracteristiques as $caracteristiqueModificateur): ?>
                                        <option value="caracteristique-<?= $caracteristiqueModificateur->getCaracteristiqueId() ?>"><?= htmlspecialchars($caracteristiqueModificateur->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <optgroup label="Maîtrises">
                                    <?php foreach ($maitrises as $maitriseModificateur): ?>
                                        <option value="maitrise-<?= $maitriseModificateur->getMaitriseId() ?>"><?= htmlspecialchars($maitriseModificateur->getNom()) ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            </select>
                        </label>
                        <label>
                            Valeur :
                            <input type="number" name="competenceModificateurValeurs[]" class="valeur-modificateur" aria-describedby="modifCompetenceErreur">
                        </label>
                    </div>
                </template>
            </div>
            <p id="modifCompetenceErreur" class="message-champ"></p>
            <fieldset class="zone-caracteristiques-secondaires-competence">
                <legend>Modificateurs des caractéristiques secondaires : </legend>
                <label for="modifAttaqueCompetence" class="competence-label">Modificateur d'attaque : </label>
                <input type="number" class="competence-input" id="modifAttaqueCompetence" name="competenceModifAttaque" aria-describedby="modifAttaqueCompetenceErreur">
                <p id="modifAttaqueCompetenceErreur" class="message-champ"></p>
                <label for="modifDefenseCompetence" class="competence-label">Modificateur de défense : </label>
                <input type="number" class="competence-input" id="modifDefenseCompetence" name="competenceModifDefense" aria-describedby="modifDefenseCompetenceErreur">
                <p id="modifDefenseCompetenceErreur" class="message-champ"></p>
                <label for="modifPVCompetence" class="competence-label">Modificateur de PV : </label>
                <input type="number" class="competence-input" id="modifPVCompetence" name="competenceModifPV" aria-describedby="modifPVCompetenceErreur">
                <p id="modifPVCompetenceErreur" class="message-champ"></p>
                <label for="modifPECompetence" class="competence-label">Modificateur de PE : </label>
                <input type="number" class="competence-input" id="modifPECompetence" name="competenceModifPE" aria-describedby="modifPECompetenceErreur">
                <p id="modifPECompetenceErreur" class="message-champ"></p>
                <label for="modifInitiativeCompetence" class="competence-label">Modificateur d'initiative : </label>
                <input type="number" class="competence-input" id="modifInitiativeCompetence" name="competenceModifInitiative" aria-describedby="modifInitiativeCompetenceErreur">
                <p id="modifInitiativeCompetenceErreur" class="message-champ"></p>
                <label for="modifMouvementCompetence" class="competence-label">Modificateur de mouvement : </label>
                <input type="number" class="competence-input" id="modifMouvementCompetence" name="competenceModifMouvement" aria-describedby="modifMouvementCompetenceErreur">
                <p id="modifMouvementCompetenceErreur" class="message-champ"></p>
            </fieldset>
            <button type="submit" class="envoyer-competence" name="action" value="competenceEnvoyer">Envoyer</button>
            <button type="button" class="retour-competence" id="fermetureModaleCompetence">Annuler</button>
        </form>
    </section>
</div>