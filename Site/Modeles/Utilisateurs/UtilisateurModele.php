<?php
require_once __DIR__ . "/../BaseDeDonnees.php";
require_once __DIR__ . "/Utilisateur.php";

class UtilisateurModele {
    private PDO $pdo;

    private function genererUuid(): string {
        $brut = bin2hex(random_bytes(16));
        return substr($brut, 0, 8) . "-" . substr($brut, 8, 4) . "-" . substr($brut, 12, 4) . "-" . substr($brut, 16, 4) . "-" . substr($brut, 20, 12);
    }

    private function pseudoExiste(string $pseudo, ?int $id = null): bool {
        if ($id === null) {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = ?");

            $requete->execute([$pseudo]);
        }
        else {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = ? AND id <> ?");

            $requete->execute([$pseudo, $id]);
        }

        return $requete->fetchColumn() > 0;
    }

    private function emailExiste(string $email, ?int $id = null): bool {
        if ($id === null) {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");

            $requete->execute([$email]);
        }
        else {
            $requete = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ? AND id <> ?");

            $requete->execute([$email, $id]);
        }

        return $requete->fetchColumn() > 0;
    }

    public function __construct() {
        $this->pdo = BaseDeDonnees::connexion();
    }

    public function ajouter(Utilisateur $utilisateur): void {
        // Génération d'un UUID
        $uuid = $this->genererUuid();
        
        // Vérification de la disponibilité du pseudo
        if ($this->pseudoExiste($utilisateur->getPseudo())){
            throw new Exception("Ce pseudo est déjà utilisé.");
        }

        // Vérification de la disponibilité de l'email
        if ($this->emailExiste($utilisateur->getEmail())){
            throw new Exception("Cette adresse e-mail est déjà utilisée.");
        }

        // Hashage du mot de passe
        $motDePasse = $utilisateur->getMotDePasse();
        $motDePasseHashe = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Transformation du rôle en JSON
        $roles = $utilisateur->getRoles();
        $rolesJson = json_encode($roles);

        $requete = $this->pdo->prepare(
            "INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) VALUES (?, ?, ?, ?, ?, ?)");

        $requete->execute([
            $uuid,
            $utilisateur->getPseudo(),
            $utilisateur->getNomDeCompagnie(),
            $utilisateur->getEmail(),
            $motDePasseHashe,
            $rolesJson,
        ]);
    }

    public function rechercherParId(int $id): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");

        $requete->execute([$id]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé avec l'identifiant $id.");
        }

        // On transforme le JSON en tableau et on vérifie les données
        $roles = json_decode($donnees["roles"], true);

        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }

        // On transforme la date en DateTime
        $creerLe = new DateTime($donnees["creerLe"]);

        // On vérifie si il y a une date de modification avant de tenter de la transformer en DateTime
        $modifierLe = null;

        // On transforme l'état de suppression du compte en boolean
        $estSupprimer = (bool) $donnees["estSupprimer"];


        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }

        $utilisateur = new Utilisateur(
            $donnees["id"], $donnees["uuid"], $donnees["pseudo"], $donnees["nomCompagnie"], $donnees["email"], $donnees["motDePasse"], $roles, $creerLe, $modifierLe, true, $estSupprimer
        );

        return $utilisateur;
    }

    public function rechercherParUuid(string $uuid): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE uuid = ?");

        $requete->execute([$uuid]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé avec l'uuid $uuid.");
        }

        $roles = json_decode($donnees["roles"], true);

        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }

        $creerLe = new DateTime($donnees["creerLe"]);

        $modifierLe = null;

        $estSupprimer = (bool) $donnees["estSupprimer"];

        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }

        $utilisateur = new Utilisateur(
            $donnees["id"], $donnees["uuid"], $donnees["pseudo"], $donnees["nomCompagnie"], $donnees["email"], $donnees["motDePasse"], $roles, $creerLe, $modifierLe, true, $estSupprimer
        );

        return $utilisateur;
    }

    public function rechercherParPseudo(string $pseudo): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");

        $requete->execute([$pseudo]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé ayant pour pseudo $pseudo.");
        }

        $roles = json_decode($donnees["roles"], true);

        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }

        $creerLe = new DateTime($donnees["creerLe"]);

        $modifierLe = null;

        $estSupprimer = (bool) $donnees["estSupprimer"];

        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }

        $utilisateur = new Utilisateur(
            $donnees["id"], $donnees["uuid"], $donnees["pseudo"], $donnees["nomCompagnie"], $donnees["email"], $donnees["motDePasse"], $roles, $creerLe, $modifierLe, true, $estSupprimer
        );

        return $utilisateur;
    }

    public function rechercherParNomDeCompagnie(string $nomDeCompagnie): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE nomCompagnie = ?");

        $requete->execute([$nomDeCompagnie]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé ayant pour Compagnie $nomDeCompagnie.");
        }

        $roles = json_decode($donnees["roles"], true);

        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }

        $creerLe = new DateTime($donnees["creerLe"]);

        $modifierLe = null;

        $estSupprimer = (bool) $donnees["estSupprimer"];

        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }

        $utilisateur = new Utilisateur(
            $donnees["id"], $donnees["uuid"], $donnees["pseudo"], $donnees["nomCompagnie"], $donnees["email"], $donnees["motDePasse"], $roles, $creerLe, $modifierLe, true, $estSupprimer
        );

        return $utilisateur;
    }

    public function rechercherParEmail(string $email): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");

        $requete->execute([$email]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé ayant pour adresse mail $email.");
        }

        $roles = json_decode($donnees["roles"], true);

        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }

        $creerLe = new DateTime($donnees["creerLe"]);

        $modifierLe = null;

        $estSupprimer = (bool) $donnees["estSupprimer"];

        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }

        $utilisateur = new Utilisateur(
            $donnees["id"], $donnees["uuid"], $donnees["pseudo"], $donnees["nomCompagnie"], $donnees["email"], $donnees["motDePasse"], $roles, $creerLe, $modifierLe, true, $estSupprimer
        );

        return $utilisateur;
    }

    public function modifierPseudo(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());

        if ($this->pseudoExiste($utilisateur->getPseudo(), $utilisateur->getId())){
            throw new Exception("Ce pseudo est déjà utilisé.");
        }

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET pseudo = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $utilisateur->getPseudo(),
            $utilisateur->getId()
        ]);
    }

    public function modifierNomDeCompagnie(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET nomCompagnie = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $utilisateur->getNomDeCompagnie(),
            $utilisateur->getId()            
        ]);
    }

    public function modifierEmail(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());

        if ($this->emailExiste($utilisateur->getEmail(), $utilisateur->getId())){
            throw new Exception("Cette adresse e-mail est déjà utilisée.");
        }

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET email = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $utilisateur->getEmail(),
            $utilisateur->getId()            
        ]);
    }    

    public function modifierMotDePasse(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());

        $motDePasse = $utilisateur->getMotDePasse();
        $motDePasseHashe = password_hash($motDePasse, PASSWORD_DEFAULT);

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET motDePasse = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $motDePasseHashe,
            $utilisateur->getId()            
        ]);
    }    

    public function modifierRoles(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());

        $roles = $utilisateur->getRoles();
        $rolesJson = json_encode($roles);

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET roles = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $rolesJson,
            $utilisateur->getId()            
        ]);
    } 

    public function modifierEstSupprimer(Utilisateur $utilisateur): void {
        if ($utilisateur->getId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }

        $this->rechercherParId($utilisateur->getId());
        
        $estSupprimer= (int) $utilisateur->getEstSupprimer();

        $requete = $this->pdo->prepare("UPDATE utilisateurs SET estSupprimer = ?, modifierLe = NOW() WHERE id= ?");

        $requete->execute([
            $estSupprimer,
            $utilisateur->getId()            
        ]);
    }
}
?>
