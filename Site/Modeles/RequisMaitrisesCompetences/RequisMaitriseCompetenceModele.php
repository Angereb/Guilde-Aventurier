<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class RequisMaitriseCompetenceModele extends ModeleLiaison {
    protected string $table = "requis_maitrises_competences";
    protected string $premiereColonne = "maitriseId";
    protected string $secondeColonne = "competenceId";
    protected ?string $colonneValeur = "valeur";

    public function ajouter(int $maitriseId, int $competenceId, int $valeur): void {
        if (!$this->valeurExisteDeja("maitrises", "maitriseId", $maitriseId)){
            throw new Exception("La maîtrise sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("competences", "competenceId", $competenceId)){
            throw new Exception("La compétence sélectionnée n'existe pas.");
        }
        if ($this->lienExisteDeja($maitriseId, $competenceId)){
            throw new Exception("Cette maîtrise est déjà associée à cette compétence.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de maîtrise requise pour une compétence ne peut être inférieure à 1.");
        }
        parent::ajouterLiaison($maitriseId, $competenceId, $valeur);
    }

    public function rechercherParMaitrise(int $maitriseId): array {
        return parent::rechercherLiaison(1, $maitriseId);
    }

    public function rechercherParCompetence(int $competenceId): array {
        return parent::rechercherLiaison(2, $competenceId);
    }

    public function modifierValeur(int $maitriseId, int $competenceId, int $valeur): void {
        if (!$this->lienExisteDeja($maitriseId, $competenceId)){
            throw new Exception("Cette maîtrise n'est pas associée à cette compétence.");
        }
        if ($valeur < 1){
            throw new Exception("La valeur de maîtrise requise pour une compétence ne peut être inférieure à 1.");
        }
        parent::modifierValeurLiaison($maitriseId, $competenceId, $valeur);
    }

    public function supprimer(int $maitriseId, int $competenceId): void {
        if (!$this->lienExisteDeja($maitriseId, $competenceId)){
            throw new Exception("Cette maîtrise n'est pas associée à cette compétence.");
        }
        parent::supprimerLiaison($maitriseId, $competenceId);
    }

    public function supprimerParCompetence(int $competenceId): void {
        parent::supprimerLiaisonsParSecondId($competenceId);
    }
}
?>