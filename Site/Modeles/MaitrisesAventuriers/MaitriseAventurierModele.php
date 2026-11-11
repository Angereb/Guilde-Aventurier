<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class MaitriseAventurierModele extends ModeleLiaison {
    protected string $table = "maitrises_aventuriers";
    protected string $premiereColonne = "maitriseId";
    protected string $secondeColonne = "aventurierId";
    protected ?string $colonneValeur = "niveau";

    public function ajouter(int $maitriseId, int $aventurierId, int $niveau): void {
        if (!$this->valeurExisteDeja("maitrises", "maitriseId", $maitriseId)){
            throw new Exception("La maîtrise sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("aventuriers", "aventurierId", $aventurierId)){
            throw new Exception("L'aventurier sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($maitriseId, $aventurierId)){
            throw new Exception("Cette maîtrise est déjà associée à cet aventurier.");
        }
        parent::ajouterLiaison($maitriseId, $aventurierId, $niveau);
    }

    public function rechercherParMaitrise(int $maitriseId): array {
        return parent::rechercherLiaison(1, $maitriseId);
    }

    public function rechercherParAventurier(int $aventurierId): array {
        return parent::rechercherLiaison(2, $aventurierId);
    }

    public function modifierNiveau(int $maitriseId, int $aventurierId, int $niveau): void {
        if (!$this->lienExisteDeja($maitriseId, $aventurierId)){
            throw new Exception("Cette maîtrise n'est pas associée à cet aventurier.");
        }
        parent::modifierValeurLiaison($maitriseId, $aventurierId, $niveau);
    }

    public function supprimer(int $maitriseId, int $aventurierId): void {
        if (!$this->lienExisteDeja($maitriseId, $aventurierId)){
            throw new Exception("Cette maîtrise n'est pas associée à cet aventurier.");
        }
        parent::supprimerLiaison($maitriseId, $aventurierId);
    }

    public function supprimerParAventurier(int $aventurierId): void {
        parent::supprimerLiaisonsParSecondId($aventurierId);
    }
}
?>