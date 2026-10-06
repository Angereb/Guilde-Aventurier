<?php
class Annonce {
    private ?int $annonceId;
    private string $titre;
    private string $contenu;
    private ?DateTime $publierLe;
    private int $publierParId;

    public function __construct(?int $annonceId, string $titre, string $contenu, ?DateTime $publierLe, int $publierParId)
    {
        $this->annonceId = $annonceId;
        $this->setTitre($titre);
        $this->setContenu($contenu);
        $this->publierLe = $publierLe;
        $this->setPublierParId($publierParId);
    }

    public function getAnnonceId(): ?int {
        return $this->annonceId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("L'annonce doit avoir un titre.");
        }
        if (mb_strlen($titre) > 128) {
            throw new Exception("Le titre de l'annonce ne peut excéder 128 caractères.");
        }
        $this->titre = $titre;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void {
        $contenu = trim($contenu);
        if ($contenu === "") {
            throw new Exception("L'annonce doit avoir un contenu.");
        }
        if (mb_strlen($contenu) > 2500) {
            throw new Exception("Le contenu de l'annonce ne doit pas dépasser 2500 caractères.");
        }
        $this->contenu = $contenu;
    }

    public function getPublierLe(): ?DateTime {
        return $this->publierLe;
    }

    public function getPublierParId(): int {
        return $this->publierParId;
    }

    public function setPublierParId(int $publierParId): void {
        if ($publierParId < 1) {
            throw new Exception("L'annonce doit être liée à un utilisateur valide.");
        }
        $this->publierParId = $publierParId;
    }
}
?>