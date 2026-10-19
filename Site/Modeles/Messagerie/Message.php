<?php 
class Message {
    private ?string $messageId;
    private int $expediteurId;
    private int $destinataireId;
    private string $titre;
    private string $contenu;
    private ?DateTime $envoyeLe;
    private bool $lu;

    public function __construct(?string $messageId, int $expediteurId, int $destinataireId, string $titre, string $contenu, ?DateTime $envoyeLe, bool $lu)
    {
        $this->messageId = $messageId;
        $this->setExpediteurId($expediteurId);
        $this->setDestinataireId($expediteurId, $destinataireId);
        $this->setTitre($titre);
        $this->setContenu($contenu);
        $this->envoyeLe = $envoyeLe;
        $this->setLu($lu);
    }

    public function getMessageId(): ?string {
        return $this->messageId;
    }

    public function getExpediteurId(): int {
        return $this->expediteurId;
    }

    public function setExpediteurId(int $expediteurId): void {
        if ($expediteurId < 1) {
            throw new Exception("Le message doit être expédié par un utilisateur valide.");
        }
        $this->expediteurId = $expediteurId;
    }

    public function getDestinataireId(): int {
        return $this->destinataireId;
    }

    public function setDestinataireId(int $expediteurId, int $destinataireId): void {
        if ($destinataireId < 1) {
            throw new Exception("Le message doit être envoyé vers un utilisateur valide.");
        }
        if ($destinataireId === $expediteurId) {
            throw new Exception("Le message doit être entre deux utilisateurs différents.");
        }
        $this->destinataireId = $destinataireId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setTitre(string $titre): void {
        $titre = trim($titre);
        if ($titre === "") {
            throw new Exception("Le message doit avoir un titre.");
        }
        if (mb_strlen($titre) > 128) {
            throw new Exception("Le titre du message ne peut excéder 128 caractères.");
        }
        $this->titre = $titre;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void {
        $contenu = trim($contenu);
        if ($contenu === "") {
            throw new Exception("Le message doit avoir un contenu.");
        }
        if (mb_strlen($contenu) > 2500) {
            throw new Exception("Le contenu du message ne doit pas dépasser 2500 caractères.");
        }
        $this->contenu = $contenu;
    }

    public function getEnvoyeLe(): ?DateTime {
        return $this->envoyeLe;
    }

    public function getLu(): bool {
        return $this->lu;
    }

    public function setLu(bool $lu): void {
        $this->lu = $lu;
    }
}
?>