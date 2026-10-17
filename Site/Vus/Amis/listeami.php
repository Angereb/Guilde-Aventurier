<main class="liste-amis-page">
    <section class="feuille-liste-amis">
        <h1 class="titre">Votre liste de contacts</h1>
        <form id="formulaireContact" class="formulaire-contact" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="creerContactInput" class="creer-contact-label">Pseudo : </label>
            <input type="text" class="creer-contact-input" id="creerContactInput" placeholder="Contact" name="contact" aria-describedby="creerContact">
            <p id="creerContact" class="message-champ"></p>
            <button type="submit" class="demande-contact" name="action" value="demandeContact">Demander en ami</button>
            <button type="submit" class="blocage-contact" name="action" value="blocageContact">Bloquer le pseudo</button>
        </form>
        <div class="zone-tableau">
            <?php if (!empty($relations)): ?>
                <table class="tableau-contact">
                    <caption class="titre-tableau">Liste des contacts</caption>
                    <thead>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">État</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($relations as $relationActive): ?>
                            <tr>
                               <th scope="row"><?= htmlspecialchars($relationActive["pseudo"]) ?></th>
                               <td><?php $libelleStatut = RelationUtilisateur::LIBELLES_STATUTS[$relationActive["typeRelation"]]; ?><?= htmlspecialchars($libelleStatut) ?></td>
                               <td class="zone-bouton">
                                    <?php if ($relationActive["typeRelation"] === "en_attente"): ?>
                                        <form class="formulaire-validation" method="post">
                                            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                            <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                            <button type="submit" class="valider-ami" name="action" value="validerAmi">Valider</button>
                                        </form>
                                        <form class="formulaire-refus" method="post">
                                            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                            <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                            <button type="submit" class="refus-ami" name="action" value="refuserAmi">Refuser</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if (in_array($relationActive["typeRelation"], ["ami", "rival"], true)): ?>
                                        <?php if ($relationActive["typeRelation"] === "ami"): ?>
                                            <form class="formulaire-changer-vers-rival" method="post">
                                                <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                                <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                                <button type="submit" class="changer-vers-rival" name="action" value="changerVersRival">Passer en rival</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if ($relationActive["typeRelation"] === "rival"): ?>
                                            <form class="formulaire-changer-vers-ami" method="post">
                                                <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                                <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                                <button type="submit" class="changer-vers-ami" name="action" value="changerVersAmi">Passer en ami</button>
                                            </form>
                                        <?php endif; ?> 
                                        <form class="formulaire-retirer" method="post">
                                            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                            <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                            <button type="submit" class="retirer-contact" name="action" value="retirerContact">Retirer de la liste</button>
                                        </form>
                                    <?php endif; ?> 
                                    <?php if ($relationActive["typeRelation"] === "bloque"): ?>
                                        <form class="formulaire-deblocage" method="post">
                                            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                            <input type="hidden" name="contactId" value="<?= htmlspecialchars($relationActive["contactId"]) ?>">
                                            <button type="submit" class="debloquer-contact" name="action" value="debloquerContact">Débloquer</button>
                                        </form>
                                    <?php endif; ?> 
                               </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="message-liste-vide">Vous n’avez encore aucun contact.</p>
            <?php endif; ?>
        </div>
    </section>
</main>