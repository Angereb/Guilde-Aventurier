<?php 
/** @var array $contactsRapide */ 
?>

<main class="messagerie-page">
    <section class="feuille-messagerie">
        <h1 class="titre">Votre messagerie</h1>
        <form id="formulaireEnvoiMessage" class="formulaire-envoie-message" method="post" novalidate>
            <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
            <label for="destinataireInput" class="destinataire-label">Pseudo : </label>
            <input type="text" class="destinataire-input" id="destinataireInput" placeholder="Contact" name="destinataire" aria-describedby="destinataireErreur" list="listeContactsRapides">
            <datalist id="listeContactsRapides">
                <?php foreach ($contactsRapide as $contactRapide): ?>
                    <option value="<?= htmlspecialchars($contactRapide["pseudo"]) ?>">
                <?php endforeach; ?>
            </datalist>
            <p id="destinataireErreur" class="message-champ"></p>
            <button type="button" class="ecrire-ouverture" id="ecrireOuverture">Écrire</button>
        </form>
        <div class="zone-tableau">
            <?php if (!empty($messages)): ?>
                <table class="tableau-message-recu">
                    <caption class="titre-tableau">Messages reçus</caption>
                    <thead>
                        <tr>
                            <th scope="col">Expéditeur</th>
                            <th scope="col">Titre</th>
                            <th scope="col">État</th>
                            <th scope="col">Suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?= htmlspecialchars($message["expediteur"]) ?></td>
                                <th scope="row">
                                    <button type="button" class="ouverture-message" data-id="<?= $message["messageId"] ?>" data-expediteur="<?= htmlspecialchars($message["expediteur"]) ?>" data-titre="<?= htmlspecialchars($message["titre"]) ?>" data-contenu="<?= htmlspecialchars($message["contenu"]) ?>" data-envoye-le="<?= htmlspecialchars($message["envoyeLe"]) ?>" data-lu="<?= (int)$message["lu"] ?>"><?= htmlspecialchars($message["titre"]) ?></button>
                                </th>
                                <td class="etat-message"><?php if ($message["lu"] === true): ?>Message lu<?php else: ?> Nouveau message<?php endif ?></td>
                                <td>
                                    <form class="formulaire-suppression-message" method="post">
                                        <input type="hidden" name="jetonCsrf" value="<?= htmlspecialchars($_SESSION["jetonCsrf"]) ?>">
                                        <input type="hidden" name="messageId" value="<?= htmlspecialchars($message["messageId"]) ?>">
                                        <button type="submit" class="supprimer-message" name="action" value="supprimerMessage">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="message-messagerie-vide">Vous n’avez aucun message.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<div id="modaleRedactionMessage" class="modale-cachee">
    <section class="fenetre-redaction-message">
        <h2 class="titre-modale">Nouveau message</h2>
        <div class="formulaire-champ">
            <label for="titreInput" class="titre-label">Titre : </label>
            <input form="formulaireEnvoiMessage" type="text" class="titre-input" id="titreInput" placeholder="Intitulé du message" name="titreMessage" aria-describedby="titreInputErreur" required>
            <p id="titreInputErreur" class="message-champ"></p>
        </div>
        <div class="formulaire-champ">
            <label for="contenuInput" class="contenu-label">Texte : </label>
            <textarea form="formulaireEnvoiMessage" class="contenu-input" id="contenuInput" placeholder="Votre message... "  name="contenuMessage" rows="10" maxlength="2500" aria-describedby="contenuInputErreur"></textarea>
            <p id="contenuInputErreur" class="message-champ"></p>
        </div>
        <div class="modale-redaction-navigation">
            <button type="submit" form="formulaireEnvoiMessage" class="envoyer-message" name="action" value="envoyerMessage">Envoyer</button>
            <button type="button" id="fermerRedactionMessage" class="retour-redaction-message">Annuler</button>
        </div>
    </section>
</div>

<div id="modaleLectureMessage" class="modale-cachee">
    <section class="fenetre-lecture-message">
        <h2 class="lecture-titre-message" id="lectureTitre"></h2>
        <br>
        <h3 class="lecture-expediteur-message" id="lectureExpediteur"></h3>
        <br><hr><br>
        <div class="lecture-contenu-message" id="lectureContenu"></div>
        <br><hr><br>
        <p class="lecture-date-message" id="lectureDate"></p>
        <br>
        <button type="button" id="fermerLectureMessage" class="retour-lecture-message">Fermer</button>
    </section>
</div>