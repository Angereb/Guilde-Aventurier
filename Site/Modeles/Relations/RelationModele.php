<?php 
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Relation.php";

class RelationUtilisateurModele extends ModeleBase {
    private function lienExisteDeja(int $utilisateurId, int $contactId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
        $requete->execute([$utilisateurId, $contactId]);
        return $requete->fetchColumn() > 0;
    }

    private function creerRelationDepuisDonnees(array $donnees): RelationUtilisateur {
        $utilisateurId = (int)$donnees["utilisateurId"];
        $contactId = (int)$donnees["contactId"];
        $creerLe = new DateTime($donnees["creerLe"]);
        $relation = new RelationUtilisateur(
            $utilisateurId,
            $contactId,
            $creerLe,
            $donnees["statut"]
        );
        return $relation;
    }

    // La demande de relation crée une relation du contact vers l'utilisateur avec le statut en attente
    public function envoyerDemande(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($relation->getUtilisateurId(), $relation->getContactId())){
            throw new Exception("Ces deux utilisateurs sont déjà associés entre eux.");
        }
        if ($this->lienExisteDeja($relation->getContactId(), $relation->getUtilisateurId())){
            throw new Exception("Ces deux utilisateurs sont déjà associés entre eux.");
        }
        $requeteContact = $this->pdo->prepare("INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut) VALUES (?, ?, ?)");
        $requeteContact->execute([
            $relation->getContactId(),
            $relation->getUtilisateurId(),
            "en_attente"
        ]);
    }

    public function voirRelation(int $utilisateurId): array {
        $relations = [];
        $requete = $this->pdo->prepare("SELECT * FROM relations_utilisateurs WHERE utilisateurId = ? ORDER BY statut");
        $requete->execute([$utilisateurId]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $relations[] = $this->creerRelationDepuisDonnees($donnees);
        }
        return $relations;
    }

    public function accepter(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($relation->getContactId(), $relation->getUtilisateurId())){
            throw new Exception("Le contact est déjà associé avec l'utilisateur.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $demande = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $demande = $relationTrouvee;
                break;
            }
        }
        if ($demande === null) {
            throw new Exception("Aucune demande de ce contact n'a été trouvée.");
        }
        if ($demande->getStatut() !== "en_attente") {
            throw new Exception("Cette relation n'est pas une demande en attente.");
        }
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare("UPDATE relations_utilisateurs SET statut = ? WHERE utilisateurId = ? AND contactId = ?");
            $requeteUtilisateur->execute([
                "ami",
                $relation->getUtilisateurId(),
                $relation->getContactId(),
            ]);
            $requeteContact = $this->pdo->prepare("INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut) VALUES (?, ?, ?)");
            $requeteContact->execute([
                $relation->getContactId(),
                $relation->getUtilisateurId(),
                "ami"
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Une erreur lors de la création de la relation utilisateur est arrivée : " . $e->getMessage());
        }
    }

    public function refuser(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        if ($this->lienExisteDeja($relation->getContactId(), $relation->getUtilisateurId())){
            throw new Exception("Le contact est déjà associé avec l'utilisateur.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $demande = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $demande = $relationTrouvee;
                break;
            }
        }
        if ($demande === null) {
            throw new Exception("Aucune demande de ce contact n'a été trouvée.");
        }
        if ($demande->getStatut() !== "en_attente") {
            throw new Exception("Cette relation n'est pas une demande en attente.");
        }
        $requete = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
        $requete->execute([
            $relation->getUtilisateurId(),
            $relation->getContactId()
        ]);
    }

    public function modifierEtiquette(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        if (!in_array($relation->getStatut(), ["ami", "rival"], true)) {
            throw new Exception("Le statut sélectionné n'est pas valide.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $demande = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $demande = $relationTrouvee;
                break;
            }
        }
        if ($demande === null) {
            throw new Exception("Vous ne pouvez modifier le statut d'une relation inexistante.");
        }
        if (!in_array($demande->getStatut(), ["ami", "rival"], true)) {
            throw new Exception("Cette relation ne peut être changé ainsi.");
        }
        $requeteUtilisateur = $this->pdo->prepare("UPDATE relations_utilisateurs SET statut = ? WHERE utilisateurId = ? AND contactId = ?");
        $requeteUtilisateur->execute([
            $relation->getStatut(),
            $relation->getUtilisateurId(),
            $relation->getContactId(),
        ]);
    }

    public function retirer(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $demande = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $demande = $relationTrouvee;
                break;
            }
        }
        if ($demande === null) {
            throw new Exception("Vous ne pouvez supprimer une relation inexistante.");
        }
        if (!in_array($demande->getStatut(), ["ami", "rival"], true)) {
            throw new Exception("Cette relation ne peut pas être supprimée.");
        }
        $this->pdo->beginTransaction();
        try {
            $requeteUtilisateur = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
            $requeteUtilisateur->execute([
                $relation->getUtilisateurId(),
                $relation->getContactId(),
            ]);
            $requeteContact = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
            $requeteContact->execute([
                $relation->getContactId(),
                $relation->getUtilisateurId(),
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Une erreur lors de la suppression de la relation utilisateur est arrivée : " . $e->getMessage());
        }
    }

    public function bloquer(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $existe = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $existe = $relationTrouvee;
                break;
            }
        }
        if ($existe !== null && $existe->getStatut() === "bloque") {
            throw new Exception("Ce contact est déjà bloqué.");
        }
        $this->pdo->beginTransaction();
        try {
            $relationsContact = $this->voirRelation($relation->getContactId());
            $existeInverse = null;
            foreach ($relationsContact as $relationContactTrouvee) {
                if ($relationContactTrouvee->getContactId() === $relation->getUtilisateurId()) {
                    $existeInverse = $relationContactTrouvee;
                    break;
                }
            }
            if ($existeInverse !== null && $existeInverse->getStatut() !== "bloque") {
                $requeteContact = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
                $requeteContact->execute([
                    $relation->getContactId(),
                    $relation->getUtilisateurId()
                ]);
            }
            if ($existe !== null) {
                $requeteUtilisateur = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
                $requeteUtilisateur->execute([
                    $relation->getUtilisateurId(),
                    $relation->getContactId()
                ]);
            }
            $requete = $this->pdo->prepare("INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut) VALUES (?, ?, ?)");
            $requete->execute([
                $relation->getUtilisateurId(),
                $relation->getContactId(),
                "bloque"
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Une erreur lors du blocage du contact est arrivée : " . $e->getMessage());
        }
    }

    public function debloquer(RelationUtilisateur $relation): void {
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getUtilisateurId())){
            throw new Exception("L'utilisateur sélectionné n'existe pas.");
        }
        if (!$this->valeurExisteDeja("utilisateurs", "utilisateurId", $relation->getContactId())){
            throw new Exception("Le contact sélectionné n'existe pas.");
        }
        $relations = $this->voirRelation($relation->getUtilisateurId());
        $existe = null;
        foreach ($relations as $relationTrouvee) {
            if ($relationTrouvee->getContactId() === $relation->getContactId()) {
                $existe = $relationTrouvee;
                break;
            }
        }
        if ($existe === null) {
            throw new Exception("Vous ne pouvez débloquer une relation inexistante.");
        }
        if (!in_array($existe->getStatut(), ["bloque"], true)) {
            throw new Exception("Cette relation n'est pas bloquée.");
        }
        $requete = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ? AND contactId = ?");
        $requete->execute([
            $relation->getUtilisateurId(),
            $relation->getContactId()
        ]);
    }
}
?>