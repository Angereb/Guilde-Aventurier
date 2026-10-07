<?php 
class RelationUtilisateur {
    private int $utilisateurId;
    private int $contactId;
    private ?DateTime $creerLe;
    private string $statut;

    public const STATUTS_VALIDES = ["ami", "rival", "bloque", "en_attente"];

    public function __construct(int $utilisateurId, int $contactId, ?DateTime $creerLe, string $statut) {
        $this->setRelation($utilisateurId, $contactId);
        $this->creerLe = $creerLe;
        $this->setStatut($statut);
    }

    public function getUtilisateurId(): int {
        return $this->utilisateurId;
    }

    public function getContactId(): int {
        return $this->contactId;
    }

    public function setRelation(int $utilisateurId, int $contactId): void {
        if ($utilisateurId < 1) {
            throw new Exception("La relation doit être liée à un utilisateur valide.");
        }
        if ($contactId < 1) {
            throw new Exception("La relation doit être liée à un contact valide.");
        }
        if ($utilisateurId === $contactId) {
            throw new Exception("La relation doit se faire entre deux utilisateurs différents.");
        }
        $this->utilisateurId = $utilisateurId;
        $this->contactId = $contactId;
    }

    public function getCreerLe(): ?DateTime {
        return $this->creerLe;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function setStatut(string $statut): void {
        $statut = trim($statut);
        if ($statut === "") {
            throw new Exception("Le statut de la relation ne peut être vide.");
        }
        if (mb_strlen($statut) > 32) {
            throw new Exception("Le statut de la relation ne peut dépasser 32 caractères.");
        }
        if (!in_array($statut, self::STATUTS_VALIDES, true)) {
            throw new Exception("Le statut de la relation n'est pas valide.");
        }
        $this->statut = $statut;
    }
    
}
?>