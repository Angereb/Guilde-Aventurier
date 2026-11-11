<?php
require_once __DIR__ . "/../../Configuration/regles.php";
require_once __DIR__ . "/../CaracteristiquesAventuriers/CaracteristiqueAventurierModele.php";
require_once __DIR__ . "/../MaitrisesAventuriers/MaitriseAventurierModele.php";
require_once __DIR__ . "/../EquipementsAventuriers/EquipementAventurierModele.php";
require_once __DIR__ . "/../CompetencesAventuriers/CompetenceAventurierModele.php";
require_once __DIR__ . "/../DeblocageCompetencesUtilisateurs/DeblocageCompetenceUtilisateurModele.php";

/*
 * PLAN DES DONNÉES UTILISÉES PAR CETTE CLASSE
 *
 * $this->equipementsParId[id]          (construit dans le constructeur)
 *   ["equipement"    => objet Equipement,
 *    "requis"        => [ ["cible" => "caracteristique-3", "nom" => "Force", "valeur" => 52], ... ],
 *    "modificateurs" => [ ["cible" => "caracteristique-1", "nom" => "Agilité", "valeur" => -12], ... ]]
 *
 * $this->competencesDetailles          (liste)
 *   [ ["competence" => objet Competence, "requis" => [...], "modificateurs" => [...], "recueil" => "Force"], ... ]
 *
 * $panier                              (sortie de lirePanier)
 *   [ ["equipementId" => 3, "quantite" => 1, "etat" => "equipe"], ... ]
 *
 * $valeursBrutes                       (sortie de calculerValeursBrutes)
 *   ["caracteristique-1" => 10, ..., "maitrise-2" => 500]
 *
 * $competencesAtteintes                (sortie de rechercherCompetencesAtteintes)
 *   [ ["competenceId" => 5, "aDesRequis" => true, "passive" => true, "modificateurs" => [...]], ... ]
 */

class FicheAventurier {
    private array $nomsCaracteristiques;
    private array $nomsMaitrises;
    private array $competencesDetailles;
    private array $equipementsParId;

    public function __construct(array $nomsCaracteristiques, array $nomsMaitrises, array $competencesDetailles, array $equipementsDetailles) {
        $this->nomsCaracteristiques = $nomsCaracteristiques;
        $this->nomsMaitrises = $nomsMaitrises;
        $this->competencesDetailles = $competencesDetailles;
        $this->equipementsParId = [];
        foreach ($equipementsDetailles as $equipement) {
            $this->equipementsParId[$equipement["equipement"]->getEquipementId()] = $equipement;
        }
    }

    public function lireCaracteristiques(mixed $caracteristiquesRecues): array {
        $valeursCaracteristiquesAventurier = [];
        $caracteristiquesAventurier = $caracteristiquesRecues;
        if (!is_array($caracteristiquesAventurier)) {
            throw new Exception("Les valeurs des caractéristiques doivent être incluses dans un tableau.");
        }
        if (count($caracteristiquesAventurier) !== count($this->nomsCaracteristiques)) {
            throw new Exception("Toutes les caractéristiques doivent être présentes.");
        }
        foreach ($caracteristiquesAventurier as $caracteristiqueIdAventurier => $valeurCaracteristiqueAventurier) {
            if (!isset($this->nomsCaracteristiques[$caracteristiqueIdAventurier])) {
                throw new Exception("Une des caractéristiques indiquées n'existe pas.");
            }
            if (filter_var($valeurCaracteristiqueAventurier, FILTER_VALIDATE_INT, ["options" => ["min_range" => REGLES["caracteristiques"]["minimum"],"max_range" => REGLES["caracteristiques"]["maximum"]]]) === false) {
                throw new Exception("Les valeurs des caractéristiques doivent être comprises entre " . REGLES["caracteristiques"]["minimum"] . " et " . REGLES["caracteristiques"]["maximum"] . ".");
            }
             $valeursCaracteristiquesAventurier[$caracteristiqueIdAventurier] = (int)$valeurCaracteristiqueAventurier;
        }
        return $valeursCaracteristiquesAventurier;
    }

    public function lireMaitrises(mixed $maitrisesRecues): array {
        $valeursMaitrisesAventurier = [];
        $maitrisesAventurier = $maitrisesRecues;
        if (!is_array($maitrisesAventurier)) {
            throw new Exception("Les valeurs des maîtrises doivent être incluses dans un tableau.");
        }
        foreach ($maitrisesAventurier as $maitriseIdAventurier => $valeurMaitriseAventurier) {
            if (!isset($this->nomsMaitrises[$maitriseIdAventurier])) {
                throw new Exception("Une des maîtrises indiquées n'existe pas.");
            }
            if (filter_var($valeurMaitriseAventurier, FILTER_VALIDATE_INT, ["options" => ["min_range" => REGLES["maitrises"]["minimum"],"max_range" => REGLES["maitrises"]["maximum"]]]) === false) {
                throw new Exception("Les valeurs des maîtrises doivent être comprises entre " . REGLES["maitrises"]["minimum"] . " et " . REGLES["maitrises"]["maximum"] . ".");
            }
             $valeursMaitrisesAventurier[$maitriseIdAventurier] = (int)$valeurMaitriseAventurier;
        }
        return $valeursMaitrisesAventurier;
    }

    public function lirePanier(mixed $panierRecu): array {
        if (!is_string($panierRecu)) {
            throw new Exception("Les équipements ne sont pas valides.");
        }
        $equipementsAventurier = json_decode($panierRecu, true);
        if (!is_array($equipementsAventurier)) {
            throw new Exception("Les équipements doivent être inclus dans un tableau.");
        }
        $panierVerifie = [];
        foreach ($equipementsAventurier as $equipementAventurier) {
            if (!is_array($equipementAventurier) || !isset($equipementAventurier["equipementId"]) || !isset($equipementAventurier["quantite"]) || !isset($equipementAventurier["etat"]) || !is_string($equipementAventurier["etat"])) {
                throw new Exception("Un des équipements n'est pas valide.");
            }
            if (filter_var($equipementAventurier["equipementId"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false || filter_var($equipementAventurier["quantite"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) {
                throw new Exception("Un des équipements ou sa quantité n'est pas valide.");
            }
            if (!isset($this->equipementsParId[$equipementAventurier["equipementId"]])) {
                throw new Exception("Un des équipements n'existe pas.");
            }
            $panierVerifie[] = [
                "equipementId" => (int)$equipementAventurier["equipementId"],
                "quantite" => (int)$equipementAventurier["quantite"],
                "etat" => $equipementAventurier["etat"]
            ];
        }
        return $panierVerifie;
    }

    public function calculerValeursBrutes(array $caracteristiques, array $maitrises): array {
        $valeurs = [];
        foreach ($caracteristiques as $caracteristiqueId => $valeur) {
            $valeurs["caracteristique-" . $caracteristiqueId] = $valeur;
        }
        foreach ($maitrises as $maitriseId => $valeur) {
            $valeurs["maitrise-" . $maitriseId] = $valeur;
        }
        return $valeurs;
    }

    public function rechercherCompetencesAtteintes(array $valeursBrutes): array {
        $competencesAtteintes = [];
        foreach ($this->competencesDetailles as $competenceDetaillee) {
            $competenceAtteinte = true;
            foreach ($competenceDetaillee["requis"] as $requis) {
                if (!isset($valeursBrutes[$requis["cible"]]) || $valeursBrutes[$requis["cible"]] < $requis["valeur"]) {
                    $competenceAtteinte = false;
                }
            }
            if ($competenceAtteinte) {
                $competencesAtteintes[] = [
                    "competenceId" => $competenceDetaillee["competence"]->getCompetenceId(),
                    "aDesRequis" => count($competenceDetaillee["requis"]) > 0,
                    "passive" => $competenceDetaillee["competence"]->getZoneEffetId() === null,
                    "modificateurs" => $competenceDetaillee["modificateurs"]
                ];
            }
        }
        return $competencesAtteintes;
    }

    private function calculerValeursEffectives(array $panier, array $valeursBrutes, array $competencesAtteintes, int $idExclue): array {
        $valeurs = $valeursBrutes;
        foreach ($competencesAtteintes as $competence) {
            if ($competence["passive"]) {
                foreach ($competence["modificateurs"] as $modificateur) {
                    $valeurs[$modificateur["cible"]] = ($valeurs[$modificateur["cible"]] ?? 0) + $modificateur["valeur"];
                }
            }
        }
        foreach ($panier as $equipement) {
            if ($equipement["etat"] === "equipe" && $equipement["equipementId"] !== $idExclue) {
                $detailsEquipement = $this->equipementsParId[$equipement["equipementId"]];
                foreach ($detailsEquipement["modificateurs"] as $modificateur) {
                    $valeurs[$modificateur["cible"]] = ($valeurs[$modificateur["cible"]] ?? 0) + $modificateur["valeur"];
                }
            }
        }
        return $valeurs;
    }

    public function verifierEquipementsPortes(array $panier, array $valeursBrutes, array $competencesAtteintes): void {
        $compteurCategorie = [];
        foreach ($panier as $equipement) {
            if ($equipement["etat"] === "equipe") {
                $detailsEquipement = $this->equipementsParId[$equipement["equipementId"]];
                $categorie = $detailsEquipement["equipement"]->getCategorie();
                $compteurCategorie[$categorie] = ($compteurCategorie[$categorie] ?? 0) + 1;
                if ($compteurCategorie[$categorie] > REGLES["emplacements"][$categorie]) {
                    throw new Exception("Trop d'équipements portés dans une même catégorie.");
                }
                $valeurs = $this->calculerValeursEffectives($panier, $valeursBrutes, $competencesAtteintes, $equipement["equipementId"]);
                foreach ($detailsEquipement["requis"] as $requis) {
                    if (($valeurs[$requis["cible"]] ?? 0) < $requis["valeur"]) {
                        throw new Exception($detailsEquipement["equipement"]->getNom() . " : prérequis non atteints.");
                    }
                }
            }
        }
    }

    public function enregistrerLiaisons(int $aventurierId, int $utilisateurId, array $caracteristiques, array $maitrises, array $panier, array $competencesAtteintes): void {
        $caracteristiqueAventurierModele = new CaracteristiqueAventurierModele();
        $maitriseAventurierModele = new MaitriseAventurierModele();
        $equipementAventurierModele = new EquipementAventurierModele();
        $competenceAventurierModele = new CompetenceAventurierModele();
        $deblocageCompetenceUtilisateurModele = new DeblocageCompetenceUtilisateurModele();

        foreach ($caracteristiques as $caracteristiqueId => $valeur) {
            $caracteristiqueAventurierModele->ajouter(
                (int)($caracteristiqueId),
                $aventurierId,
                (int)($valeur)
            );
        }
        foreach ($maitrises as $maitriseId => $valeur) {
            $maitriseAventurierModele->ajouter(
                (int)($maitriseId),
                $aventurierId,
                (int)($valeur)
            );
        }
        foreach ($panier as $equipement) {
            $equipementAventurierModele->ajouter(
                $equipement["equipementId"],
                $aventurierId,
                $equipement["quantite"],
                $equipement["etat"]
            );
        }
        $competencesIdDebloquees = [];
        foreach ($deblocageCompetenceUtilisateurModele->rechercherParUtilisateur($utilisateurId) as $ligneDeblocage) {
            $competencesIdDebloquees[] = $ligneDeblocage["competenceId"];
        }
        foreach ($competencesAtteintes as $competence) {
            $competenceAventurierModele->ajouter(
                $competence["competenceId"],
                $aventurierId
            );
            if ($competence["aDesRequis"] && !in_array($competence["competenceId"], $competencesIdDebloquees, true)) {
                $deblocageCompetenceUtilisateurModele->ajouter($competence["competenceId"], $utilisateurId);
            }
        }
    }
}
?>