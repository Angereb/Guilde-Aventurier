<?php 
require_once __DIR__ . "/../BaseDeDonneesNoSQL.php";
require_once __DIR__ . "/Message.php";
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

class MessageModele {
    private static function collection(): \MongoDB\Collection {
        return BaseDeDonneesNoSQL::connexion()->selectCollection("messages");
    }

    private function creerMessageDepuisDonnees(\MongoDB\Model\BSONDocument $donnees) : Message {
        $message = new Message(
            (string)$donnees["_id"],
            $donnees["expediteurId"],
            $donnees["destinataireId"],
            $donnees["titre"],
            $donnees["contenu"],
            $donnees["envoyeLe"]->toDateTime(),
            $donnees["lu"]
        );
        return $message;
    }

    public function envoyer(Message $message): void {
        self::collection()->insertOne([
            "expediteurId" => $message->getExpediteurId(),
            "destinataireId" => $message->getDestinataireId(),
            "titre" => $message->getTitre(),
            "contenu" => $message->getContenu(),
            "envoyeLe" => new UTCDateTime(),
            "lu" => false
        ]);
    }

    public function recuperer(int $utilisateurId, string $messageId): Message {
        try {
            $id = new ObjectId($messageId);
        } catch (Exception $e) {
            throw new Exception("Ce message est introuvable.");
        }
        $messageRecuperer = self::collection()->findOne([
            "_id" => $id,
            "destinataireId" => $utilisateurId
        ]);
        if ($messageRecuperer === null) {
            throw new Exception("Ce message est introuvable.");
        }
        $message = $this->creerMessageDepuisDonnees($messageRecuperer);
        return $message;
    }

    public function recupererTous(int $utilisateurId): array {
        $messages = self::collection()->find(
            ["destinataireId" => $utilisateurId],
            ["sort" => ["envoyeLe" => -1]]
        );
        $messagesRecupere = [];
        foreach ($messages as $message) {
            $messagesRecupere[] = $this->creerMessageDepuisDonnees($message);
        }
        return $messagesRecupere;
    }

    public function modifierLu(int $utilisateurId, string $messageId, bool $lu): void {
        try {
            $id = new ObjectId($messageId);
        } catch (Exception $e) {
            throw new Exception("Ce message est introuvable.");
        }
        $resultat = self::collection()->updateOne(
            ["_id" => $id, "destinataireId" => $utilisateurId],
            ['$set' => ["lu" => $lu]]
        );
        if ($resultat->getMatchedCount() === 0) {
            throw new Exception("Ce message est introuvable.");
        }
    }

    public function supprimer(int $utilisateurId, string $messageId): void {
        try {
            $id = new ObjectId($messageId);
        } catch (Exception $e) {
            throw new Exception("Ce message est introuvable.");
        }
        $resultat = self::collection()->deleteOne(
            ["_id" => $id, "destinataireId" => $utilisateurId],
        );
        if ($resultat->getDeletedCount() === 0) {
            throw new Exception("Ce message est introuvable.");
        }
    }

    public function supprimerTous(int $utilisateurId): void {
        self::collection()->deleteMany(
            ["destinataireId" => $utilisateurId],
        );
    }
}
?>