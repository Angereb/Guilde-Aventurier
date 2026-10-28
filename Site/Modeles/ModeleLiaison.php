<?php 
require_once __DIR__ . "/ModeleBase.php";

abstract class ModeleLiaison extends ModeleBase {
    protected string $table;
    protected string $premiereColonne;
    protected string $secondeColonne;
    protected ?string $colonneValeur = null;

    protected function lienExisteDeja(int $premierId, int $secondId): bool {
        $requete = $this->pdo->prepare("SELECT COUNT(*) FROM $this->table WHERE $this->premiereColonne = ? AND $this->secondeColonne = ?");
        $requete->execute([$premierId, $secondId]);
        return $requete->fetchColumn() > 0;
    }

    protected function ajouterLiaison(int $premierId, int $secondId, ?int $valeur = null): void {
        $parametres = [$premierId, $secondId,];
        if ($valeur !== null) {
            $sql = "INSERT INTO $this->table ($this->premiereColonne, $this->secondeColonne, $this->colonneValeur) VALUES (?, ?, ?)";
            $parametres[] = $valeur;
        } 
        else {
            $sql = "INSERT INTO $this->table ($this->premiereColonne, $this->secondeColonne) VALUES (?, ?)";
        }
        $requete = $this->pdo->prepare($sql);
        $requete->execute($parametres);
    }

    protected function rechercherLiaison(int $colonne, int $idRechercher): array {
        $resultats = [];
            if ($colonne === 1) {
                $requete = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->premiereColonne = ?");
            } elseif ($colonne === 2) {
                $requete = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->secondeColonne = ?");
            } else {
                throw new Exception("La colonne de recherche doit être 1 ou 2.");
            }
            $requete->execute([$idRechercher]);
            if ($this->colonneValeur !== null){
                while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
                    $resultats[] = [$this->premiereColonne => (int)$donnees[$this->premiereColonne], $this->secondeColonne => (int)$donnees[$this->secondeColonne], $this->colonneValeur => (int)$donnees[$this->colonneValeur]];
                }
            } else {
                while ($donnees = $requete->fetch(PDO::FETCH_ASSOC)){
                    $resultats[] = [$this->premiereColonne => (int)$donnees[$this->premiereColonne], $this->secondeColonne => (int)$donnees[$this->secondeColonne]];
                }
            }
        return $resultats;
    }

    protected function modifierValeurLiaison(int $premierId, int $secondId, int $valeur): void {
        $requete = $this->pdo->prepare("UPDATE $this->table SET $this->colonneValeur = ? WHERE $this->premiereColonne = ? AND $this->secondeColonne = ?");
        $requete->execute([
            $valeur,
            $premierId,
            $secondId
        ]);
    }

    protected function supprimerLiaison(int $premierId, int $secondId): void {
        $requete = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->premiereColonne = ? AND $this->secondeColonne = ?");
        $requete->execute([
            $premierId,
            $secondId
        ]);
    }

    protected function supprimerLiaisonsParSecondId(int $secondId): void {
        $requete = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->secondeColonne = ?");
        $requete->execute([$secondId]);
    }
    }
?>