<?php
class Annonce {
    private ?int $id;
    private string $titre;
    private string $contenu;
    private ?DateTime $creerLe;
    private int $creerParId;

    public function __construct(?int $id, string $titre, string $contenu, ?DateTime $creerLe, int $creerParId)
    {
        $this->id = $id;
        $this->setTitre($titre);
        $this->setContenu($contenu);
        $this->creerLe = $creerLe;
        $this->setCreerParId($creerParId);
    }

    public function getId(): ?int {
        return $this->id;
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
            throw new Exception("Le titre de l'annonce ne peut excéder 128 cractères.");
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

    public function getCreerLe(): ?DateTime {
        return $this->creerLe;
    }

    public function getCreerParId(): int {
        return $this->creerParId;
    }

    public function setCreerParId(int $creerParId): void {
        $this->creerParId = $creerParId;
    }
}
?>