<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class RequisCaracteristiqueEquipementModele extends ModeleLiaison {
    protected string $table = "requis_caracteristiques_equipements";
    protected string $premiereColonne = "caracteristiqueId";
    protected string $secondeColonne = "equipementId";
    protected ?string $colonneValeur = "valeur";

    public function ajouter(int $caracteristiqueId, int $equipementId, int $valeur): void {
        if (!$this->valeurExisteDeja("caracteristiques", "caracteristiqueId", $caracteristiqueId)){
            throw new Exception("La caractéristique sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("equipements", "equipementId", $equipementId)){
            throw new Exception("L'équipement sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($caracteristiqueId, $equipementId)){
            throw new Exception("Cette caractéristique est déjà associée à cet équipement.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de caractéristique requise pour un équipement ne peut être inférieure à 1.");
        }
        parent::ajouterLiaison($caracteristiqueId, $equipementId, $valeur);
    }

    public function rechercherParCaracteristique(int $caracteristiqueId): array {
        return parent::rechercherLiaison(1, $caracteristiqueId);
    }

    public function rechercherParEquipement(int $equipementId): array {
        return parent::rechercherLiaison(2, $equipementId);
    }

    public function modifierValeur(int $caracteristiqueId, int $equipementId, int $valeur): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $equipementId)){
            throw new Exception("Cette caractéristique n'est pas associée à cet équipement.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de caractéristique requise pour un équipement ne peut être inférieure à 1.");
        }
        parent::modifierValeurLiaison($caracteristiqueId, $equipementId, $valeur);
    }

    public function supprimer(int $caracteristiqueId, int $equipementId): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $equipementId)){
            throw new Exception("Cette caractéristique n'est pas associée à cet équipement.");
        }
        parent::supprimerLiaison($caracteristiqueId, $equipementId);
    }
}
?>