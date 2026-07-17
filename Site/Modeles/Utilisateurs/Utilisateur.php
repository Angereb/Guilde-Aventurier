<?php
class Utilisateur {
    private ?int $id;
    private ?string $uuid;
    private string $pseudo;
    private string $nomDeCompagnie;
    private string $email;
    private string $motDePasse;
    private array $roles;
    private ?DateTime $creerLe;
    private ?DateTime $modifierLe;

    public const ROLE_UTILISATEUR = "ROLE_UTILISATEUR";
    public const ROLE_ADMINISTRATEUR = "ROLE_ADMINISTRATEUR";

    public function __construct(?int $id, ?string $uuid, string $pseudo, string $nomDeCompagnie, string $email, string $motDePasse, array $roles, ?DateTime $creerLe, ?DateTime $modifierLe, bool $motDePasseHashe = false)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->setPseudo($pseudo);
        $this->setNomDeCompagnie($nomDeCompagnie);
        $this->setEmail($email);

        if ($motDePasseHashe) {
            $this->setMotDePasseHashe($motDePasse);
        }
        else {
            $this->setMotDePasse($motDePasse);
        }

        $this->setRoles($roles);
        $this->creerLe = $creerLe;
        $this->setModifierLe($modifierLe);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUuid(): ?string {
        return $this->uuid;
    }    

    public function getPseudo(): string {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): void {
        $pseudo = trim($pseudo);
        if ($pseudo === "") {
            throw new Exception("Le pseudo ne peut pas être vide.");
        }

        if (mb_strlen($pseudo) > 64) {
            throw new Exception("Le pseudo ne peut pas dépasser 64 caractères.");
        }

        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9_-]+$/u', $pseudo)) {
            throw new Exception("Le pseudo ne peut contenir que des lettres, des chiffres, des tirets et des underscores.");
        }

        $this->pseudo = $pseudo;
    }

    public function getNomDeCompagnie(): string {
        return $this->nomDeCompagnie;
    }

    public function setNomDeCompagnie(string $nomDeCompagnie): void {
        $nomDeCompagnie = trim($nomDeCompagnie);
        if ($nomDeCompagnie === "") {
            throw new Exception("Le nom de la compagnie ne peut pas être vide.");
        }

        if (mb_strlen($nomDeCompagnie) > 128) {
            throw new Exception("Le nom de la compagnie ne peut pas dépasser 128 caractères.");
        }

        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\' _-]+$/u', $nomDeCompagnie)) {
            throw new Exception("Le nom de la compagnie ne peut contenir que des lettres, des chiffres, des tirets et des underscores.");
        }

        $this->nomDeCompagnie = $nomDeCompagnie;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $email = trim($email);
        if ($email === "") {
            throw new Exception("L'addresse mail ne peut pas être vide.");
        }

        if (strlen($email) > 128) {
            throw new Exception("L'addresse mail ne peut pas dépasser 128 caractères.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse mail n'est pas valide.");
        }

        $this->email = $email;
    }

    public function getMotDePasse(): string {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): void {
        if ($motDePasse === "") {
            throw new Exception("Le mot de passe ne peut pas être vide.");
        }

        if (strlen($motDePasse) > 255) {
            throw new Exception("Le mot de passe ne peut pas dépasser 255 caractères.");
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_\-+\/])[a-zA-Z0-9!@#$%^&*_\-+\/]{8,255}$/', $motDePasse)) {
            throw new Exception("Le mot de passe doit contenir au minimum 8 caractères et au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
        }

        $this->motDePasse = $motDePasse;
    }

    private function setMotDePasseHashe(string $motDePasseHashe): void {
        $this->motDePasse = $motDePasseHashe;
    }

    public function getRoles(): array {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        if (empty($roles))
        {
            throw new Exception("Un utilisateur doit posséder au moins un rôle.");
        }

        foreach ($roles as $role)
        {
            if (!is_string($role))
            {
                throw new Exception("Chaque rôle doit être une chaîne de caractères.");
            }
        }

        $this->roles = $roles;
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
}
?>