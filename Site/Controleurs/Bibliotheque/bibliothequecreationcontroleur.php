<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/ZonesEffets/ZoneEffetModele.php";
require_once __DIR__ . "/../../Modeles/Equipements/EquipementModele.php";
require_once __DIR__ . "/../../Modeles/Caracteristiques/CaracteristiqueModele.php";
require_once __DIR__ . "/../../Modeles/Maitrises/MaitriseModele.php";
require_once __DIR__ . "/../../Modeles/Competences/CompetenceModele.php";
require_once __DIR__ . "/../../Modeles/RequisCaracteristiquesEquipements/RequisCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/RequisMaitrisesEquipements/RequisMaitriseEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesEquipements/ModifCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesEquipements/ModifMaitriseEquipementModele.php";
require_once __DIR__ . "/../../Modeles/RequisCaracteristiquesCompetences/RequisCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesCompetences/ModifCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/RequisMaitrisesCompetences/RequisMaitriseCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesCompetences/ModifMaitriseCompetenceModele.php";

if (!isset($_SESSION["utilisateur"]) || !in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
    header("Location: ?page=bibliothequeentree");
    exit;
}

$titre = "Bibliothèque : Création";

$css = ["Bibliotheque/bibliothequecreation.css"];

$javascript = ["Bibliotheque/bibliothequecreation.js"];

$zoneEffetModele = new ZoneEffetModele();
$caracteristiqueModele = new CaracteristiqueModele();
$equipementModele = new EquipementModele();
$maitriseModele = new MaitriseModele();
$competenceModele = new CompetenceModele();
$requisCaracteristiqueEquipementModele = new RequisCaracteristiqueEquipementModele();
$modifCaracteristiqueEquipementModele = new ModifCaracteristiqueEquipementModele();
$requisMaitriseEquipementModele = new RequisMaitriseEquipementModele();
$modifMaitriseEquipementModele = new ModifMaitriseEquipementModele();
$requisCaracteristiqueCompetenceModele = new RequisCaracteristiqueCompetenceModele();
$modifCaracteristiqueCompetenceModele = new ModifCaracteristiqueCompetenceModele();
$requisMaitriseCompetenceModele = new RequisMaitriseCompetenceModele();
$modifMaitriseCompetenceModele = new ModifMaitriseCompetenceModele();

$zonesEffets = $zoneEffetModele->rechercherToutes();
$caracteristiques = $caracteristiqueModele->rechercherToutes();
$maitrises = $maitriseModele->rechercherToutes();

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    try{
        if (!in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
            throw new Exception("Vous n'avez pas les droits nécessaires pour effectuer cette action.");
        }
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'zoneEffetEnvoyer':
                $idZoneEffet = (int)($_POST["zoneEffetId"] ?? 0);
                $nomZoneEffet = $_POST["zoneEffetNom"] ?? "";
                $directionZoneEffet = $_POST["zoneEffetDirections"] ?? [];
                if (!is_array($directionZoneEffet)) {
                    throw new Exception("Les directions doivent être incluses dans un tableau.");
                }
                $porteeZoneEffet = (int)($_POST["zoneEffetPortee"] ?? 0);
                $iconeZoneEffet = null;
                $erreurEnvoi = $_FILES["zoneEffetIcone"]["error"] ?? UPLOAD_ERR_NO_FILE;
                if ($erreurEnvoi !== UPLOAD_ERR_NO_FILE) {
                    if ($erreurEnvoi !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES["zoneEffetIcone"]["tmp_name"])) {
                        throw new Exception("L'envoi de l'icône a échoué.");
                    }
                    $iconeZoneEffet = file_get_contents($_FILES["zoneEffetIcone"]["tmp_name"]);
                }
                if ($idZoneEffet === 0) {
                    $zoneEffet = new ZoneEffet(
                        null,
                        $nomZoneEffet,
                        $directionZoneEffet,
                        $porteeZoneEffet,
                        $iconeZoneEffet);
                    $zoneEffetModele->ajouter($zoneEffet);
                    $_SESSION["notificationMessage"] = "Votre zone d'effet a bien été créée.";
                } else {
                    $zoneEffetExistante = $zoneEffetModele->rechercherParId($idZoneEffet);
                    $icone = $iconeZoneEffet ?? $zoneEffetExistante->getIcone();
                    $zoneEffet = new ZoneEffet(
                        $idZoneEffet,
                        $nomZoneEffet,
                        $directionZoneEffet,
                        $porteeZoneEffet,
                        $icone);
                    $zoneEffetModele->modifier($zoneEffet);
                    $_SESSION["notificationMessage"] = "Votre zone d'effet a bien été modifiée.";
                }
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'equipementEnvoyer':
                $nomNouvelEquipement = $_POST["equipementNom"] ?? "";
                $categorieNouvelEquipement = $_POST["equipementCategorie"] ?? "";
                $descriptionsNouvelEquipement = $_POST["equipementDescriptions"] ?? "";
                $coutPCNouvelEquipement = (int)($_POST["equipementCoutPC"] ?? 0);
                $requisNouvelEquipement = $_POST["equipementRequisCibles"] ?? [];
                if (!is_array($requisNouvelEquipement)) {
                    throw new Exception("Les prérequis doivent être inclus dans un tableau.");
                }
                $valeurRequisNouvelEquipement = $_POST["equipementRequisValeurs"] ?? [];
                if (!is_array($valeurRequisNouvelEquipement)) {
                    throw new Exception("Les valeurs des prérequis doivent être incluses dans un tableau.");
                }
                $modificateurNouvelEquipement = $_POST["equipementModificateurCibles"] ?? [];
                if (!is_array($modificateurNouvelEquipement)) {
                    throw new Exception("Les modificateurs doivent être inclus dans un tableau.");
                }
                $valeurModificateurNouvelEquipement = $_POST["equipementModificateurValeurs"] ?? [];
                if (!is_array($valeurModificateurNouvelEquipement)) {
                    throw new Exception("Les valeurs des modificateurs doivent être incluses dans un tableau.");
                }
                $modifAttaqueNouvelEquipement = (int)($_POST["equipementModifAttaque"] ?? 0);
                $modifDefenseNouvelEquipement = (int)($_POST["equipementModifDefense"] ?? 0);
                $modifPVNouvelEquipement = (int)($_POST["equipementModifPV"] ?? 0);
                $modifPENouvelEquipement = (int)($_POST["equipementModifPE"] ?? 0);
                $modifInitiativeNouvelEquipement = (int)($_POST["equipementModifInitiative"] ?? 0);
                $modifMouvementNouvelEquipement = (int)($_POST["equipementModifMouvement"] ?? 0);
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $nouvelEquipement = new Equipement(
                        null,
                        $nomNouvelEquipement,
                        $categorieNouvelEquipement,
                        $descriptionsNouvelEquipement,
                        $coutPCNouvelEquipement,
                        $modifAttaqueNouvelEquipement,
                        $modifDefenseNouvelEquipement,
                        $modifPVNouvelEquipement,
                        $modifPENouvelEquipement,
                        $modifInitiativeNouvelEquipement,
                        $modifMouvementNouvelEquipement
                    );
                    $equipementCreer = $equipementModele->ajouter($nouvelEquipement);
                    foreach ($requisNouvelEquipement as $position => $cibleRequis) {
                        if ($cibleRequis === "") {
                            continue;
                        }
                        $valeurRequis = (int)($valeurRequisNouvelEquipement[$position] ?? 0);
                        $partiesCible = explode("-", $cibleRequis);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $requisCaracteristiqueEquipementModele->ajouter($idCible, $equipementCreer, $valeurRequis);
                        } elseif ($typeCible === "maitrise") {
                            $requisMaitriseEquipementModele->ajouter($idCible, $equipementCreer, $valeurRequis);
                        } else {
                            throw new Exception("Le type de prérequis n'est pas reconnu.");
                        }
                    }
                    foreach ($modificateurNouvelEquipement as $position => $cibleModificateur) {
                        if ($cibleModificateur === "") {
                            continue;
                        }
                        $valeurModificateur = (int)($valeurModificateurNouvelEquipement[$position] ?? 0);
                        $partiesCible = explode("-", $cibleModificateur);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $modifCaracteristiqueEquipementModele->ajouter($idCible, $equipementCreer, $valeurModificateur);
                        } elseif ($typeCible === "maitrise") {
                            $modifMaitriseEquipementModele->ajouter($idCible, $equipementCreer, $valeurModificateur);
                        } else {
                            throw new Exception("Le type de modificateur n'est pas reconnu.");
                        }
                    }
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la création de l'équipement : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "Votre nouvel équipement a bien été créé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'maitriseEnvoyer':
                $nomNouvelleMaitrise = $_POST["maitriseNom"] ?? "";
                $descriptionsNouvelleMaitrise = $_POST["maitriseDescriptions"] ?? "";
                $nouvelleMaitrise = new Maitrise(
                    null,
                    $nomNouvelleMaitrise,
                    $descriptionsNouvelleMaitrise
                );
                $maitriseModele->ajouter($nouvelleMaitrise);
                $_SESSION["notificationMessage"] = "Votre nouvelle maîtrise a bien été créée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'competenceEnvoyer':
                $nomNouvelleCompetence = $_POST["competenceNom"] ?? "";
                $typeNouvelleCompetence = $_POST["competenceType"] ?? "";
                $descriptionsNouvelleCompetence = $_POST["competenceDescriptions"] ?? "";
                $coutPENouvelleCompetence = (int)($_POST["competenceCoutPE"] ?? 0);
                $zoneEffetNouvelleCompetence = (int)($_POST["competenceZoneEffetId"] ?? 0);
                if ($zoneEffetNouvelleCompetence === 0) {
                    $zoneEffetNouvelleCompetence = null;
                }
                $requisNouvelleCompetence = $_POST["competenceRequisCibles"] ?? [];
                if (!is_array($requisNouvelleCompetence)) {
                    throw new Exception("Les prérequis doivent être inclus dans un tableau.");
                }
                $valeurRequisNouvelleCompetence = $_POST["competenceRequisValeurs"] ?? [];
                if (!is_array($valeurRequisNouvelleCompetence)) {
                    throw new Exception("Les valeurs des prérequis doivent être incluses dans un tableau.");
                }
                $modificateurNouvelleCompetence = $_POST["competenceModificateurCibles"] ?? [];
                if (!is_array($modificateurNouvelleCompetence)) {
                    throw new Exception("Les modificateurs doivent être inclus dans un tableau.");
                }
                $valeurModificateurNouvelleCompetence = $_POST["competenceModificateurValeurs"] ?? [];
                if (!is_array($valeurModificateurNouvelleCompetence)) {
                    throw new Exception("Les valeurs des modificateurs doivent être incluses dans un tableau.");
                }
                $modifAttaqueNouvelleCompetence = (int)($_POST["competenceModifAttaque"] ?? 0);
                $modifDefenseNouvelleCompetence = (int)($_POST["competenceModifDefense"] ?? 0);
                $modifPVNouvelleCompetence = (int)($_POST["competenceModifPV"] ?? 0);
                $modifPENouvelleCompetence = (int)($_POST["competenceModifPE"] ?? 0);
                $modifInitiativeNouvelleCompetence = (int)($_POST["competenceModifInitiative"] ?? 0);
                $modifMouvementNouvelleCompetence = (int)($_POST["competenceModifMouvement"] ?? 0);
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $nouvelleCompetence = new Competence(
                        null,
                        $nomNouvelleCompetence,
                        $descriptionsNouvelleCompetence,
                        $typeNouvelleCompetence,                        
                        $coutPENouvelleCompetence,
                        $zoneEffetNouvelleCompetence,
                        $modifAttaqueNouvelleCompetence,
                        $modifDefenseNouvelleCompetence,
                        $modifPVNouvelleCompetence,
                        $modifPENouvelleCompetence,
                        $modifInitiativeNouvelleCompetence,
                        $modifMouvementNouvelleCompetence                        
                    );
                    $competenceCreer = $competenceModele->ajouter($nouvelleCompetence);
                    foreach ($requisNouvelleCompetence as $position => $cibleRequis) {
                        if ($cibleRequis === "") {
                            continue;
                        }
                        $valeurRequis = (int)($valeurRequisNouvelleCompetence[$position] ?? 0);
                        $partiesCible = explode("-", $cibleRequis);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $requisCaracteristiqueCompetenceModele->ajouter($idCible, $competenceCreer, $valeurRequis);
                        } elseif ($typeCible === "maitrise") {
                            $requisMaitriseCompetenceModele->ajouter($idCible, $competenceCreer, $valeurRequis);
                        } else {
                            throw new Exception("Le type de prérequis n'est pas reconnu.");
                        }
                    }
                    foreach ($modificateurNouvelleCompetence as $position => $cibleModificateur) {
                        if ($cibleModificateur === "") {
                            continue;
                        }
                        $valeurModificateur = (int)($valeurModificateurNouvelleCompetence[$position] ?? 0);
                        $partiesCible = explode("-", $cibleModificateur);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $modifCaracteristiqueCompetenceModele->ajouter($idCible, $competenceCreer, $valeurModificateur);
                        } elseif ($typeCible === "maitrise") {
                            $modifMaitriseCompetenceModele->ajouter($idCible, $competenceCreer, $valeurModificateur);
                        } else {
                            throw new Exception("Le type de modificateur n'est pas reconnu.");
                        }
                    }
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la création de la compétence : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "Votre nouvelle compétence a bien été créée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
                throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=bibliothequecreation");
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=bibliothequecreation");
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequecreation.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>