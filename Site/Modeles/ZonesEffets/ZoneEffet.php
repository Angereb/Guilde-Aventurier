<?php 
class ZoneEffet {
    private ?int $zoneEffetId;
    private string $nom;
    private array $directions;
    private int $portee;
    private ?string $icone;
    private ?string $typeIcone;

    public const DIRECTIONS_VALIDES = ["nord", "nord-est", "est", "sud-est", "sud", "sud-ouest", "ouest", "nord-ouest"];
    public const TYPES_ICONES_VALIDES = ["image/jpeg", "image/png", "image/webp"];

    public function __construct(?int $zoneEffetId, string $nom, array $directions, int $portee, ?string $icone) {
        $this->zoneEffetId = $zoneEffetId;
        $this->setNom($nom);
        $this->setDirections($directions);
        $this->setPortee($portee);
        $this->setIconeEtType($icone);
    }

    public function getZoneEffetId(): ?int {
        return $this->zoneEffetId;
    }

    public function getNom() : string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de la zone d'effet ne peut pas être vide.");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom de la zone d'effet ne peut pas dépasser 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getDirections(): array {
        return $this->directions;
    }

    public function setDirections(array $directions): void {
        if ($directions === []) {
            throw new Exception("Au moins une direction doit être désignée.");
        }
        $directions = array_values(array_unique($directions));
        foreach ($directions as $direction) {
            if (!in_array($direction, self::DIRECTIONS_VALIDES, true)) {
                throw new Exception("La direction « $direction » n'est pas valide.");
            }
        }
        $this->directions = $directions;
    }

    public function getPortee(): int {
        return $this->portee;
    }

    public function setPortee(int $portee): void {
        if ($portee < 1) {
            throw new Exception("La portée de la zone d'effet ne peut être de zéro ou négative.");
        }
        $this->portee = $portee;
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
}
?>