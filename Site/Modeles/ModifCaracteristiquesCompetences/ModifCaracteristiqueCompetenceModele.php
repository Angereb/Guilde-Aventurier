<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class ModifCaracteristiqueCompetenceModele extends ModeleLiaison {
    protected string $table = "modif_caracteristiques_competences";
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
        if ($valeur === 0){
            throw new Exception("La valeur du modificateur de caractéristique pour une compétence ne peut être égale à 0.");
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
        if ($valeur === 0){
            throw new Exception("La valeur du modificateur de caractéristique pour une compétence ne peut être égale à 0.");
        }
        parent::modifierValeurLiaison($caracteristiqueId, $competenceId, $valeur);
    }

    public function supprimer(int $caracteristiqueId, int $competenceId): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $competenceId)){
            throw new Exception("Cette caractéristique n'est pas associée à cette compétence.");
        }
        parent::supprimerLiaison($caracteristiqueId, $competenceId);
    }

    public function supprimerParCompetence(int $competenceId): void {
        parent::supprimerLiaisonsParSecondId($competenceId);
    }
}
?>