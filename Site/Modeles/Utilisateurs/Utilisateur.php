<?php
class Utilisateur {
    private ?int $utilisateurId;
    private ?string $uuid;
    private string $pseudo;
    private string $nomCompagnie;
    private string $email;
    private string $motDePasse;
    private array $roles;
    private ?DateTime $creerLe;
    private ?DateTime $modifierLe;
    private bool $estSupprime;
    private bool $actif;

    public const ROLE_UTILISATEUR = "ROLE_UTILISATEUR";
    public const ROLE_ADMINISTRATEUR = "ROLE_ADMINISTRATEUR";
    public const ROLES_VALIDES = [self::ROLE_UTILISATEUR, self::ROLE_ADMINISTRATEUR];
    public const LIBELLES_ROLES = [
        self::ROLE_UTILISATEUR => "Utilisateur",
        self::ROLE_ADMINISTRATEUR => "Administrateur",
    ];

    public function __construct(?int $utilisateurId, ?string $uuid, string $pseudo, string $nomCompagnie, string $email, string $motDePasse, array $roles, ?DateTime $creerLe, ?DateTime $modifierLe, bool $motDePasseHashe = false, bool $estSupprime = false, bool $actif = true)
    {
        $this->utilisateurId = $utilisateurId;
        $this->uuid = $uuid;
        $this->setPseudo($pseudo);
        $this->setNomCompagnie($nomCompagnie);
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
        $this->setEstSupprime($estSupprime);
        $this->setActif($actif);
    }

    public function getUtilisateurId(): ?int {
        return $this->utilisateurId;
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

    public function getNomCompagnie(): string {
        return $this->nomCompagnie;
    }

    public function setNomCompagnie(string $nomCompagnie): void {
        $nomCompagnie = trim($nomCompagnie);
        if ($nomCompagnie === "") {
            throw new Exception("Le nom de la compagnie ne peut pas être vide.");
        }
        if (mb_strlen($nomCompagnie) > 128) {
            throw new Exception("Le nom de la compagnie ne peut pas dépasser 128 caractères.");
        }
        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\' _-]+$/u', $nomCompagnie)) {
            throw new Exception("Le nom de la compagnie ne peut contenir que des lettres, des chiffres, des tirets, des underscores, des apostrophes et des espaces.");
        }
        $this->nomCompagnie = $nomCompagnie;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $email = trim($email);
        if ($email === "") {
            throw new Exception("L'adresse mail ne peut pas être vide.");
        }
        if (mb_strlen($email) > 128) {
            throw new Exception("L'adresse mail ne peut pas dépasser 128 caractères.");
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
        if (strlen($motDePasse) > 72) {
            throw new Exception("Le mot de passe est trop long.");
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,72}$/u', $motDePasse)) {
            throw new Exception("Le mot de passe doit contenir au minimum 8 caractères et au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
        }
        $this->motDePasse = $motDePasse;
    }

    private function setMotDePasseHashe(string $motDePasseHashe): void {
        if ($motDePasseHashe === "") {
            throw new Exception("Le mot de passe ne peut pas être vide.");
        }
        if (!preg_match('/^\$2y\$\d{2}\$[A-Za-z0-9.\/]{53}$/', $motDePasseHashe)) {
            throw new Exception("Le format du mot de passe haché est invalide.");
        }

        $this->motDePasse = $motDePasseHashe;
    }

    public function getRoles(): array {
        return $this->roles;
    }

    public function setRoles(array $roles): void {
        if (empty($roles)) {
            throw new Exception("Un utilisateur doit posséder au moins un rôle.");
        }
        foreach ($roles as $role) {
            if (!is_string($role)) {
                throw new Exception("Chaque rôle doit être une chaîne de caractères.");
            }
            if (!in_array($role, self::ROLES_VALIDES, true)) {
                throw new Exception("Le rôle n'est pas valide.");
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

    public function getEstSupprime(): bool {
        return $this->estSupprime;
    }

    public function setEstSupprime(bool $estSupprime): void {
        $this->estSupprime = $estSupprime;
    }

    public function getActif(): bool {
        return $this->actif;
    }

    public function setActif(bool $actif): void {
        $this->actif = $actif;
    }
}
?>