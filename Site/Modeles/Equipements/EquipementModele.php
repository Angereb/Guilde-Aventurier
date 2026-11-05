<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Equipement.php";

class EquipementModele extends ModeleBase {
    private function creerEquipementDepuisDonnees(array $donnees): Equipement {
        $equipementId = (int)$donnees["equipementId"];
        $coutPC = (int)$donnees["coutPC"];
        $modifAttaque = null;
        if ($donnees["modifAttaque"] !== null) {
            $modifAttaque = (int)$donnees["modifAttaque"];
        }
        $modifDefense = null;
        if ($donnees["modifDefense"] !== null) {
            $modifDefense = (int)$donnees["modifDefense"];
        }
        $modifPV = null;
        if ($donnees["modifPV"] !== null) {
            $modifPV = (int)$donnees["modifPV"];
        }
        $modifPE = null;
        if ($donnees["modifPE"] !== null) {
            $modifPE = (int)$donnees["modifPE"];
        }
        $modifInitiative = null;
        if ($donnees["modifInitiative"] !== null) {
            $modifInitiative = (int)$donnees["modifInitiative"];
        }
        $modifMouvement = null;
        if ($donnees["modifMouvement"] !== null) {
            $modifMouvement = (int)$donnees["modifMouvement"];
        }
        
        $equipement = new Equipement(
            $equipementId,
            $donnees["nom"],
            $donnees["categorie"],
            $donnees["descriptions"],
            $coutPC,
            $modifAttaque,
            $modifDefense,
            $modifPV,
            $modifPE,
            $modifInitiative,
            $modifMouvement
        );
        return $equipement;
    }

    public function ajouter(Equipement $equipement): int {
        if ($this->valeurExisteDeja("equipements", "nom", $equipement->getNom())) {
            throw new Exception("Ce nom d'équipement existe déjà.");
        }
        $requete = $this->pdo->prepare("INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifAttaque, modifDefense, modifPV, modifPE, modifInitiative, modifMouvement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute([
            $equipement->getNom(),
            $equipement->getCategorie(),
            $equipement->getDescriptions(),
            $equipement->getCoutPC(),
            $equipement->getModifAttaque(),
            $equipement->getModifDefense(),
            $equipement->getModifPV(),
            $equipement->getModifPE(),
            $equipement->getModifInitiative(),
            $equipement->getModifMouvement()
            ]);
        return (int) $this->pdo->lastInsertId(); 
    }

    public function rechercherParId(int $equipementId): Equipement {
        $requete = $this->pdo->prepare("SELECT * FROM equipements WHERE equipementId = ?");
        $requete->execute([$equipementId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun équipement trouvé avec l'identifiant $equipementId.");
        }
        $equipement = $this->creerEquipementDepuisDonnees($donnees);
        return $equipement;
    }

    public function rechercherParNom(string $nom): Equipement {
        $requete = $this->pdo->prepare("SELECT * FROM equipements WHERE nom = ?");
        $requete->execute([$nom]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun équipement trouvé avec le nom $nom.");
        }
        $equipement = $this->creerEquipementDepuisDonnees($donnees);
        return $equipement;
    }

    public function rechercherParCategorie(string $categorie): array {
        $equipements = [];
        if (!in_array($categorie, Equipement::CATEGORIES_VALIDES, true)) {
            throw new Exception("La catégorie recherchée n'est pas valide.");
        }
        $requete = $this->pdo->prepare("SELECT * FROM equipements WHERE categorie = ? ORDER BY nom ASC");
        $requete->execute([$categorie]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $equipements[] = $this->creerEquipementDepuisDonnees($donnees);
        }
        return $equipements;
    }

    public function rechercherTous(): array {
        $equipements = [];
        $requete = $this->pdo->prepare("SELECT * FROM equipements ORDER BY nom ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $equipements[] = $this->creerEquipementDepuisDonnees($donnees);
        }
        return $equipements;
    }

    public function modifier(Equipement $equipement): void {
        if ($equipement->getEquipementId() === null) {
            throw new Exception("Impossible de modifier un équipement inexistant.");
        }
        if ($this->valeurExisteDeja("equipements", "nom", $equipement->getNom(), $equipement->getEquipementId(), "equipementId")) {
            throw new Exception("Ce nom d'équipement existe déjà.");
        }
        $this->rechercherParId($equipement->getEquipementId());
        $requete = $this->pdo->prepare("UPDATE equipements SET nom = ?, categorie = ?, descriptions = ?, coutPC = ?, modifAttaque = ?, modifDefense = ?, modifPV = ?, modifPE = ?, modifInitiative = ?, modifMouvement = ? WHERE equipementId = ?");
        $requete->execute([
            $equipement->getNom(),
            $equipement->getCategorie(),
            $equipement->getDescriptions(),
            $equipement->getCoutPC(),
            $equipement->getModifAttaque(),
            $equipement->getModifDefense(),
            $equipement->getModifPV(),
            $equipement->getModifPE(),
            $equipement->getModifInitiative(),
            $equipement->getModifMouvement(),
            $equipement->getEquipementId()
        ]);
    }

    public function supprimer(int $equipementId): void {
        $this->rechercherParId($equipementId);
        $requete = $this->pdo->prepare("DELETE FROM equipements WHERE equipementId= ?");
        $requete->execute([$equipementId]);
    }
}
?>