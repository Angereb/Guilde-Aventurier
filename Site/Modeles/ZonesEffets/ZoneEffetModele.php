<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/ZoneEffet.php";

class ZoneEffetModele extends ModeleBase {
    private function creerZoneEffetDepuisDonnees(array $donnees): ZoneEffet {
        $zoneEffetId = (int)$donnees["zoneEffetId"];
        $directions = explode(",", $donnees["directions"]);
        $icone = null;
        if ($donnees["icone"] !== null) {
            $icone = $donnees["icone"];
        }
        $zoneEffet = new ZoneEffet(
            $zoneEffetId,
            $donnees["nom"],
            $directions,
            $donnees["portee"],
            $icone
        );
        return $zoneEffet;
    }

    public function ajouter(ZoneEffet $zoneEffet): void {
        if ($this->valeurExisteDeja("zones_effets", "nom", $zoneEffet->getNom())) {
            throw new Exception("Ce nom de zone d'effet existe déjà.");
        }
        $directions = implode(",", $zoneEffet->getDirections());
        $requete = $this->pdo->prepare("INSERT INTO zones_effets (nom, directions, portee, icone, typeIcone) VALUES (?, ?, ?, ?, ?)");
        $requete->execute([
            $zoneEffet->getNom(),
            $directions,
            $zoneEffet->getPortee(),
            $zoneEffet->getIcone(),
            $zoneEffet->getTypeIcone()
        ]);
    }

    public function rechercherParId(int $zoneEffetId): ZoneEffet {
        $requete = $this->pdo->prepare("SELECT * FROM zones_effets WHERE zoneEffetId = ?");
        $requete->execute([$zoneEffetId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false) {
            throw new Exception("Aucune zone d'effet trouvée avec l'identifiant $zoneEffetId.");
        }
        $zoneEffet = $this->creerZoneEffetDepuisDonnees($donnees);
        return $zoneEffet;
    }

    public function rechercherParNom(string $nom): ZoneEffet {
        $requete = $this->pdo->prepare("SELECT * FROM zones_effets WHERE nom = ?");
        $requete->execute([$nom]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false) {
            throw new Exception("Aucune zone d'effet trouvée avec le nom $nom.");
        }
        $zoneEffet = $this->creerZoneEffetDepuisDonnees($donnees);
        return $zoneEffet;
    }

    public function rechercherToutes(): array {
        $zonesEffets = [];
        $requete = $this->pdo->prepare("SELECT * FROM zones_effets ORDER BY nom ASC");
        $requete->execute();
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $zonesEffets[] = $this->creerZoneEffetDepuisDonnees($donnees);
        }
        return $zonesEffets;
    }

    public function modifier(ZoneEffet $zoneEffet): void {
        if ($zoneEffet->getZoneEffetId() === null) {
           throw new Exception("Impossible de modifier une zone d'effet inexistante.");
        }
        if ($this->valeurExisteDeja("zones_effets", "nom", $zoneEffet->getNom(), $zoneEffet->getZoneEffetId(), "zoneEffetId")) {
            throw new Exception("Ce nom de zone d'effet existe déjà.");
        }
        $this->rechercherParId($zoneEffet->getZoneEffetId());
        $directions = implode(",", $zoneEffet->getDirections());
        $requete = $this->pdo->prepare("UPDATE zones_effets SET nom = ?, directions = ?, portee = ?, icone = ?, typeIcone = ? WHERE zoneEffetId = ?");
        $requete->execute([
            $zoneEffet->getNom(),
            $directions,
            $zoneEffet->getPortee(),
            $zoneEffet->getIcone(),
            $zoneEffet->getTypeIcone(),
            $zoneEffet->getZoneEffetId()
        ]);
    }

    public function supprimer(int $zoneEffetId) : void {
        $this->rechercherParId($zoneEffetId);        
        $requeteVerification = $this->pdo->prepare("SELECT COUNT(*) FROM competences WHERE zoneEffetId = ?");
        $requeteVerification->execute([$zoneEffetId]);
        if ($requeteVerification->fetchColumn() > 0) {
            throw new Exception("Une compétence utilise encore cette zone d'effet.");
        }
        $requete = $this->pdo->prepare("DELETE FROM zones_effets WHERE zoneEffetId = ?");
        $requete->execute([$zoneEffetId]);
    }
}
?>