<?php 
require_once __DIR__ . "/../../Modeles/Regles/Regles.php";
require_once __DIR__ . "/../../Modeles/Caracteristiques/CaracteristiqueModele.php";
require_once __DIR__ . "/../../Modeles/Maitrises/MaitriseModele.php";
require_once __DIR__ . "/../../Modeles/Competences/CompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ZonesEffets/ZoneEffetModele.php";
require_once __DIR__ . "/../../Modeles/RequisCaracteristiquesCompetences/RequisCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesCompetences/ModifCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/RequisMaitrisesCompetences/RequisMaitriseCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesCompetences/ModifMaitriseCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/Equipements/EquipementModele.php";
require_once __DIR__ . "/../../Modeles/RequisCaracteristiquesEquipements/RequisCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/RequisMaitrisesEquipements/RequisMaitriseEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesEquipements/ModifCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesEquipements/ModifMaitriseEquipementModele.php";
require_once __DIR__ . "/../../Modeles/Competences/ClassementCompetences.php";
require_once __DIR__ . "/../../Modeles/Aventuriers/AventurierModele.php";
require_once __DIR__ . "/../../Modeles/CaracteristiquesAventuriers/CaracteristiqueAventurierModele.php";
require_once __DIR__ . "/../../Modeles/MaitrisesAventuriers/MaitriseAventurierModele.php";
require_once __DIR__ . "/../../Modeles/CompetencesAventuriers/CompetenceAventurierModele.php";
require_once __DIR__ . "/../../Modeles/EquipementsAventuriers/EquipementAventurierModele.php";
require_once __DIR__ . "/../../Modeles/DeblocageCompetencesUtilisateurs/DeblocageCompetenceUtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Taverne : Création aventurier";

$css = [
    "Magasin/magasin.css",
    "Taverne/aventuriercreation.css"
    ];

$javascript = [
    "Magasin/magasin.js",
    "Taverne/aventuriercreation.js"
    ];

$caracteristiqueModele = new CaracteristiqueModele();
$maitriseModele = new MaitriseModele();
$competenceModele = new CompetenceModele();
$zoneEffetModele = new ZoneEffetModele();
$requisCaracteristiqueCompetenceModele = new RequisCaracteristiqueCompetenceModele();
$modifCaracteristiqueCompetenceModele = new ModifCaracteristiqueCompetenceModele();
$requisMaitriseCompetenceModele = new RequisMaitriseCompetenceModele();
$modifMaitriseCompetenceModele = new ModifMaitriseCompetenceModele();
$equipementModele = new EquipementModele();
$requisCaracteristiqueEquipementModele = new RequisCaracteristiqueEquipementModele();
$modifCaracteristiqueEquipementModele = new ModifCaracteristiqueEquipementModele();
$requisMaitriseEquipementModele = new RequisMaitriseEquipementModele();
$modifMaitriseEquipementModele = new ModifMaitriseEquipementModele();
$classementCompetences = new ClassementCompetences();

$caracteristiques = $caracteristiqueModele->rechercherToutes();
$nomsCaracteristiques = [];
foreach ($caracteristiques as $caracteristique) {
    $nomsCaracteristiques[$caracteristique->getCaracteristiqueId()] = $caracteristique->getNom();
}
$maitrises = $maitriseModele->rechercherToutes();
$nomsMaitrises = [];
foreach ($maitrises as $maitrise) {
    $nomsMaitrises[$maitrise->getMaitriseId()] = $maitrise->getNom();
}

$libellesRecueils = [];
foreach ($classementCompetences->rechercherRecueils() as $recueilExistant) {
    $libellesRecueils[$recueilExistant["cle"]] = $recueilExistant["libelle"];
}

$competences = $competenceModele->rechercherToutes();
$competencesDetailles = [];
foreach ($competences as $competence) {
    $requis = [];
    foreach ($requisCaracteristiqueCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $requisCaracteristique) {
        $requis[] = [
            "cible" => "caracteristique-" . $requisCaracteristique["caracteristiqueId"],
            "nom" => $nomsCaracteristiques[$requisCaracteristique["caracteristiqueId"]],
            "valeur" => $requisCaracteristique["valeur"]
        ];
    }
    foreach ($requisMaitriseCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $requisMaitrise) {
        $requis[] = [
            "cible" => "maitrise-" . $requisMaitrise["maitriseId"],
            "nom" => $nomsMaitrises[$requisMaitrise["maitriseId"]],
            "valeur" => $requisMaitrise["valeur"]
        ];
    }
    $modificateurs = [];
    foreach ($modifCaracteristiqueCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $modifCaracteristique) {
        $modificateurs[] = [
            "cible" => "caracteristique-" . $modifCaracteristique["caracteristiqueId"],
            "nom" => $nomsCaracteristiques[$modifCaracteristique["caracteristiqueId"]],
            "valeur" => $modifCaracteristique["valeur"]
        ];
    }
    foreach ($modifMaitriseCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $modifMaitrise) {
        $modificateurs[] = [
            "cible" => "maitrise-" . $modifMaitrise["maitriseId"],
            "nom" => $nomsMaitrises[$modifMaitrise["maitriseId"]],
            "valeur" => $modifMaitrise["valeur"]
        ];
    }
    $recueil = $classementCompetences->determinerRecueil($competence);
    $competencesDetailles[] = [
        "competence" =>$competence,
        "requis" => $requis,
        "modificateurs" => $modificateurs,
        "recueil" => $libellesRecueils[$recueil]
    ];
}

$zonesEffets = $zoneEffetModele->rechercherToutes();
$nomsZonesEffets = [];
$iconesZonesEffets = [];
foreach ($zonesEffets as $zoneEffet) {
    $nomsZonesEffets[$zoneEffet->getZoneEffetId()] = $zoneEffet->getNom();
    if ($zoneEffet->getIcone() !== null) {
        $iconesZonesEffets[$zoneEffet->getZoneEffetId()] = "data:" . $zoneEffet->getTypeIcone() . ";base64," . base64_encode($zoneEffet->getIcone());
    }
}

$equipements = $equipementModele->rechercherTous();
$equipementsDetailles = [];
foreach ($equipements as $equipement) {
    $requis = [];
    foreach ($requisCaracteristiqueEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $requisCaracteristique) {
        $requis[] = [
            "cible" => "caracteristique-" . $requisCaracteristique["caracteristiqueId"],
            "nom" => $nomsCaracteristiques[$requisCaracteristique["caracteristiqueId"]],
            "valeur" => $requisCaracteristique["valeur"]
        ];
    }
    foreach ($requisMaitriseEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $requisMaitrise) {
        $requis[] = [
            "cible" => "maitrise-" . $requisMaitrise["maitriseId"],
            "nom" => $nomsMaitrises[$requisMaitrise["maitriseId"]],
            "valeur" => $requisMaitrise["valeur"]
        ];
    }
    $modificateurs = [];
    foreach ($modifCaracteristiqueEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $modifCaracteristique) {
        $modificateurs[] = [
            "cible" => "caracteristique-" . $modifCaracteristique["caracteristiqueId"],
            "nom" => $nomsCaracteristiques[$modifCaracteristique["caracteristiqueId"]],
            "valeur" => $modifCaracteristique["valeur"]
        ];
    }
    foreach ($modifMaitriseEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $modifMaitrise) {
        $modificateurs[] = [
            "cible" => "maitrise-" . $modifMaitrise["maitriseId"],
            "nom" => $nomsMaitrises[$modifMaitrise["maitriseId"]],
            "valeur" => $modifMaitrise["valeur"]
        ];
    }
    $equipementsDetailles[] = [
        "equipement" => $equipement,
        "requis" => $requis,
        "modificateurs" => $modificateurs
    ];
}

$recueils = $classementCompetences->rechercherRecueils();


ob_start();
require __DIR__ . '/../../Vus/Taverne/aventuriercreation.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>