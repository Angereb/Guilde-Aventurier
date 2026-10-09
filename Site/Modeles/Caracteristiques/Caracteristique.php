<?php
class Caracteristique {
    private ?int $caracteristiqueId;
    private string $nom;
    private string $descriptions;

    public function __construct(?int $caracteristiqueId, string $nom, string $descriptions) {
        $this->caracteristiqueId = $caracteristiqueId;
        $this->setNom($nom);
        $this->setDescriptions($descriptions);
    }

    public function getCaracteristiqueId(): ?int {
        return $this->caracteristiqueId;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de la caractéristique ne peut être vide.");
        }
        if (mb_strlen($nom) > 32) {
            throw new Exception("Le nom de la caractéristique ne peut excéder 32 caractères.");
        }
        $this->nom = $nom;
    }

    public function getDescriptions(): string {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): void {
        $descriptions = trim($descriptions);
        if ($descriptions === "") {
            throw new Exception("La description de la caractéristique ne peut être vide.");
        }
        if (mb_strlen($descriptions) > 2500) {
            throw new Exception("La description de la caractéristique ne peut excéder 2500 caractères.");
        }
        $this->descriptions = $descriptions;
    }
}
?>