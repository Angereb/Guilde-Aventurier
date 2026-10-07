<?php
class Equipement {
    private ?int $equipementId;
    private string $nom;
    private string $categorie;
    private string $descriptions;
    private int $coutPC;
    private ?int $modifAttaque;
    private ?int $modifDefense;
    private ?int $modifPV;
    private ?int $modifPE;
    private ?int $modifInitiative;
    private ?int $modifMouvement;

    public const CATEGORIES_VALIDES = ["arme", "secondaire", "armure", "bijou"];

    public function __construct(?int $equipementId, string $nom, string $categorie, string $descriptions, int $coutPC, ?int $modifAttaque = null, ?int $modifDefense = null, ?int $modifPV = null, ?int $modifPE = null, ?int $modifInitiative = null, ?int $modifMouvement = null) {
        $this->equipementId = $equipementId;
        $this->setNom($nom);
        $this->setCategorie($categorie);
        $this->setDescriptions($descriptions);
        $this->setCoutPC($coutPC);
        $this->setModifAttaque($modifAttaque);
        $this->setModifDefense($modifDefense);
        $this->setModifPV($modifPV);
        $this->setModifPE($modifPE);
        $this->setModifInitiative($modifInitiative);
        $this->setModifMouvement($modifMouvement);
    }

    public function getEquipementId(): ?int {
        return $this->equipementId;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de l'équipement ne peut pas être vide.");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom de l'équipement ne peut pas dépasser 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): void {
        $categorie = trim($categorie);
        if ($categorie === "") {
            throw new Exception("La catégorie de l'équipement ne peut être vide.");
        }
        if (mb_strlen($categorie) > 64) {
            throw new Exception("La catégorie de l'équipement ne peut dépasser 64 caractères.");
        }
        if (!in_array($categorie, self::CATEGORIES_VALIDES, true)) {
            throw new Exception("La catégorie de l'équipement n'est pas valide.");
        }
        $this->categorie = $categorie;
    }

    public function getDescriptions(): string {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): void {
        $descriptions = trim($descriptions);
        if ($descriptions === "") {
            throw new Exception("La description de l'équipement ne peut être vide.");
        }
        if (mb_strlen($descriptions) > 2500) {
            throw new Exception("La description de l'équipement ne peut excéder 2500 caractères.");
        }
        $this->descriptions = $descriptions;
    }

    public function getCoutPC(): int {
        return $this->coutPC;
    }

    public function setCoutPC(int $coutPC): void {
        if ($coutPC < 1) {
            throw new Exception("Le coût en points de compagnie ne peut être inférieur à 1.");
        }
        $this->coutPC = $coutPC;
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