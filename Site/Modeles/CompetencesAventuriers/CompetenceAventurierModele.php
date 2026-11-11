<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class CompetenceAventurierModele extends ModeleLiaison {
    protected string $table = "competences_aventuriers";
    protected string $premiereColonne = "competenceId";
    protected string $secondeColonne = "aventurierId";
    protected ?string $colonneValeur = null;

    public function ajouter(int $competenceId, int $aventurierId): void {
        if (!$this->valeurExisteDeja("competences", "competenceId", $competenceId)){
            throw new Exception("La compétence sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("aventuriers", "aventurierId", $aventurierId)){
            throw new Exception("L'aventurier sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($competenceId, $aventurierId)){
            throw new Exception("Cette compétence est déjà associée à cet aventurier.");
        }
        parent::ajouterLiaison($competenceId, $aventurierId);
    }

    public function rechercherParCompetence(int $competenceId): array {
        return parent::rechercherLiaison(1, $competenceId);
    }

    public function rechercherParAventurier(int $aventurierId): array {
        return parent::rechercherLiaison(2, $aventurierId);
    }

    public function supprimer(int $competenceId, int $aventurierId): void {
        if (!$this->lienExisteDeja($competenceId, $aventurierId)){
            throw new Exception("Cette compétence n'est pas associée à cet aventurier.");
        }
        parent::supprimerLiaison($competenceId, $aventurierId);
    }

    public function supprimerParAventurier(int $aventurierId): void {
        parent::supprimerLiaisonsParSecondId($aventurierId);
    }
}
?>