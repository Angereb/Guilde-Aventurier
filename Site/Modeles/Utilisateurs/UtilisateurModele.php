<?php
require_once __DIR__ . "/../ModeleBase.php";
require_once __DIR__ . "/Utilisateur.php";
require_once __DIR__ . "/../Aventuriers/AventurierModele.php";

class UtilisateurModele extends ModeleBase{
    private function genererUuid(): string {
        $octets = random_bytes(16);
        $octets[6] = chr((ord($octets[6]) & 0x0f) | 0x40);
        $octets[8] = chr((ord($octets[8]) & 0x3f) | 0x80);
        $brut = bin2hex($octets);
        return substr($brut, 0, 8) . "-" . substr($brut, 8, 4) . "-" . substr($brut, 12, 4) . "-" . substr($brut, 16, 4) . "-" . substr($brut, 20, 12);
    }

    private function creerUtilisateurDepuisDonnees(array $donnees): Utilisateur {
        // On s'assure que l'id est bien sous le format int
        $utilisateurId = (int)$donnees["utilisateurId"];
        // On transforme le JSON en tableau et on vérifie les données
        $roles = json_decode($donnees["roles"], true);
        if (!is_array($roles)) {
            throw new Exception("Les rôles de l'utilisateur sont invalides.");
        }
        // On transforme la date en DateTime
        $creerLe = new DateTime($donnees["creerLe"]);
        // On vérifie s'il y a une date de modification avant de tenter de la transformer en DateTime
        $modifierLe = null;
        if ($donnees["modifierLe"] !== null) {
            $modifierLe = new DateTime($donnees["modifierLe"]);
        }
        // On transforme l'état de suppression du compte en booléen
        $estSupprime = (bool)$donnees["estSupprime"];
        // On transforme l'état d'activation du compte en booléen
        $actif = (bool)$donnees["actif"];
        $utilisateur = new Utilisateur(
            $utilisateurId, 
            $donnees["uuid"], 
            $donnees["pseudo"], 
            $donnees["nomCompagnie"], 
            $donnees["email"], 
            $donnees["motDePasse"], 
            $roles, 
            $creerLe, 
            $modifierLe, 
            true, 
            $estSupprime,
            $actif
        );
        return $utilisateur;
    }

    public function ajouter(Utilisateur $utilisateur): void {
        // Génération d'un UUID
        $uuid = $this->genererUuid();
        // Vérification de la disponibilité du pseudo
        if ($this->valeurExisteDeja("utilisateurs", "pseudo", $utilisateur->getPseudo())){
            throw new Exception("Ce pseudo est déjà utilisé.");
        }
        // Vérification de la disponibilité de l'email
        if ($this->valeurExisteDeja("utilisateurs", "email", $utilisateur->getEmail())){
            throw new Exception("Cette adresse e-mail est déjà utilisée.");
        }
        // Hachage du mot de passe
        $motDePasseHashe = password_hash($utilisateur->getMotDePasse(), PASSWORD_BCRYPT);
        // Transformation du rôle en JSON
        $rolesJson = json_encode($utilisateur->getRoles());
        $requete = $this->pdo->prepare(
            "INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) VALUES (?, ?, ?, ?, ?, ?)");
        $requete->execute([
            $uuid,
            $utilisateur->getPseudo(),
            $utilisateur->getNomCompagnie(),
            $utilisateur->getEmail(),
            $motDePasseHashe,
            $rolesJson,
        ]);
    }

    public function rechercherParId(int $utilisateurId): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE utilisateurId = ?");
        $requete->execute([$utilisateurId]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé avec l'identifiant $utilisateurId.");
        }
        $utilisateur = $this->creerUtilisateurDepuisDonnees($donnees);
        return $utilisateur;
    }

    public function rechercherParUuid(string $uuid): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE uuid = ?");
        $requete->execute([$uuid]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé avec l'uuid $uuid.");
        }
        $utilisateur = $this->creerUtilisateurDepuisDonnees($donnees);
        return $utilisateur;
    }

    public function rechercherParPseudo(string $pseudo): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
        $requete->execute([$pseudo]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé ayant pour pseudo $pseudo.");
        }
        $utilisateur = $this->creerUtilisateurDepuisDonnees($donnees);
        return $utilisateur;
    }

    public function rechercherParEmail(string $email): Utilisateur {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $requete->execute([$email]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees === false){
            throw new Exception("Aucun utilisateur trouvé ayant pour adresse mail $email.");
        }
        $utilisateur = $this->creerUtilisateurDepuisDonnees($donnees);
        return $utilisateur;
    }

    public function rechercherToutesCompagnies(string $nomCompagnie): array {
        $compagnies = [];
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE nomCompagnie = ?");
        $requete->execute([$nomCompagnie]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
            $compagnies[] = $this->creerUtilisateurDepuisDonnees($donnees);
        }
        if (empty($compagnies)){
            throw new Exception("Aucun utilisateur trouvé ayant pour Compagnie $nomCompagnie.");
        }
        return $compagnies;
    }

    public function modifier(Utilisateur $utilisateur): void {
        if ($utilisateur->getUtilisateurId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }
        $this->rechercherParId($utilisateur->getUtilisateurId());
        if ($this->valeurExisteDeja("utilisateurs", "pseudo", $utilisateur->getPseudo(), $utilisateur->getUtilisateurId(), "utilisateurId")){
            throw new Exception("Ce pseudo est déjà utilisé.");
        }
        if ($this->valeurExisteDeja("utilisateurs", "email", $utilisateur->getEmail(), $utilisateur->getUtilisateurId(), "utilisateurId")){
            throw new Exception("Cette adresse e-mail est déjà utilisée.");
        }
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET pseudo = ?, nomCompagnie = ?, email = ?, modifierLe = NOW() WHERE utilisateurId= ?");
        $requete->execute([
            $utilisateur->getPseudo(),
            $utilisateur->getNomCompagnie(),
            $utilisateur->getEmail(),
            $utilisateur->getUtilisateurId()
        ]);
    }  

    public function modifierMotDePasse(Utilisateur $utilisateur): void {
        if ($utilisateur->getUtilisateurId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }
        $this->rechercherParId($utilisateur->getUtilisateurId());
        $motDePasse = $utilisateur->getMotDePasse();
        $motDePasseHashe = password_hash($motDePasse, PASSWORD_BCRYPT);
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET motDePasse = ?, modifierLe = NOW() WHERE utilisateurId= ?");
        $requete->execute([
            $motDePasseHashe,
            $utilisateur->getUtilisateurId()            
        ]);
    }    

    public function modifierRoles(Utilisateur $utilisateur): void {
        if ($utilisateur->getUtilisateurId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }
        $this->rechercherParId($utilisateur->getUtilisateurId());
        $roles = $utilisateur->getRoles();
        $rolesJson = json_encode($roles);
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET roles = ?, modifierLe = NOW() WHERE utilisateurId= ?");
        $requete->execute([
            $rolesJson,
            $utilisateur->getUtilisateurId()            
        ]);
    } 

    public function modifierEstSupprime(Utilisateur $utilisateur): void {
        if ($utilisateur->getUtilisateurId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }
        $this->rechercherParId($utilisateur->getUtilisateurId());
        $estSupprime= (int)$utilisateur->getEstSupprime();
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET estSupprime = ?, modifierLe = NOW() WHERE utilisateurId= ?");
        $requete->execute([
            $estSupprime,
            $utilisateur->getUtilisateurId()            
        ]);
    }

    public function modifierActif(Utilisateur $utilisateur): void {
        if ($utilisateur->getUtilisateurId() === null){
            throw new Exception("Impossible de modifier un utilisateur inexistant.");
        }
        $this->rechercherParId($utilisateur->getUtilisateurId());
        $actif= (int)$utilisateur->getActif();
        $requete = $this->pdo->prepare("UPDATE utilisateurs SET actif = ?, modifierLe = NOW() WHERE utilisateurId= ?");
        $requete->execute([
            $actif,
            $utilisateur->getUtilisateurId()            
        ]);
    }

    public function anonymiser(int $utilisateurId): void {
        $utilisateur = $this->rechercherParId($utilisateurId);
        $this->pdo->beginTransaction();
        try {
            $aventurierModele = new AventurierModele;
            $aventuriers = $aventurierModele->rechercherParCreerParId($utilisateurId);
            foreach ($aventuriers as $aventurier) {
                $aventurierModele->supprimer($aventurier->getAventurierId());
            }
            $requeteDeblocage = $this->pdo->prepare("DELETE FROM deblocage_competences_utilisateurs WHERE utilisateurId = ?");
            $requeteDeblocage->execute([$utilisateurId]);
            $requeteRelationUtilisateur = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE utilisateurId = ?");
            $requeteRelationUtilisateur->execute([$utilisateurId]);
            $requeteRelationContact = $this->pdo->prepare("DELETE FROM relations_utilisateurs WHERE contactId = ?");
            $requeteRelationContact->execute([$utilisateurId]);
            $pseudoAnonymiser = "Anonyme-" . $utilisateur->getUuid();
            $nomCompagnieAnonymiser = "Compagnie dissoute";
            $emailAnonymiser = "anonyme-" . $utilisateur->getUuid() . "@guilde.invalid";
            $motDePasseAnonymiser = password_hash(bin2hex(random_bytes(32)), PASSWORD_BCRYPT);
            $requeteUtilisateur = $this->pdo->prepare("UPDATE utilisateurs SET pseudo = ?, nomCompagnie = ?, email = ?, motDePasse = ?, estSupprime = ?, actif = ?, modifierLe = NOW() WHERE utilisateurId= ?");
            $requeteUtilisateur->execute([
                $pseudoAnonymiser,
                $nomCompagnieAnonymiser,
                $emailAnonymiser,
                $motDePasseAnonymiser,
                1,
                0,
                $utilisateurId
            ]);
            $this->pdo->commit();
        } catch (Exception $e){
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de l'anonymisation : " . $e->getMessage());
        } 
    }
}
?>