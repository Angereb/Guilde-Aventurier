<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class RequisCaracteristiqueCompetenceModele extends ModeleLiaison {
    protected string $table = "requis_caracteristiques_competences";
    protected string $premiereColonne = "caracteristiqueId";
    protected string $secondeColonne = "competenceId";
    protected ?string $colonneValeur = "valeur";

    public function ajouter(int $caracteristiqueId, int $competenceId, int $valeur): void {
        if (!$this->valeurExisteDeja("caracteristiques", "caracteristiqueId", $caracteristiqueId)){
            throw new Exception("La caractéristique sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("competences", "competenceId", $competenceId)){
            throw new Exception("La compétence sélectionnée n'existe pas.");
        }
        if ($this->lienExisteDeja($caracteristiqueId, $competenceId)){
            throw new Exception("Cette caractéristique est déjà associée à cette compétence.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de caractéristique requise pour une compétence ne peut être inférieure à 1.");
        }
        parent::ajouterLiaison($caracteristiqueId, $competenceId, $valeur);
    }

    public function rechercherParCaracteristique(int $caracteristiqueId): array {
        return parent::rechercherLiaison(1, $caracteristiqueId);
    }

    public function rechercherParCompetence(int $competenceId): array {
        return parent::rechercherLiaison(2, $competenceId);
    }

    public function modifierValeur(int $caracteristiqueId, int $competenceId, int $valeur): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $competenceId)){
            throw new Exception("Cette caractéristique n'est pas associée à cette compétence.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de caractéristique requise pour une compétence ne peut être inférieure à 1.");
        }
        parent::modifierValeurLiaison($caracteristiqueId, $competenceId, $valeur);
    }

    public function supprimer(int $caracteristiqueId, int $competenceId): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $competenceId)){
            throw new Exception("Cette caractéristique n'est pas associée à cette compétence.");
        }
        parent::supprimerLiaison($caracteristiqueId, $competenceId);
    }
}
?>