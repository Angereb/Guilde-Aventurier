<?php 
require_once __DIR__ . "/../ModeleLiaison.php";

class CaracteristiqueAventurierModele extends ModeleLiaison {
    protected string $table = "caracteristiques_aventuriers";
    protected string $premiereColonne = "caracteristiqueId";
    protected string $secondeColonne = "aventurierId";
    protected ?string $colonneValeur = "niveau";

    public function ajouter(int $caracteristiqueId, int $aventurierId, int $niveau): void {
        if (!$this->valeurExisteDeja("caracteristiques", "caracteristiqueId", $caracteristiqueId)){
            throw new Exception("La caractéristique sélectionnée n'existe pas.");
        }
        if (!$this->valeurExisteDeja("aventuriers", "aventurierId", $aventurierId)){
            throw new Exception("L'aventurier sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($caracteristiqueId, $aventurierId)){
            throw new Exception("Cette caractéristique est déjà associée à cet aventurier.");
        }
        parent::ajouterLiaison($caracteristiqueId, $aventurierId, $niveau);
    }

    public function rechercherParCaracteristique(int $caracteristiqueId): array {
        return parent::rechercherLiaison(1, $caracteristiqueId);
    }

    public function rechercherParAventurier(int $aventurierId): array {
        return parent::rechercherLiaison(2, $aventurierId);
    }

    public function modifierNiveau(int $caracteristiqueId, int $aventurierId, int $niveau): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $aventurierId)){
            throw new Exception("Cette caractéristique n'est pas associée à cet aventurier.");
        }
        parent::modifierValeurLiaison($caracteristiqueId, $aventurierId, $niveau);
    }

    public function supprimer(int $caracteristiqueId, int $aventurierId): void {
        if (!$this->lienExisteDeja($caracteristiqueId, $aventurierId)){
            throw new Exception("Cette caractéristique n'est pas associée à cet aventurier.");
        }
        parent::supprimerLiaison($caracteristiqueId, $aventurierId);
    }

    public function supprimerParAventurier(int $aventurierId): void {
        parent::supprimerLiaisonsParSecondId($aventurierId);
    }
}
?>