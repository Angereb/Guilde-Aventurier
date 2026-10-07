<?php 
class Aventurier {
    private ?int $aventurierId;
    private string $nom;
    private ?string $icone;
    private ?string $typeIcone;
    private ?DateTime $creerLe;
    private ?DateTime $modifierLe;
    private int $creerParId;

    public const TYPES_ICONES_VALIDES = ["image/jpeg", "image/png", "image/webp"];

    public function __construct(?int $aventurierId, string $nom, ?string $icone, ?DateTime $creerLe, ?DateTime $modifierLe, int $creerParId) {
        $this->aventurierId = $aventurierId;
        $this->setNom($nom);
        $this->setIconeEtType($icone);
        $this->creerLe = $creerLe;
        $this->setModifierLe($modifierLe);
        $this->setCreerParId($creerParId);
    }

    public function getAventurierId(): ?int {
        return $this->aventurierId;
    } 

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de l'aventurier ne peut pas être vide.");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom de l'aventurier ne peut pas dépasser 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getIcone(): ?string {
        return $this->icone;
    }

    public function getTypeIcone(): ?string {
        return $this->typeIcone;
    }

    public function setIconeEtType(?string $icone): void {
        if ($icone === null) {
            $this->icone = null;
            $this->typeIcone = null;
            return;
        }
        $tailleMax = 2 * 1024 * 1024;
        if (strlen($icone) > $tailleMax) {
            throw new Exception("La taille de l'image doit être inférieure à 2Mo.");
        }
        $typeIcone = (new finfo(FILEINFO_MIME_TYPE))->buffer($icone);
        if (!in_array($typeIcone, self::TYPES_ICONES_VALIDES, true)) {
            throw new Exception("L'icône doit être une image JPEG, PNG ou WebP.");
        }
        $this->icone = $icone;
        $this->typeIcone = $typeIcone;
    }

    public function getCreerLe(): ?DateTime {
        return $this->creerLe;
    }

    public function getModifierLe(): ?DateTime {
        return $this->modifierLe;
    }

    public function setModifierLe(?DateTime $modifierLe): void {
        $this->modifierLe = $modifierLe;
    }

    public function getCreerParId(): int {
        return $this->creerParId;
    }

    public function setCreerParId(int $creerParId): void {
        if ($creerParId < 1) {
            throw new Exception("L'aventurier doit être lié à un utilisateur valide.");
        }
        $this->creerParId = $creerParId;
    }
}
?>