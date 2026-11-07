<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Aventurier.php";

class AventurierModele extends ModeleBase {
    private function creerAventurierDepuisDonnees(array $donnees): Aventurier {
        $aventurierId = (int)$donnees["aventurierId"];
        $icone = null;
        if ($donnees["icone"] !== null) {
            $icone = $donnees["icone"];
        }
        $creerLe = new DateTime($donnees["creerLe"]);
        $modifierLe = null;
        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }
        $creerParId = (int)$donnees["creerParId"];
        $aventurier = new Aventurier(
            $aventurierId,
            $donnees["nom"],
            $icone,
            $creerLe,
            $modifierLe,
            $creerParId
        );
        return $aventurier;
    }

    public function ajouter(Aventurier $aventurier): int {
        $requete = $this->pdo->prepare(
            "INSERT INTO aventuriers (nom, icone, typeIcone, creerParId) VALUES (?, ?, ?, ?)");
        $requete->execute([
            $aventurier->getNom(),
            $aventurier->getIcone(),
            $aventurier->getTypeIcone(),
            $aventurier->getCreerParId()
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function rechercherParId(int $aventurierId): Aventurier {
        $requete = $this->pdo->prepare("SELECT * FROM aventuriers WHERE aventurierId = ?");
        $requete->execute([$aventurierId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun aventurier trouvé avec l'identifiant $aventurierId.");
        }
        $aventurier = $this->creerAventurierDepuisDonnees($donnees);
        return $aventurier;
    }

    public function rechercherParCreerParId(int $creerParId): array {
        $aventuriers = [];
        $requete = $this->pdo->prepare("SELECT * FROM aventuriers WHERE creerParId = ?");
        $requete->execute([$creerParId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $aventuriers[] = $this->creerAventurierDepuisDonnees($donnees);
        }
        return $aventuriers;
    }

    public function modifier(Aventurier $aventurier): void {
        if ($aventurier->getAventurierId() === null){
            throw new Exception("Impossible de modifier un aventurier inexistant.");
        }
        $this->rechercherParId($aventurier->getAventurierId());
        $requete = $this->pdo->prepare("UPDATE aventuriers SET nom = ?, icone = ?, typeIcone = ?, modifierLe = NOW() WHERE aventurierId= ?");
        $requete->execute([
            $aventurier->getNom(),
            $aventurier->getIcone(),
            $aventurier->getTypeIcone(),
            $aventurier->getAventurierId()
        ]);
    }

    public function supprimer(int $aventurierId): void {
        $this->rechercherParId($aventurierId);
        $requete = $this->pdo->prepare("DELETE FROM aventuriers WHERE aventurierId= ?");
        $requete->execute([$aventurierId]);
    }
}
?>