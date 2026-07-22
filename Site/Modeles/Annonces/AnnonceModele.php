<?php
require_once __DIR__ . "/../BaseDeDonnees.php";
require_once __DIR__ . "/Annonce.php";

class AnnonceModele {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = BaseDeDonnees::connexion();
    }
    
    public function ajouter(Annonce $annonce): void {
        $requete = $this->pdo->prepare(
            "INSERT INTO annonces (titre, contenu, creerParId) VALUES (?, ?, ?)");
        
        $requete->execute([
            $annonce->getTitre(),
            $annonce->getContenu(),
            $annonce->getCreerParId(),
        ]);
    }

    public function rechercherParId(int $id): Annonce {
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE id = ?");

        $requete->execute([$id]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucune annonce trouvé avec l'identifiant $id.");
        }

        $creerLe = new DateTime($donnees["publierLe"]);

        $annonce= new Annonce(
            $donnees["id"], $donnees["titre"], $donnees["contenu"], $creerLe, $donnees["creerParId"]
        );

        return $annonce;
    }

    public function rechercherParTitre(string $titre): Annonce {
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE titre = ?");

        $requete->execute([$titre]);

        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        if ($donnees === false){
            throw new Exception("Aucune annonce trouvé avec pour titre : $titre.");
        }

        $creerLe = new DateTime($donnees["publierLe"]);

        $annonce= new Annonce(
            $donnees["id"], $donnees["titre"], $donnees["contenu"], $creerLe, $donnees["creerParId"]
        );

        return $annonce;
    }

    public function rechercherParCreerParId(int $creerParId): array {
        $annonces = [];
        
        $requete = $this->pdo->prepare("SELECT * FROM annonces WHERE creerParId = ?");

        $requete->execute([$creerParId]);

        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $creerLe = new DateTime($donnees["publierLe"]);

            $annonces[] = new Annonce(
                $donnees["id"], $donnees["titre"], $donnees["contenu"], $creerLe, $donnees["creerParId"]
            );
        };

        if (empty($annonces)){
                throw new Exception("Aucune annonce trouvé dont le créateur répond à l'id $creerParId.");
            }

        return $annonces;
    }

    public function rechercherToutes(): array {
        $annonces = [];

        $requete = $this->pdo->prepare("SELECT * FROM annonces ORDER BY publierLe DESC");

        $requete->execute();

        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) {
            $creerLe = new DateTime($donnees["publierLe"]);

            $annonces[] = new Annonce(
                $donnees["id"], $donnees["titre"], $donnees["contenu"], $creerLe, $donnees["creerParId"]
            );
        };

        return $annonces;
    }

    public function modifierTitre(Annonce $annonce): void {
        if ($annonce->getId() === null){
            throw new Exception("Impossible de modifier une annonce inexistante.");
        }

        $this->rechercherParId($annonce->getId());

        $requete = $this->pdo->prepare("UPDATE annonces SET titre = ? WHERE id= ?");

        $requete->execute([
            $annonce->getTitre(),
            $annonce->getId()
        ]);
    }

    public function modifierContenu(Annonce $annonce): void {
        if ($annonce->getId() === null){
            throw new Exception("Impossible de modifier une annonce inexistante.");
        }

        $this->rechercherParId($annonce->getId());

        $requete = $this->pdo->prepare("UPDATE annonces SET contenu = ? WHERE id= ?");

        $requete->execute([
            $annonce->getContenu(),
            $annonce->getId()
        ]);
    }

    public function supprimer(int $id): void {
        $this->rechercherParId($id);
        
        $requete = $this->pdo->prepare("DELETE FROM annonces WHERE id= ?");

        $requete->execute([$id]);
    }
}
?>