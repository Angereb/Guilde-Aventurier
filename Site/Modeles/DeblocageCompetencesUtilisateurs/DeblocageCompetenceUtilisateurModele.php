<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class DeblocageCompetenceUtilisateurModele extends ModeleLiaison {
    protected string $table = "deblocage_competences_utilisateurs";
    protected string $premiereColonne = "competenceId";
    protected string $secondeColonne = "utilisateurId";
    protected ?string $colonneValeur = null;

    public function ajouter(int $competenceId, int $utilisateurId): void {
        if (!$this->valeurExisteDeja("competences", "competenceId", $competenceId)){
            throw new Exception("La compétence sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $utilisateurId)){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($competenceId, $utilisateurId)){
            throw new Exception("Cette compétence est déjà associée à cet utilisateur.");
        }
        parent::ajouterLiaison($competenceId, $utilisateurId);
    }

    public function rechercherParCompetence(int $competenceId): array {
        return parent::rechercherLiaison(1, $competenceId);
    }

    public function rechercherParUtilisateur(int $utilisateurId): array {
        return parent::rechercherLiaison(2, $utilisateurId);
    }

    public function supprimer(int $competenceId, int $utilisateurId): void {
        if (!$this->lienExisteDeja($competenceId, $utilisateurId)){
            throw new Exception("Cette compétence n'est pas associée à cet utilisateur.");
        }
        parent::supprimerLiaison($competenceId, $utilisateurId);
    }
}
?>