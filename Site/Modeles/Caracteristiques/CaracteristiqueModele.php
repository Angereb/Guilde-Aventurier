<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Caracteristique.php";
require_once __DIR__ . "/../CaracteristiquesAventuriers/CaracteristiqueAventurierModele.php";
require_once __DIR__ . "/../RequisCaracteristiquesEquipements/RequisCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../ModifCaracteristiquesEquipements/ModifCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../RequisCaracteristiquesCompetences/RequisCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../ModifCaracteristiquesCompetences/ModifCaracteristiqueCompetenceModele.php";

class CaracteristiqueModele extends ModeleBase {
    private function creerCaracteristiqueDepuisDonnees(array $donnees): Caracteristique {
        $caracteristiqueId = (int)$donnees["caracteristiqueId"];
        $caracteristique = new Caracteristique(
            $caracteristiqueId,
            $donnees["nom"],
            $donnees["descriptions"]
        );
        return $caracteristique;
    }

    public function ajouter(Caracteristique $caracteristique): void {
        if ($this->valeurExisteDeja("caracteristiques", "nom", $caracteristique->getNom())) {
            throw new Exception("Ce nom de caractéristique existe déjà.");
        }
        $requete = $this->pdo->prepare("INSERT INTO caracteristiques (nom, descriptions) VALUES (?, ?)");
        $requete->execute([
            $caracteristique->getNom(),
            $caracteristique->getDescriptions()
            ]);
    }

    public function rechercherParId(int $caracteristiqueId): Caracteristique {
        $requete = $this->pdo->prepare("SELECT * FROM caracteristiques WHERE caracteristiqueId = ?");
        $requete->execute([$caracteristiqueId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune caractéristique trouvée avec l'identifiant $caracteristiqueId.");
        }
        $caracteristique = $this->creerCaracteristiqueDepuisDonnees($donnees);
        return $caracteristique;
    }

    public function rechercherParNom(string $nom): Caracteristique {
        $requete = $this->pdo->prepare("SELECT * FROM caracteristiques WHERE nom = ?");
        $requete->execute([$nom]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune caractéristique trouvée avec le nom $nom.");
        }
        $caracteristique = $this->creerCaracteristiqueDepuisDonnees($donnees);
        return $caracteristique;
    }

    public function modifier(Caracteristique $caracteristique): void {
        if ($caracteristique->getCaracteristiqueId() === null) {
            throw new Exception("Impossible de modifier une caractéristique inexistante.");
        }
        if ($this->valeurExisteDeja("caracteristiques", "nom", $caracteristique->getNom(), $caracteristique->getCaracteristiqueId(), "caracteristiqueId")) {
            throw new Exception("Ce nom de caractéristique existe déjà.");
        }
        $this->rechercherParId($caracteristique->getCaracteristiqueId());
        $requete = $this->pdo->prepare("UPDATE caracteristiques SET nom = ?, descriptions = ? WHERE caracteristiqueId = ?");
        $requete->execute([
            $caracteristique->getNom(),
            $caracteristique->getDescriptions(),
            $caracteristique->getCaracteristiqueId()
        ]);
    }

    public function supprimer(int $caracteristiqueId): void {
        $this->rechercherParId($caracteristiqueId);
        $modeleCaracteristiqueAventurier = new CaracteristiqueAventurierModele;
        $modeleRequisCaracteristiqueEquipement = new RequisCaracteristiqueEquipementModele;
        $modeleModifCaracteristiqueEquipement = new ModifCaracteristiqueEquipementModele;
        $modeleRequisCaracteristiqueCompetence = new RequisCaracteristiqueCompetenceModele;
        $modeleModifCaracteristiqueCompetence = new ModifCaracteristiqueCompetenceModele;
        if (!empty($modeleCaracteristiqueAventurier->rechercherParCaracteristique($caracteristiqueId)) 
            || !empty($modeleRequisCaracteristiqueEquipement->rechercherParCaracteristique($caracteristiqueId))
            || !empty($modeleModifCaracteristiqueEquipement->rechercherParCaracteristique($caracteristiqueId))
            || !empty($modeleRequisCaracteristiqueCompetence->rechercherParCaracteristique($caracteristiqueId)) 
            || !empty($modeleModifCaracteristiqueCompetence->rechercherParCaracteristique($caracteristiqueId))) {
            throw new Exception("Cette caractéristique est utilisée et ne peut pas être supprimée.");
        }
        $requete = $this->pdo->prepare("DELETE FROM caracteristiques WHERE caracteristiqueId= ?");
        $requete->execute([$caracteristiqueId]);
    }
}
?>