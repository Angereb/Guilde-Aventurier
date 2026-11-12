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
require_once __DIR__ . "/../../Modeles/Aventuriers/FicheAventurier.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$aventurierModele = new AventurierModele();

// Sécurisation de l'accès à la page
$aventurierId = filter_var($_GET["aventurier"] ?? "", FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
if ($aventurierId === false) {
    $_SESSION["notificationMessage"] = "Aventurier introuvable.";
    $_SESSION["typeNotification"] = "erreur";
    header("Location: ?page=dortoir");
    exit;
}

try {
    $aventurier = $aventurierModele->rechercherParId($aventurierId);
} catch (Exception $e) {
    $_SESSION["notificationMessage"] = "Aventurier introuvable.";
    $_SESSION["typeNotification"] = "erreur";
    header("Location: ?page=dortoir");
    exit;
}  

if ($aventurier->getCreerParId() !== (int)$_SESSION["utilisateur"]["id"]) {
    $_SESSION["notificationMessage"] = "Aventurier introuvable.";
    $_SESSION["typeNotification"] = "erreur";
    header("Location: ?page=dortoir");
    exit;
}

$titre = "Dortoir : " . $aventurier->getNom() . " - modification" ;

$css = [
    "Magasin/magasin.css",
    "FicheAventurier/ficheaventurier.css"
    ];

$javascript = [
    "Magasin/magasin.js",
    "FicheAventurier/ficheaventurier.js"
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
$caracteristiqueAventurierModele = new CaracteristiqueAventurierModele();
$maitriseAventurierModele = new MaitriseAventurierModele();
$competenceAventurierModele = new CompetenceAventurierModele();
$equipementAventurierModele = new EquipementAventurierModele();
$deblocageCompetenceUtilisateurModele = new DeblocageCompetenceUtilisateurModele();

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
$equipementsParId = []; 
foreach ($equipements as $equipement) {
    $equipementsParId[$equipement->getEquipementId()] = $equipement;
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

$caracteristiquesAventurier = [];
foreach ($caracteristiqueAventurierModele->rechercherParAventurier($aventurierId) as $caracteristiqueDeAventurier) {
    $caracteristiquesAventurier[$caracteristiqueDeAventurier["caracteristiqueId"]] = $caracteristiqueDeAventurier["niveau"];
}

$maitrisesAventurier = [];
foreach ($maitriseAventurierModele->rechercherParAventurier($aventurierId) as $maitriseDeAventurier) {
    $maitrisesAventurier[$maitriseDeAventurier["maitriseId"]] = $maitriseDeAventurier["niveau"];
}

$inventaireAventurier = [];
foreach ($equipementAventurierModele->rechercherParAventurier($aventurierId) as $equipementDeAventurier) {
    $equipementTrouve = $equipementsParId[$equipementDeAventurier["equipementId"]]; 
    $inventaireAventurier[] = [
        "equipementId" => $equipementDeAventurier["equipementId"],
        "categorie" => $equipementTrouve->getCategorie(),
        "nom" => $equipementTrouve->getNom(),
        "quantite" => $equipementDeAventurier["quantite"],
        "etat" => $equipementDeAventurier["etat"],
        "coutPC" => $equipementTrouve->getCoutPC()
    ];
}

$iconeAventurier = null;
if ($aventurier->getIcone() !== null) {
    $iconeAventurier = "data:" . $aventurier->getTypeIcone() . ";base64," . base64_encode($aventurier->getIcone());
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'aventurierModifier':
                $nomAventurierModifie = $_POST["aventurierNom"] ?? "";
                $iconeAventurierModifie = $aventurier->getIcone();
                $erreurEnvoi = $_FILES["aventurierIcone"]["error"] ?? UPLOAD_ERR_NO_FILE;
                if ($erreurEnvoi !== UPLOAD_ERR_NO_FILE) {
                    if ($erreurEnvoi !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES["aventurierIcone"]["tmp_name"])) {
                        throw new Exception("L'envoi de l'icône a échoué.");
                    }
                    $iconeAventurierModifie = file_get_contents($_FILES["aventurierIcone"]["tmp_name"]);
                }
                $ficheAventurier = new FicheAventurier($nomsCaracteristiques, $nomsMaitrises, $competencesDetailles, $equipementsDetailles);
                $caracteristiquesAventurierModifie = $ficheAventurier->lireCaracteristiques($_POST["caracteristiques"] ?? []);
                $maitrisesAventurierModifie = $ficheAventurier->lireMaitrises($_POST["maitrises"] ?? []);
                $valeursAventurierModifie = $ficheAventurier->calculerValeursBrutes($caracteristiquesAventurierModifie, $maitrisesAventurierModifie);
                $equipementsAventurierModifie = $ficheAventurier->lirePanier($_POST["inventaireAventurier"] ?? "[]");
                $competencesAtteintes = $ficheAventurier->rechercherCompetencesAtteintes($valeursAventurierModifie);
                $ficheAventurier->verifierEquipementsPortes($equipementsAventurierModifie, $valeursAventurierModifie, $competencesAtteintes);
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $aventurierModifie = new Aventurier(
                        $aventurierId,
                        $nomAventurierModifie,
                        $iconeAventurierModifie,
                        $aventurier->getCreerLe(),
                        null,
                        (int)$_SESSION["utilisateur"]["id"]
                    );
                    $aventurierModele->modifier($aventurierModifie);
                    $caracteristiqueAventurierModele->supprimerParAventurier($aventurierId);
                    $maitriseAventurierModele->supprimerParAventurier($aventurierId);
                    $equipementAventurierModele->supprimerParAventurier($aventurierId);
                    $competenceAventurierModele->supprimerParAventurier($aventurierId);
                    $ficheAventurier->enregistrerLiaisons(
                        $aventurierId,
                        (int)$_SESSION["utilisateur"]["id"],
                        $caracteristiquesAventurierModifie,
                        $maitrisesAventurierModifie,
                        $equipementsAventurierModifie,
                        $competencesAtteintes
                    );
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la modification de l'aventurier : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "Votre aventurier a bien été modifié.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'aventurierSupprimer':
                $aventurierModele->supprimer($aventurierId);
                $_SESSION["notificationMessage"] = "Votre aventurier a bien été supprimé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
                throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=dortoir");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=aventuriermodification&aventurier=" . $aventurierId);
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Dortoir/aventuriermodification.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>