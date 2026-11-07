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
$aventurierModele = new AventurierModele();
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

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'aventurierEnvoyer':
                $nomNouvelAventurier = $_POST["aventurierNom"];
                $iconeNouvelAventurier = null;
                $erreurEnvoi = $_FILES["aventurierIcone"]["error"] ?? UPLOAD_ERR_NO_FILE;
                if ($erreurEnvoi !== UPLOAD_ERR_NO_FILE) {
                    if ($erreurEnvoi !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES["aventurierIcone"]["tmp_name"])) {
                        throw new Exception("L'envoi de l'icône a échoué.");
                    }
                    $iconeNouvelAventurier = file_get_contents($_FILES["aventurierIcone"]["tmp_name"]);
                }
                $valeursNouvelAventurier = [];
                $caracteristiquesNouvelAventurier = $_POST["caracteristiques"] ?? [];
                if (!is_array($caracteristiquesNouvelAventurier)) {
                    throw new Exception("Les valeurs des caractéristiques doivent être incluses dans un tableau.");
                }
                if (count($caracteristiquesNouvelAventurier) !== count($nomsCaracteristiques)) {
                    throw new Exception("Toutes les caractéristiques doivent être présentes.");
                }
                foreach ($caracteristiquesNouvelAventurier as $caracteristiqueIdNouvelAventurier => $valeurCaracteristiqueNouvelAventurier) {
                    if (!isset($nomsCaracteristiques[$caracteristiqueIdNouvelAventurier])) {
                        throw new Exception("Une des caractéristiques indiquées n'existe pas.");
                    }
                    if (filter_var($valeurCaracteristiqueNouvelAventurier, FILTER_VALIDATE_INT, ["options" => ["min_range" => REGLES["caracteristiques"]["minimum"],"max_range" => REGLES["caracteristiques"]["maximum"]]]) === false) {
                        throw new Exception("Les valeurs des caractéristiques doivent être comprises entre " . REGLES["caracteristiques"]["minimum"] . " et " . REGLES["caracteristiques"]["maximum"] . ".");
                    }
                    $valeursNouvelAventurier["caracteristique-" . $caracteristiqueIdNouvelAventurier] = (int)$valeurCaracteristiqueNouvelAventurier;
                }
                $maitrisesNouvelAventurier = $_POST["maitrises"] ?? [];
                if (!is_array($maitrisesNouvelAventurier)) {
                    throw new Exception("Les valeurs des maîtrises doivent être incluses dans un tableau.");
                }
                foreach ($maitrisesNouvelAventurier as $maitriseIdNouvelAventurier => $valeurMaitriseNouvelAventurier) {
                    if (!isset($nomsMaitrises[$maitriseIdNouvelAventurier])) {
                        throw new Exception("Une des maîtrises indiquées n'existe pas.");
                    }
                    if (filter_var($valeurMaitriseNouvelAventurier, FILTER_VALIDATE_INT, ["options" => ["min_range" => REGLES["maitrises"]["minimum"],"max_range" => REGLES["maitrises"]["maximum"]]]) === false) {
                        throw new Exception("Les valeurs des maîtrises doivent être comprises entre " . REGLES["maitrises"]["minimum"] . " et " . REGLES["maitrises"]["maximum"] . ".");
                    }
                    $valeursNouvelAventurier["maitrise-" . $maitriseIdNouvelAventurier] = (int)$valeurMaitriseNouvelAventurier;
                }
                $equipementsNouvelAventurier = $_POST["inventaireAventurier"] ?? "[]";
                $equipementsNouvelAventurier = json_decode($equipementsNouvelAventurier, true);
                if (!is_array($equipementsNouvelAventurier)) {
                    throw new Exception("Les équipements doivent être inclus dans un tableau.");
                }
                foreach ($equipementsNouvelAventurier as $equipementNouvelAventurier) {
                    if (!is_array($equipementNouvelAventurier) || !isset($equipementNouvelAventurier["equipementId"]) || !isset($equipementNouvelAventurier["quantite"])) {
                        throw new Exception("Un des équipements n'est pas valide.");
                    }
                    if (filter_var($equipementNouvelAventurier["equipementId"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false || filter_var($equipementNouvelAventurier["quantite"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) {
                        throw new Exception("Un des équipements ou sa quantité n'est pas valide.");
                    }
                }
                $competencesAtteintes = [];
                foreach ($competencesDetailles as $competenceDetaillee) {
                    $competenceAtteinte = true;
                    foreach ($competenceDetaillee["requis"] as $requis) {
                        if (!isset($valeursNouvelAventurier[$requis["cible"]]) || $valeursNouvelAventurier[$requis["cible"]] < $requis["valeur"]) {
                            $competenceAtteinte = false;
                        }
                    }
                    if ($competenceAtteinte) {
                        $competencesAtteintes[] = [
                            "competenceId" => $competenceDetaillee["competence"]->getCompetenceId(),
                            "aDesRequis" => count($competenceDetaillee["requis"]) > 0
                        ];
                    }
                }
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $nouvelAventurier = new Aventurier(
                        null,
                        $nomNouvelAventurier,
                        $iconeNouvelAventurier,
                        null,
                        null,
                        (int)$_SESSION["utilisateur"]["id"]
                    );
                    $aventurierCreer = $aventurierModele->ajouter($nouvelAventurier);
                    foreach ($caracteristiquesNouvelAventurier as $caracteristiqueIdNouvelAventurier => $valeurCaracteristiqueNouvelAventurier) {
                        $caracteristiqueAventurierModele->ajouter(
                            (int)($caracteristiqueIdNouvelAventurier),
                            $aventurierCreer,
                            (int)($valeurCaracteristiqueNouvelAventurier)
                        );
                    }
                    foreach ($maitrisesNouvelAventurier as $maitriseIdNouvelAventurier => $valeurMaitriseNouvelAventurier) {
                        $maitriseAventurierModele->ajouter(
                            (int)($maitriseIdNouvelAventurier),
                            $aventurierCreer,
                            (int)($valeurMaitriseNouvelAventurier)
                        );
                    }
                    foreach ($equipementsNouvelAventurier as $equipementNouvelAventurier) {
                        $equipementAventurierModele->ajouter(
                            $equipementNouvelAventurier["equipementId"],
                            $aventurierCreer,
                            $equipementNouvelAventurier["quantite"],
                            "inventaire"
                        );
                    }
                    $competenceDebloqueUtilisateur = $deblocageCompetenceUtilisateurModele->rechercherParUtilisateur($_SESSION["utilisateur"]["id"]);
                    $competencesIdDebloquees = [];
                    foreach ($competenceDebloqueUtilisateur as $ligneDeblocage) {
                        $competencesIdDebloquees[] = $ligneDeblocage["competenceId"];
                    }
                    foreach ($competencesAtteintes as $competenceAventurier) {
                        $competenceAventurierModele->ajouter(
                            $competenceAventurier["competenceId"],
                            $aventurierCreer
                        );
                        
                        if ($competenceAventurier["aDesRequis"] && !in_array($competenceAventurier["competenceId"], $competencesIdDebloquees, true)) {
                            $deblocageCompetenceUtilisateurModele->ajouter(
                                $competenceAventurier["competenceId"],
                                (int)$_SESSION["utilisateur"]["id"]
                            );
                        }
                    }
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la création de l'aventurier : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "Votre nouvel aventurier a bien été créé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
                throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=taverne");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=aventuriercreation");
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Taverne/aventuriercreation.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>