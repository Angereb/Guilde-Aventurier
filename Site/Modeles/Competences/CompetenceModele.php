<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Competence.php";

class CompetenceModele extends ModeleBase {
    private function creerCompetenceDepuisDonnees(array $donnees): Competence {
        $competenceId = (int)$donnees["competenceId"];
        $coutPE = (int)$donnees["coutPE"];
        $zoneEffetId = null;
        if ($donnees["zoneEffetId"] !== null) {
            $zoneEffetId = (int)$donnees["zoneEffetId"];
        }
        $modifAttaque = null;
        if ($donnees["modifAttaque"] !== null) {
            $modifAttaque = (int)$donnees["modifAttaque"];
        }
        $modifDefense = null;
        if ($donnees["modifDefense"] !== null) {
            $modifDefense = (int)$donnees["modifDefense"];
        }
        $modifPV = null;
        if ($donnees["modifPV"] !== null) {
            $modifPV = (int)$donnees["modifPV"];
        }
        $modifPE = null;
        if ($donnees["modifPE"] !== null) {
            $modifPE = (int)$donnees["modifPE"];
        }
        $modifInitiative = null;
        if ($donnees["modifInitiative"] !== null) {
            $modifInitiative = (int)$donnees["modifInitiative"];
        }
        $modifMouvement = null;
        if ($donnees["modifMouvement"] !== null) {
            $modifMouvement = (int)$donnees["modifMouvement"];
        }
        
        $competence = new Competence(
            $competenceId,
            $donnees["nom"],
            $donnees["descriptions"],
            $donnees["types"],
            $coutPE,
            $zoneEffetId,
            $modifAttaque,
            $modifDefense,
            $modifPV,
            $modifPE,
            $modifInitiative,
            $modifMouvement
        );
        return $competence;
    }

    public function ajouter(Competence $competence): void {
        if ($this->valeurExisteDeja("competences", "nom", $competence->getNom())) {
            throw new Exception("Ce nom de compétence existe déjà.");
        }
        if ($competence->getTypes() === "active" && !$this->valeurExisteDeja("zones_effets", "zoneEffetId", $competence->getZoneEffetId())) {
            throw new Exception("Une compétence active doit être liée à une zone d'effet existante.");
        }
        $requete = $this->pdo->prepare("INSERT INTO competences (nom, descriptions, types, coutPE, modifAttaque, modifDefense, modifPV, modifPE, modifInitiative, modifMouvement, zoneEffetId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute([
            $competence->getNom(),
            $competence->getDescriptions(),
            $competence->getTypes(),
            $competence->getCoutPE(),
            $competence->getModifAttaque(),
            $competence->getModifDefense(),
            $competence->getModifPV(),
            $competence->getModifPE(),
            $competence->getModifInitiative(),
            $competence->getModifMouvement(),
            $competence->getZoneEffetId()
            ]);
    }

    public function rechercherParId(int $competenceId): Competence {
        $requete = $this->pdo->prepare("SELECT * FROM competences WHERE competenceId = ?");
        $requete->execute([$competenceId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune compétence trouvée avec l'identifiant $competenceId.");
        }
        $competence = $this->creerCompetenceDepuisDonnees($donnees);
        return $competence;
    }

    public function rechercherParNom(string $nom): Competence {
        $requete = $this->pdo->prepare("SELECT * FROM competences WHERE nom = ?");
        $requete->execute([$nom]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucune compétence trouvée avec le nom $nom.");
        }
        $competence = $this->creerCompetenceDepuisDonnees($donnees);
        return $competence;
    }

    public function rechercherParType(string $type): array {
        $competences = [];
        if (!in_array($type, Competence::TYPES_VALIDES, true)) {
            throw new Exception("Le type recherché n'est pas valide.");
        }
        $requete = $this->pdo->prepare("SELECT * FROM competences WHERE types = ?");
        $requete->execute([$type]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $competences[] = $this->creerCompetenceDepuisDonnees($donnees);
        }
        return $competences;
    }

    public function modifier(Competence $competence): void {
        if ($competence->getCompetenceId() === null) {
            throw new Exception("Impossible de modifier une compétence inexistante.");
        }
        if ($this->valeurExisteDeja("competences", "nom", $competence->getNom(), $competence->getCompetenceId(), "competenceId")) {
            throw new Exception("Ce nom de compétence existe déjà.");
        }
        if ($competence->getTypes() === "active" && !$this->valeurExisteDeja("zones_effets", "zoneEffetId", $competence->getZoneEffetId())) {
            throw new Exception("Une compétence active doit être liée à une zone d'effet existante.");
        }
        $this->rechercherParId($competence->getCompetenceId());
        $requete = $this->pdo->prepare("UPDATE competences SET nom = ?, descriptions = ?, types = ?, coutPE = ?, modifAttaque = ?, modifDefense = ?, modifPV = ?, modifPE = ?, modifInitiative = ?, modifMouvement = ?, zoneEffetId = ? WHERE competenceId = ?");
        $requete->execute([
            $competence->getNom(),
            $competence->getDescriptions(),
            $competence->getTypes(),
            $competence->getCoutPE(),
            $competence->getModifAttaque(),
            $competence->getModifDefense(),
            $competence->getModifPV(),
            $competence->getModifPE(),
            $competence->getModifInitiative(),
            $competence->getModifMouvement(),
            $competence->getZoneEffetId(),
            $competence->getCompetenceId()
        ]);
    }

    public function supprimer(int $competenceId): void {
        $this->rechercherParId($competenceId);
        $requete = $this->pdo->prepare("DELETE FROM competences WHERE competenceId= ?");
        $requete->execute([$competenceId]);
    }
}
?>