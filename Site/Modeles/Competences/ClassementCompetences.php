<?php
require_once __DIR__ . "/CompetenceModele.php";
require_once __DIR__ . "/../Maitrises/MaitriseModele.php";
require_once __DIR__ . "/../Caracteristiques/CaracteristiqueModele.php";
require_once __DIR__ . "/../RequisMaitrisesCompetences/RequisMaitriseCompetenceModele.php";
require_once __DIR__ . "/../RequisCaracteristiquesCompetences/RequisCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../DeblocageCompetencesUtilisateurs/DeblocageCompetenceUtilisateurModele.php";

class ClassementCompetences {
    public const RECUEIL_BASE = "base";
    public const LIBELLE_BASE = "Base des aventuriers";

    private CompetenceModele $competenceModele;
    private RequisMaitriseCompetenceModele $requisMaitriseCompetenceModele;
    private RequisCaracteristiqueCompetenceModele $requisCaracteristiqueCompetenceModele;
    private array $nomsMaitrises = [];
    private array $nomsCaracteristiques = [];
    private ?array $competencesDebloquees = null;

    public function __construct(?int $utilisateurId = null) {
        $this->competenceModele = new CompetenceModele();
        $this->requisMaitriseCompetenceModele = new RequisMaitriseCompetenceModele();
        $this->requisCaracteristiqueCompetenceModele = new RequisCaracteristiqueCompetenceModele();

        $maitriseModele = new MaitriseModele();
        foreach ($maitriseModele->rechercherToutes() as $maitrise) {
            $this->nomsMaitrises[$maitrise->getMaitriseId()] = $maitrise->getNom();
        }
        $caracteristiqueModele = new CaracteristiqueModele();
        foreach ($caracteristiqueModele->rechercherToutes() as $caracteristique) {
            $this->nomsCaracteristiques[$caracteristique->getCaracteristiqueId()] = $caracteristique->getNom();
        }
        if ($utilisateurId !== null) {
            $this->competencesDebloquees = [];
            $deblocageModele = new DeblocageCompetenceUtilisateurModele();
            foreach ($deblocageModele->rechercherParUtilisateur($utilisateurId) as $deblocage) {
                $this->competencesDebloquees[$deblocage["competenceId"]] = true;
            }
        }
    }

    // Renvoie l'identifiant du prérequis à la valeur la plus haute (ordre alphabétique en cas d'égalité), ou null s'il n'y en a aucun
    private function choisirRequisPrincipal(array $requis, string $colonneId, array $noms): ?int {
        $idRetenu = null;
        $valeurRetenue = 0;
        foreach ($requis as $requisActuel) {
            $id = $requisActuel[$colonneId];
            $valeur = $requisActuel["valeur"];
            if ($idRetenu === null
                || $valeur > $valeurRetenue
                || ($valeur === $valeurRetenue && strcmp($noms[$id], $noms[$idRetenu]) < 0)) {
                $idRetenu = $id;
                $valeurRetenue = $valeur;
            }
        }
        return $idRetenu;
    }

    private function rechercherCompetencesVisibles(): array {
        $competencesVisibles = [];
        foreach ($this->competenceModele->rechercherToutes() as $competence) {
            if ($this->competencesDebloquees === null
                || isset($this->competencesDebloquees[$competence->getCompetenceId()])
                || $this->determinerRecueil($competence) === self::RECUEIL_BASE) {
                $competencesVisibles[] = $competence;
            }
        }
        return $competencesVisibles;
    }

    public function determinerRecueil(Competence $competence): string {
        $competenceId = $competence->getCompetenceId();
        $maitriseId = $this->choisirRequisPrincipal(
            $this->requisMaitriseCompetenceModele->rechercherParCompetence($competenceId),
            "maitriseId",
            $this->nomsMaitrises
        );
        if ($maitriseId !== null) {
            return "maitrise-" . $maitriseId;
        }
        $caracteristiqueId = $this->choisirRequisPrincipal(
            $this->requisCaracteristiqueCompetenceModele->rechercherParCompetence($competenceId),
            "caracteristiqueId",
            $this->nomsCaracteristiques
        );
        if ($caracteristiqueId !== null) {
            return "caracteristique-" . $caracteristiqueId;
        }
        return self::RECUEIL_BASE;
    }

    public function rechercherRecueils(): array {
        $clesUtilisees = [];
        foreach ($this->rechercherCompetencesVisibles() as $competence) {
            $clesUtilisees[$this->determinerRecueil($competence)] = true;
        }
        $recueils = [];
        if (isset($clesUtilisees[self::RECUEIL_BASE])) {
            $recueils[] = ["cle" => self::RECUEIL_BASE, "libelle" => self::LIBELLE_BASE];
        }
        foreach ($this->nomsMaitrises as $id => $nom) {
            if (isset($clesUtilisees["maitrise-" . $id])) {
                $recueils[] = ["cle" => "maitrise-" . $id, "libelle" => $nom];
            }
        }
        foreach ($this->nomsCaracteristiques as $id => $nom) {
            if (isset($clesUtilisees["caracteristique-" . $id])) {
                $recueils[] = ["cle" => "caracteristique-" . $id, "libelle" => $nom];
            }
        }
        return $recueils;
    }

    public function rechercherCompetencesDuRecueil(string $cle): array {
        $competences = [];
        foreach ($this->rechercherCompetencesVisibles() as $competence) {
            if ($this->determinerRecueil($competence) === $cle) {
                $competences[] = $competence;
            }
        }
        return $competences;
    }
}
?>