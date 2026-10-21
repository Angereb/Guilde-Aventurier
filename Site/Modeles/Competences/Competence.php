<?php 
class Competence {
    private ?int $competenceId;
    private string $nom;
    private string $descriptions;
    private string $types;
    private int $coutPE;
    private ?int $modifAttaque;
    private ?int $modifDefense;
    private ?int $modifPV;
    private ?int $modifPE;
    private ?int $modifInitiative;
    private ?int $modifMouvement;
    private ?int $zoneEffetId;

    public const TYPES_VALIDES = ["active", "passive"];

    public function __construct(?int $competenceId, string $nom, string $descriptions, string $types, int $coutPE, ?int $zoneEffetId, ?int $modifAttaque = null, ?int $modifDefense = null, ?int $modifPV = null, ?int $modifPE = null, ?int $modifInitiative = null, ?int $modifMouvement = null) {
        $this->competenceId = $competenceId;
        $this->setNom($nom);
        $this->setDescriptions($descriptions);
        $this->setTypesEtCoutEtZone($types, $coutPE, $zoneEffetId);
        $this->setModifAttaque($modifAttaque);
        $this->setModifDefense($modifDefense);
        $this->setModifPV($modifPV);
        $this->setModifPE($modifPE);
        $this->setModifInitiative($modifInitiative);
        $this->setModifMouvement($modifMouvement);
    }

    public function getCompetenceId(): ?int {
        return $this->competenceId;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de la compétence ne peut pas être vide.");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom de la compétence ne peut pas dépasser 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getDescriptions(): string {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): void {
        $descriptions = trim($descriptions);
        if ($descriptions === "") {
            throw new Exception("La description de la compétence ne peut être vide.");
        }
        if (mb_strlen($descriptions) > 2500) {
            throw new Exception("La description de la compétence ne peut excéder 2500 caractères.");
        }
        $this->descriptions = $descriptions;
    }

    public function getTypes(): string {
        return $this->types;
    }

    public function getCoutPE(): int {
        return $this->coutPE;
    }

    public function getZoneEffetId(): ?int {
        return $this->zoneEffetId;
    }

    public function setTypesEtCoutEtZone(string $types, int $coutPE, ?int $zoneEffetId): void {
        $types = trim($types);
        if ($types === "") {
            throw new Exception("Le type de la compétence ne peut être vide.");
        }
        if (mb_strlen($types) > 32) {
            throw new Exception("Le type de la compétence ne peut dépasser 32 caractères.");
        }
        if (!in_array($types, self::TYPES_VALIDES, true)) {
            throw new Exception("Le type de la compétence n'est pas valide.");
        }
        if ($types === "active" && $coutPE < 1) {
            throw new Exception("Le coût en points d'endurance d'une compétence active ne peut être inférieur à 1.");
        }
        if ($types === "active" && ($zoneEffetId === null || $zoneEffetId < 1)) {
            throw new Exception("Une compétence active doit être liée à une zone d'effet existante.");
        }
        if ($types === "passive" && $coutPE !== 0) {
            throw new Exception("Le coût en points d'endurance d'une compétence passive doit être de 0.");
        }
        if ($types === "passive" && $zoneEffetId !== null) {
            throw new Exception("Une compétence passive ne doit pas être liée à une zone d'effet.");
        }
        $this->types = $types;
        $this->coutPE = $coutPE;
        $this->zoneEffetId = $zoneEffetId;
    }

    public function getModifAttaque(): ?int {
        return $this->modifAttaque;
    }

    public function setModifAttaque(?int $modifAttaque): void {
        if ($modifAttaque === null || $modifAttaque === 0) {
            $this->modifAttaque = null;
            return;
        }
        $this->modifAttaque = $modifAttaque;
    }

    public function getModifDefense(): ?int {
        return $this->modifDefense;
    }

    public function setModifDefense(?int $modifDefense): void {
        if ($modifDefense === null || $modifDefense === 0) {
            $this->modifDefense = null;
            return;
        }
        $this->modifDefense = $modifDefense;
    }

    public function getModifPV(): ?int {
        return $this->modifPV;
    }

    public function setModifPV(?int $modifPV): void {
        if ($modifPV === null || $modifPV === 0) {
            $this->modifPV = null;
            return;
        }
        $this->modifPV = $modifPV;
    }

    public function getModifPE(): ?int {
        return $this->modifPE;
    }

    public function setModifPE(?int $modifPE): void {
        if ($modifPE === null || $modifPE === 0) {
            $this->modifPE = null;
            return;
        }
        $this->modifPE = $modifPE;
    }

    public function getModifInitiative(): ?int {
        return $this->modifInitiative;
    }

    public function setModifInitiative(?int $modifInitiative): void {
        if ($modifInitiative === null || $modifInitiative === 0) {
            $this->modifInitiative = null;
            return;
        }
        $this->modifInitiative = $modifInitiative;
    }

    public function getModifMouvement(): ?int {
        return $this->modifMouvement;
    }

    public function setModifMouvement(?int $modifMouvement): void {
        if ($modifMouvement === null || $modifMouvement === 0) {
            $this->modifMouvement = null;
            return;
        }
        $this->modifMouvement = $modifMouvement;
    }
}
?>