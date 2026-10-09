<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Maitrise.php";

class MaitriseModele extends ModeleBase {
    private function creerMaitriseDepuisDonnees(array $donnees): Maitrise {
        $maitriseId = (int)$donnees["maitriseId"];
        $maitrise = new Maitrise(
            $maitriseId,
            $donnees["nom"],
            $donnees["descriptions"]
        );
        return $maitrise;
    }

    public function ajouter(Maitrise $maitrise): void {
        if ($this->valeurExisteDeja("maitrises", "nom", $maitrise->getNom())) {
            throw new Exception("Ce nom de maîtrise existe déjà.");
        }
        $requete = $this->pdo->prepare("INSERT INTO maitrises (nom, descriptions) VALUES (?, ?)");
        $requete->execute([
            $maitrise->getNom(),
            $maitrise->getDescriptions()
            ]);
    }

    public function rechercherParId(int $maitriseId): Maitrise {
        $requete = $this->pdo->prepare("SELECT * FROM maitrises WHERE maitriseId = ?");
        $requete->execute([$maitriseId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune maîtrise trouvée avec l'identifiant $maitriseId.");
        }
        $maitrise = $this->creerMaitriseDepuisDonnees($donnees);
        return $maitrise;
    }

    public function rechercherParNom(string $nom): Maitrise {
        $requete = $this->pdo->prepare("SELECT * FROM maitrises WHERE nom = ?");
        $requete->execute([$nom]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune maîtrise trouvée avec le nom $nom.");
        }
        $maitrise = $this->creerMaitriseDepuisDonnees($donnees);
        return $maitrise;
    }

    public function modifier(Maitrise $maitrise): void {
        if ($maitrise->getMaitriseId() === null) {
            throw new Exception("Impossible de modifier une maîtrise inexistante.");
        }
        if ($this->valeurExisteDeja("maitrises", "nom", $maitrise->getNom(), $maitrise->getMaitriseId(), "maitriseId")) {
            throw new Exception("Ce nom de maîtrise existe déjà.");
        }
        $this->rechercherParId($maitrise->getMaitriseId());
        $requete = $this->pdo->prepare("UPDATE maitrises SET nom = ?, descriptions = ? WHERE maitriseId = ?");
        $requete->execute([
            $maitrise->getNom(),
            $maitrise->getDescriptions(),
            $maitrise->getMaitriseId()
        ]);
    }

    public function supprimer(int $maitriseId): void {
        $this->rechercherParId($maitriseId);
        $requete = $this->pdo->prepare("DELETE FROM maitrises WHERE maitriseId= ?");
        $requete->execute([$maitriseId]);
    }
}
?>