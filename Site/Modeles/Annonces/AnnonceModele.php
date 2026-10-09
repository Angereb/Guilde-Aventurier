<?php
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Annonce.php";

class AnnonceModele extends ModeleBase{
    private function creerAnnonceDepuisDonnees(array $donnees): Annonce {
        $annonceId = (int)$donnees["annonceId"];
        $publierLe = new DateTime($donnees["publierLe"]);
        $publierParId = (int)$donnees["publierParId"];
        $annonce= new Annonce(
            $annonceId,
            $donnees["titre"],
            $donnees["contenu"],
            $publierLe,
            $publierParId
        );
        return $annonce;
    }

    public function ajouter(Annonce $annonce): void {
        $requete = $this->pdo->prepare(
            "INSERT INTO annonces (titre, contenu, publierParId) VALUES (?, ?, ?)");
        $requete->execute([
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getPublierParId(),
        ]);
    }

    public function rechercherParId(int $annonceId): Annonce {
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE annonceId = ?");
        $requete->execute([$annonceId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune annonce trouvé avec l'identifiant $annonceId.");
        }
        $annonce = $this->creerAnnonceDepuisDonnees($donnees);
        return $annonce;
    }

    public function rechercherTousTitre(string $titre): array {
        $annonces = [];
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE titre = ?");
        $requete->execute([$titre]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $annonces[] = $this->creerAnnonceDepuisDonnees($donnees);
        }
        if (empty($annonces)){
            throw new Exception("Aucune annonce trouvée ayant pour titre : $titre.");
        }
        return $annonces;
    }

    public function rechercherParPublierParId(int $publierParId): array {
        $annonces = [];
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE publierParId = ?");
        $requete->execute([$publierParId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = $this->creerAnnonceDepuisDonnees($donnees);
        };
        if (empty($annonces)){
                throw new Exception("Aucune annonce trouvé dont le créateur répond à l'id $publierParId.");
            }
        return $annonces;
    }

    public function rechercherToutes(): array {
        $annonces = [];
        $requete = $this->pdo->prepare("SELECT * FROM annonces ORDER BY publierLe DESC LIMIT");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = $this->creerAnnonceDepuisDonnees($donnees);
        };
        return $annonces;
    }

    public function rechercherDernieres(int $nombre): array {
        $annonces = [];
        $requete = $this->pdo->prepare("SELECT * FROM annonces ORDER BY publierLe DESC LIMIT ?");
        // On lie $nombre en tant qu'entier : passé dans execute(), il serait envoyé comme du texte ('6'), et LIMIT refuse une valeur entre apostrophes.
        $requete->bindValue(1, $nombre, PDO::PARAM_INT);
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $annonces[] = $this->creerAnnonceDepuisDonnees($donnees);
        }
        return $annonces;
    }

    public function modifier(Annonce $annonce): void {
        if ($annonce->getAnnonceId() === null){
            throw new Exception("Impossible de modifier une annonce inexistante.");
        }
        $this->rechercherParId($annonce->getAnnonceId());
        $requete = $this->pdo->prepare("UPDATE annonces SET titre = ?, contenu = ? WHERE annonceId= ?");
        $requete->execute([
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getAnnonceId()
        ]);
    }

    public function supprimer(int $annonceId): void {
        $this->rechercherParId($annonceId);
        $requete = $this->pdo->prepare("DELETE FROM annonces WHERE annonceId= ?");
        $requete->execute([$annonceId]);
    }
}
?>