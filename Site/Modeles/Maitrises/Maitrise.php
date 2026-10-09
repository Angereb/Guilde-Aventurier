<?php
class Maitrise {
    private ?int $maitriseId;
    private string $nom;
    private string $descriptions;

    public function __construct(?int $maitriseId, string $nom, string $descriptions) {
        $this->maitriseId = $maitriseId;
        $this->setNom($nom);
        $this->setDescriptions($descriptions);
    }

    public function getMaitriseId(): ?int {
        return $this->maitriseId;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === "") {
            throw new Exception("Le nom de la maîtrise ne peut être vide.");
        }
        if (mb_strlen($nom) > 64) {
            throw new Exception("Le nom de la maîtrise ne peut excéder 64 caractères.");
        }
        $this->nom = $nom;
    }

    public function getDescriptions(): string {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): void {
        $descriptions = trim($descriptions);
        if ($descriptions === "") {
            throw new Exception("La description de la maîtrise ne peut être vide.");
        }
        if (mb_strlen($descriptions) > 2500) {
            throw new Exception("La description de la maîtrise ne peut excéder 2500 caractères.");
        }
        $this->descriptions = $descriptions;
    }
}
?>