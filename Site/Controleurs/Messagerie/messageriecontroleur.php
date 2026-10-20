<?php 
require_once __DIR__ . "/../../Modeles/Messagerie/MessageModele.php";
require_once __DIR__ . "/../../Modeles/Relations/RelationModele.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Messagerie";

$css = ["Messagerie/messagerie.css"];

$javascript = ["Messagerie/messagerie.js"];

$messageModele = new MessageModele;
$relationModele = new RelationUtilisateurModele;
$utilisateurModele = new UtilisateurModele;

$listeContacts = $relationModele->voirRelation($_SESSION["utilisateur"]["id"]);
$contactsRapide = [];
foreach ($listeContacts as $contact) {
    if (!in_array($contact->getStatut(), ["ami", "rival"], true)) {
        continue;
    }
    $utilisateur = $utilisateurModele->rechercherParId($contact->getContactId());
    $contactsRapide[] = [
        "pseudo" => $utilisateur->getPseudo(),
    ];
}

$messagesRecuperesBrut = $messageModele->recupererTous($_SESSION["utilisateur"]["id"]);
$messages = [];
foreach ($messagesRecuperesBrut as $messageRecupereBrut) {
    $expediteur = $utilisateurModele->rechercherParId($messageRecupereBrut->getExpediteurId());
    $messages[] = [
        "messageId" => $messageRecupereBrut->getMessageId(),
        "expediteur" => $expediteur->getPseudo(),
        "titre" => $messageRecupereBrut->getTitre(),
        "contenu" => $messageRecupereBrut->getContenu(),
        "envoyeLe" => $messageRecupereBrut->getEnvoyeLe()->setTimezone(new DateTimeZone("Europe/Paris"))->format("d/m/Y H:i"),
        "lu" => $messageRecupereBrut->getLu(),
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'envoyerMessage':
                $messageCreeExpediteurId = $_SESSION["utilisateur"]["id"];
                $messageCreeDestinataire = $_POST["destinataire"] ?? "";
                try {
                    $destinataireMessageTrouve = $utilisateurModele->rechercherParPseudo($messageCreeDestinataire);
                    if ($destinataireMessageTrouve->getActif() === false || $destinataireMessageTrouve->getEstSupprime() === true) {
                        throw new Exception("Aucun destinataire n'a été trouvé.");
                    }
                } catch (Exception $e) {
                    throw new Exception("Aucun joueur ne porte ce pseudo.");
                }
                $messageCreeDestinataireId = $destinataireMessageTrouve->getUtilisateurId();
                if ($messageCreeDestinataireId === $messageCreeExpediteurId) {
                    throw new Exception("Vous ne pouvez pas envoyer de message à vous-même.");
                }
                $messageCreeTitre = $_POST["titreMessage"] ?? "";
                $messageCreeContenu = $_POST["contenuMessage"] ?? "";
                $messageCree = new Message(
                    null,
                    $messageCreeExpediteurId,
                    $messageCreeDestinataireId,
                    $messageCreeTitre,
                    $messageCreeContenu,
                    null,
                    false
                );
                if ($relationModele->estBloque($messageCreeExpediteurId, $messageCreeDestinataireId)) {
                    throw new Exception("Vous ne pouvez pas envoyer de message à un joueur que vous avez bloqué.");
                }
                if (!$relationModele->estBloque($messageCreeDestinataireId, $messageCreeExpediteurId)){
                    $messageModele->envoyer($messageCree);
                }
                $_SESSION["notificationMessage"] = "Votre message a bien été envoyé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'supprimerMessage':
                $messageSupprimeId = $_POST["messageId"] ?? "";
                $messageModele->supprimer($_SESSION["utilisateur"]["id"], $messageSupprimeId);
                $_SESSION["notificationMessage"] = "Le message a bien été supprimé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'marquerLu':
                $messageModifieId = $_POST["messageId"] ?? "";
                $messageModele->modifierLu($_SESSION["utilisateur"]["id"], $messageModifieId, true);
                header("Content-Type: application/json");
                echo json_encode(["succes" => true]);
                exit;

            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=messages");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=messages");
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Messagerie/messagerie.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>