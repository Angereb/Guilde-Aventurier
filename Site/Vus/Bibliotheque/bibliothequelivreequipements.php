<?php
/**@var array $roles */
/**@var string $categorie */
/**@var array $equipementsDetailles */
/**@var array $caracteristiques */
/**@var array $maitrises */
?>

<main class="bibliotheque-equipement-livre-page">
    <header class="bibliotheque-equipement-livre-titre">
        <h1>Équipements <?= htmlspecialchars(Equipement::LIBELLES_CATEGORIE[$categorie]) ?></h1>
    </header>
    <div class="niche-livre">
        <div class="livre">
            <div class="zone-livre">
                <?php if ($equipementsDetailles === []) : ?>
                    <p class="affichage-vide">Il n'y a pas encore d'équipements dans cette catégorie.</p>
                <?php else : ?>
                    <?php foreach ($equipementsDetailles as $equipementDetaille) : ?>
                        <article class="zone-equipement">
                            <?php foreach ($equipementDetaille["requis"] as $requisEquipement) : ?>
                                <p class="affichage-requis"><?= htmlspecialchars($requisEquipement["nom"]) ?> : <?= htmlspecialchars($requisEquipement["valeur"]) ?></p>
                            <?php endforeach ?>
                            <div class="equipement-detaille">
                                <?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
                                    <button type="button" class="ouverture-modale-equipement" data-equipement="<?= htmlspecialchars(json_encode($equipementDetaille)) ?>" aria-label="Ouverture modification <?= htmlspecialchars($equipementDetaille["equipement"]->getNom()) ?>"></button>
                                <?php endif; ?>
                                <h2 class="affichage-nom"><?= htmlspecialchars($equipementDetaille["equipement"]->getNom()) ?></h2>
                                <p class="affichage-description"><?= htmlspecialchars($equipementDetaille["equipement"]->getDescriptions()) ?></p>
                                <?php foreach ($equipementDetaille["modificateurs"] as $modificateurEquipement) : ?>
                                    <p class="affichage-modificateur-principaux"><?= htmlspecialchars($modificateurEquipement["nom"]) ?> : <?= htmlspecialchars($modificateurEquipement["valeur"]) ?></p>
                                <?php endforeach ?>
                                <?php if ($equipementDetaille["equipement"]->getModifAttaque() !== null): ?>
                                    <p class="affichage-modificateur-attaque">Attaque : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifAttaque()) ?></p>
                                <?php endif ?>
                                <?php if ($equipementDetaille["equipement"]->getModifDefense() !== null): ?>
                                    <p class="affichage-modificateur-defense">Défense : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifDefense()) ?></p>
                                <?php endif ?>
                                <?php if ($equipementDetaille["equipement"]->getModifPV() !== null): ?>
                                    <p class="affichage-modificateur-pv">PV : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifPV()) ?></p>
                                <?php endif ?>
                                <?php if ($equipementDetaille["equipement"]->getModifPE() !== null): ?>
                                    <p class="affichage-modificateur-pe">PE : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifPE()) ?></p>
                                <?php endif ?>
                                <?php if ($equipementDetaille["equipement"]->getModifInitiative() !== null): ?>
                                    <p class="affichage-modificateur-initiative">Initiative : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifInitiative()) ?></p>
                                <?php endif ?>
                                <?php if ($equipementDetaille["equipement"]->getModifMouvement() !== null): ?>
                                    <p class="affichage-modificateur-mouvement">Mouvement : <?= htmlspecialchars($equipementDetaille["equipement"]->getModifMouvement()) ?></p>
                                <?php endif ?>
                                <p class="affichage-cout">Coût en PC : <?= htmlspecialchars($equipementDetaille["equipement"]->getCoutPC()) ?></p>
                            </div>
                        </article>
                    <?php endforeach ?>
                <?php endif ?>                
            </div>
            <nav class="retour-categorie" aria-label="Retour">
                <a href="?page=bibliothequeequipements" class="fleche-retour" aria-label="Retour vers le choix de catégorie"></a>
            </nav>
        </div>
    </div>
    <nav class="navigation-pages" aria-label="Pages du livre">
        <button type="button" id="pagePrecedente" class="page-precedente" aria-label="Page précédente"></button>
        <button type="button" id="pageSuivante" class="page-suivante" aria-label="Page suivante"></button>
    </nav>
</main>

<?php if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)): ?>
    <div id="modaleEquipement" class="modale-cachee">
        <section class="fenetre-equipement">
            <h2 class="titre-modale">Équipement</h2>
            <form id="formulaireEquipement" class="formulaire-equipement" method="post" novalidate>
                <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                <input type="hidden" id="equipementId" name="equipementId">
                <input type="hidden" id="categorieEquipement" name="equipementCategorie">
                <label for="nomEquipement" class="equipement-label">Nom : </label>
                <input type="text" class="equipement-input" id="nomEquipement" placeholder="Nom de l'équipement" name="equipementNom" aria-describedby="nomEquipementErreur" required>
                <p id="nomEquipementErreur" class="message-champ"></p>
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
                <button type="button" class="retour-equipement" id="fermetureModaleEquipement">Annuler</button>
                <button type="submit" class="envoyer-equipement" name="action" value="equipementEnvoyer">Envoyer</button>
                <button type="submit" class="supprimer-equipement" name="action" value="equipementSupprimer">Supprimer</button>
            </form>
        </section>
    </div>
<?php endif; ?>