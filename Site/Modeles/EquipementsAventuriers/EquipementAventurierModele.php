<?php 
require_once __DIR__ . "/../ModeleBase.php";

class EquipementAventurierModele extends ModeleBase {
    private function lienExisteDeja(int $equipementId, int $aventurierId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM equipements_aventuriers WHERE equipementId = ? AND aventurierId = ?");
        $requete->execute([$equipementId, $aventurierId]);
        return $requete->fetchColumn() > 0;
    }

    public const ETATS_VALIDES = ["equipe", "inventaire"];
    
    public const LIBELLES_ETATS = [
        "equipe" => "Équipé",
        "inventaire" => "Inventaire"
    ];

    public function ajouter(int $equipementId, int $aventurierId, int $quantite, string $etat): void {
        if (!$this->valeurExisteDeja("equipements", "equipementId", $equipementId)){
            throw new Exception("L'équipement sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("aventuriers", "aventurierId", $aventurierId)){
            throw new Exception("L'aventurier sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($equipementId, $aventurierId)){
            throw new Exception("Cet équipement et cet aventurier sont déjà associés entre eux.");
        }
        if ($quantite < 1){
            throw new Exception("La quantité ne peut être inférieure à 1.");
        }
        if (!in_array($etat, self::ETATS_VALIDES, true)) {
            throw new Exception("L'état de l'équipement n'est pas valide.");
        }
        $requete = $this->pdo->prepare("INSERT INTO equipements_aventuriers (equipementId, aventurierId, quantite, etat) VALUES (?, ?, ?, ?)");
        $requete->execute([
            $equipementId,
            $aventurierId,
            $quantite,
            $etat
        ]);
    }

    public function rechercherParEquipement(int $equipementId): array {
        $resultats = [];
        $requete = $this->pdo->prepare("SELECT * FROM equipements_aventuriers WHERE equipementId = ?");
        $requete->execute([$equipementId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $resultats[] = ["equipementId" => (int)$donnees["equipementId"], "aventurierId" => (int)$donnees["aventurierId"], "quantite" => (int)$donnees["quantite"], "etat" => $donnees["etat"]];
        }
        return $resultats;
    }

    public function rechercherParAventurier(int $aventurierId): array {
        $resultats = [];
        $requete = $this->pdo->prepare("SELECT * FROM equipements_aventuriers WHERE aventurierId = ?");
        $requete->execute([$aventurierId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $resultats[] = ["equipementId" => (int)$donnees["equipementId"], "aventurierId" => (int)$donnees["aventurierId"], "quantite" => (int)$donnees["quantite"], "etat" => $donnees["etat"]];
        }
        return $resultats;
    }

    public function rechercherParEtat(string $etat): array {
        $resultats = [];
        $requete = $this->pdo->prepare("SELECT * FROM equipements_aventuriers WHERE etat = ?");
        $requete->execute([$etat]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $resultats[] = ["equipementId" => (int)$donnees["equipementId"], "aventurierId" => (int)$donnees["aventurierId"], "quantite" => (int)$donnees["quantite"], "etat" => $donnees["etat"]];
        }
        return $resultats;
    }

    public function modifier(int $equipementId, int $aventurierId, int $quantite, string $etat): void {
        if (!$this->valeurExisteDeja("equipements", "equipementId", $equipementId)){
            throw new Exception("L'équipement sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("aventuriers", "aventurierId", $aventurierId)){
            throw new Exception("L'aventurier sélectionné n'existe pas.");
        }
        if (!$this->lienExisteDeja($equipementId, $aventurierId)){
            throw new Exception("Cet équipement et cet aventurier ne sont pas associés entre eux.");
        }
        if ($quantite < 1){
            throw new Exception("La quantité ne peut être inférieure à 1.");
        }
        if (!in_array($etat, self::ETATS_VALIDES, true)) {
            throw new Exception("L'état de l'équipement n'est pas valide.");
        }
        $requete = $this->pdo->prepare("UPDATE equipements_aventuriers SET quantite = ?, etat = ? WHERE equipementId = ? AND aventurierId = ?");
        $requete->execute([
            $quantite,
            $etat,
            $equipementId,
            $aventurierId
        ]);
    }

    public function supprimer(int $equipementId, int $aventurierId): void {
        if (!$this->lienExisteDeja($equipementId, $aventurierId)){
            throw new Exception("Cet équipement et cet aventurier ne sont pas associés entre eux.");
        }
        $requete = $this->pdo->prepare("DELETE FROM equipements_aventuriers WHERE equipementId = ? AND aventurierId = ?");
        $requete->execute([
            $equipementId,
            $aventurierId
            ]);
    }
}
?>