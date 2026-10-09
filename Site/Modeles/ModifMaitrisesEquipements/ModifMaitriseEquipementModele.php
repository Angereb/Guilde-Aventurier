<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class ModifMaitriseEquipementModele extends ModeleLiaison {
    protected string $table = "modif_maitrises_equipements";
    protected string $premiereColonne = "maitriseId";
    protected string $secondeColonne = "equipementId";
    protected ?string $colonneValeur = "valeur";

    public function ajouter(int $maitriseId, int $equipementId, int $valeur): void {
        if (!$this->valeurExisteDeja("maitrises", "maitriseId", $maitriseId)){
            throw new Exception("La maîtrise sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("equipements", "equipementId", $equipementId)){
            throw new Exception("L'équipement sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($maitriseId, $equipementId)){
            throw new Exception("Cette maîtrise est déjà associée à cet équipement.");
        }
        if ($valeur === 0){
            throw new Exception("La valeur du modificateur de maîtrise pour un équipement ne peut être égale à 0.");
        }
        parent::ajouterLiaison($maitriseId, $equipementId, $valeur);
    }

    public function rechercherParMaitrise(int $maitriseId): array {
        return parent::rechercherLiaison(1, $maitriseId);
    }

    public function rechercherParEquipement(int $equipementId): array {
        return parent::rechercherLiaison(2, $equipementId);
    }

    public function modifierValeur(int $maitriseId, int $equipementId, int $valeur): void {
        if (!$this->lienExisteDeja($maitriseId, $equipementId)){
            throw new Exception("Cette maîtrise n'est pas associée à cet équipement.");
        }
        if ($valeur === 0){
            throw new Exception("La valeur du modificateur de maîtrise pour un équipement ne peut être égale à 0.");
        }
        parent::modifierValeurLiaison($maitriseId, $equipementId, $valeur);
    }

    public function supprimer(int $maitriseId, int $equipementId): void {
        if (!$this->lienExisteDeja($maitriseId, $equipementId)){
            throw new Exception("Cette maîtrise n'est pas associée à cet équipement.");
        }
        parent::supprimerLiaison($maitriseId, $equipementId);
    }
}
?>