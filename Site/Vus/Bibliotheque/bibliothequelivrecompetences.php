<?php
/**@var array $roles */
/**@var string $libelleRecueil */
/**@var string $recueil */
/**@var array $competencesDetailles */
/**@var array $caracteristiques */
/**@var array $maitrises */
/**@var array $nomsZonesEffets */
/**@var array $iconesZonesEffets */
/**@var array $zonesEffets */
?>

<main class="bibliotheque-competence-livre-page">
    <header class="bibliotheque-competence-livre-titre">
        <h1><?= htmlspecialchars($libelleRecueil) ?></h1>
    </header>
    <div class="niche-livre">
        <div class="livre">
            <div class="zone-livre">
                <?php foreach ($competencesDetailles as $competenceDetaille) : ?>
                    <article class="zone-competence">
                        <?php foreach ($competenceDetaille["requis"] as $requisCompetence) : ?>
                            <p class="affichage-requis"><?= htmlspecialchars($requisCompetence["nom"]) ?> : <?= htmlspecialchars($requisCompetence["valeur"]) ?></p>
                        <?php endforeach ?>
                        <div class="competence-detaille">
                            <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                                <button type="button" class="ouverture-modale-competence" data-competence="<?= htmlspecialchars(json_encode($competenceDetaille)) ?>" aria-label="Ouverture modification <?= htmlspecialchars($competenceDetaille["competence"]->getNom()) ?>"></button>
                            <?php endif; ?>
                            <h2 class="affichage-nom"><?= htmlspecialchars($competenceDetaille["competence"]->getNom()) ?></h2>
                            <p class="affichage-types"><?php $libelleType = Competence::LIBELLES_TYPES[$competenceDetaille["competence"]->getTypes()]; ?><?= htmlspecialchars($libelleType) ?></p>
                            <p class="affichage-description"><?= htmlspecialchars($competenceDetaille["competence"]->getDescriptions()) ?></p>
                            <?php foreach ($competenceDetaille["modificateurs"] as $modificateurCompetence) : ?>
                                <p class="affichage-modificateur-principaux"><?= htmlspecialchars($modificateurCompetence["nom"]) ?> : <?= htmlspecialchars($modificateurCompetence["valeur"]) ?></p>
                            <?php endforeach ?>
                            <?php if ($competenceDetaille["competence"]->getModifAttaque() !== null): ?>
                                <p class="affichage-modificateur-attaque">Attaque : <?= htmlspecialchars($competenceDetaille["competence"]->getModifAttaque()) ?></p>
                            <?php endif ?>
                            <?php if ($competenceDetaille["competence"]->getModifDefense() !== null): ?>
                                <p class="affichage-modificateur-defense">Défense : <?= htmlspecialchars($competenceDetaille["competence"]->getModifDefense()) ?></p>
                            <?php endif ?>
                            <?php if ($competenceDetaille["competence"]->getModifPV() !== null): ?>
                                <p class="affichage-modificateur-pv">PV : <?= htmlspecialchars($competenceDetaille["competence"]->getModifPV()) ?></p>
                            <?php endif ?>
                            <?php if ($competenceDetaille["competence"]->getModifPE() !== null): ?>
                                <p class="affichage-modificateur-pe">PE : <?= htmlspecialchars($competenceDetaille["competence"]->getModifPE()) ?></p>
                            <?php endif ?>
                            <?php if ($competenceDetaille["competence"]->getModifInitiative() !== null): ?>
                                <p class="affichage-modificateur-initiative">Initiative : <?= htmlspecialchars($competenceDetaille["competence"]->getModifInitiative()) ?></p>
                            <?php endif ?>
                            <?php if ($competenceDetaille["competence"]->getModifMouvement() !== null): ?>
                                <p class="affichage-modificateur-mouvement">Mouvement : <?= htmlspecialchars($competenceDetaille["competence"]->getModifMouvement()) ?></p>
                            <?php endif ?>
                            <?php $zoneEffetId = $competenceDetaille["competence"]->getZoneEffetId(); ?>
                            <?php if ($zoneEffetId !== null && isset($iconesZonesEffets[$zoneEffetId])): ?>
                                <img src="<?= $iconesZonesEffets[$zoneEffetId] ?>" alt="Zone d'effet : <?= htmlspecialchars($nomsZonesEffets[$zoneEffetId]) ?>" class="affichage-zone-effet">
                            <?php endif ?>
                            <p class="affichage-cout">Coût en PE : <?= htmlspecialchars($competenceDetaille["competence"]->getCoutPE()) ?></p>
                        </div>
                    </article>
                <?php endforeach ?> 
            </div>
            <nav class="retour-recueil" aria-label="Retour">
                <a href="?page=bibliothequecompetences" class="fleche-retour" aria-label="Retour vers le choix du recueil"></a>
            </nav>
        </div>
    </div>
    <nav class="navigation-pages" aria-label="Pages du livre">
        <button type="button" id="pagePrecedente" class="page-precedente" aria-label="Page précédente"></button>
        <button type="button" id="pageSuivante" class="page-suivante" aria-label="Page suivante"></button>
    </nav>
</main>

<?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
    <div id="modaleCompetence" class="modale-cachee">
        <section class="fenetre-competence">
            <h2 class="titre-modale">Compétences</h2>
            <form id="formulaireCompetence" class="formulaire-competence" method="post" novalidate>
                <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                <input type="hidden" id="competenceId" name="competenceId">
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
                <button type="submit" class="supprimer-competence" name="action" value="competenceSupprimer">Supprimer</button>
            </form>
        </section>
    </div>
<?php endif; ?>