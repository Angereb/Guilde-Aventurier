<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Competences/ClassementCompetences.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesCompetences/ModifCaracteristiqueCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesCompetences/ModifMaitriseCompetenceModele.php";
require_once __DIR__ . "/../../Modeles/ZonesEffets/ZoneEffetModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$roles = $_SESSION["utilisateur"]["roles"] ?? [];

$utilisateurId = null;
if (!in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)) {
    $utilisateurId = (int)$_SESSION["utilisateur"]["id"];
}
$classementCompetences = new ClassementCompetences($utilisateurId);
$recueils = $classementCompetences->rechercherRecueils();

$recueil = $_GET["recueil"] ?? "";

$libelleRecueil = null;
foreach ($recueils as $recueilExistant) {
    if ($recueilExistant["cle"] === $recueil) {
        $libelleRecueil = $recueilExistant["libelle"];
        break;
    }
}
if ($libelleRecueil === null) {
    header("Location: ?page=bibliothequecompetences");
    exit;
}

$titre = "Bibliothèque : Compétences - " . $libelleRecueil;

$css = ["Bibliotheque/bibliothequelivrecompetences.css"];

$javascript = ["Bibliotheque/bibliothequelivrenavigation.js"];
if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)) {
    $javascript[] = "Bibliotheque/bibliothequelivremodalemodificationcompetence.js";
}

$competenceModele = new CompetenceModele();
$caracteristiqueModele = new CaracteristiqueModele();
$requisCaracteristiqueCompetenceModele = new RequisCaracteristiqueCompetenceModele();
$modifCaracteristiqueCompetenceModele = new ModifCaracteristiqueCompetenceModele();
$maitriseModele = new MaitriseModele();
$requisMaitriseCompetenceModele = new RequisMaitriseCompetenceModele();
$modifMaitriseCompetenceModele = new ModifMaitriseCompetenceModele();
$zoneEffetModele = new ZoneEffetModele();

$zonesEffets = $zoneEffetModele->rechercherToutes();
$nomsZonesEffets = [];
    $iconesZonesEffets = [];
foreach ($zonesEffets as $zoneEffet) {
    $nomsZonesEffets[$zoneEffet->getZoneEffetId()] = $zoneEffet->getNom();
    if ($zoneEffet->getIcone() !== null) {
        $iconesZonesEffets[$zoneEffet->getZoneEffetId()] = "data:" . $zoneEffet->getTypeIcone() . ";base64," . base64_encode($zoneEffet->getIcone());
    }
}

$competences = $classementCompetences->rechercherCompetencesDuRecueil($recueil);
$competencesDetailles = [];
foreach ($competences as $competence) {
    $requis = [];
    foreach ($requisCaracteristiqueCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $requisCaracteristique) {
        $requis[] = [
            "cible" => "caracteristique-" . $requisCaracteristique["caracteristiqueId"],
            "nom" => $caracteristiqueModele->rechercherParId((int)$requisCaracteristique["caracteristiqueId"])->getNom(),
            "valeur" => $requisCaracteristique["valeur"]
        ];
    }
    foreach ($requisMaitriseCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $requisMaitrise) {
        $requis[] = [
            "cible" => "maitrise-" . $requisMaitrise["maitriseId"],
            "nom" => $maitriseModele->rechercherParId((int)$requisMaitrise["maitriseId"])->getNom(),
            "valeur" => $requisMaitrise["valeur"]
        ];
    }
    $modificateurs = [];
    foreach ($modifCaracteristiqueCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $modifCaracteristique) {
        $modificateurs[] = [
            "cible" => "caracteristique-" . $modifCaracteristique["caracteristiqueId"],
            "nom" => $caracteristiqueModele->rechercherParId((int)$modifCaracteristique["caracteristiqueId"])->getNom(),
            "valeur" => $modifCaracteristique["valeur"]
        ];
    }
    foreach ($modifMaitriseCompetenceModele->rechercherParCompetence($competence->getCompetenceId()) as $modifMaitrise) {
        $modificateurs[] = [
            "cible" => "maitrise-" . $modifMaitrise["maitriseId"],
            "nom" => $maitriseModele->rechercherParId((int)$modifMaitrise["maitriseId"])->getNom(),
            "valeur" => $modifMaitrise["valeur"]
        ];
    }
    $competencesDetailles[] = [
        "competence" =>$competence,
        "requis" => $requis,
        "modificateurs" => $modificateurs,
    ];
}

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
            case 'competenceEnvoyer':
                $idNouvelCompetence = (int)($_POST["competenceId"] ?? 0);
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
                        $idNouvelCompetence,
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
                    $competenceModele->modifier($nouvelleCompetence);
                    $requisCaracteristiqueCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $requisMaitriseCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $modifCaracteristiqueCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $modifMaitriseCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    foreach ($requisNouvelleCompetence as $position => $cibleRequis) {
                        if ($cibleRequis === "") {
                            continue;
                        }
                        $valeurRequis = (int)($valeurRequisNouvelleCompetence[$position] ?? 0);
                        $partiesCible = explode("-", $cibleRequis);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $requisCaracteristiqueCompetenceModele->ajouter($idCible, $idNouvelCompetence, $valeurRequis);
                        } elseif ($typeCible === "maitrise") {
                            $requisMaitriseCompetenceModele->ajouter($idCible, $idNouvelCompetence, $valeurRequis);
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
                            $modifCaracteristiqueCompetenceModele->ajouter($idCible, $idNouvelCompetence, $valeurModificateur);
                        } elseif ($typeCible === "maitrise") {
                            $modifMaitriseCompetenceModele->ajouter($idCible, $idNouvelCompetence, $valeurModificateur);
                        } else {
                            throw new Exception("Le type de modificateur n'est pas reconnu.");
                        }
                    }
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la modification de la compétence : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "La compétence a bien été modifiée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'competenceSupprimer':
                $idNouvelCompetence = (int)($_POST["competenceId"] ?? 0);
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $requisCaracteristiqueCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $requisMaitriseCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $modifCaracteristiqueCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $modifMaitriseCompetenceModele->supprimerParCompetence($idNouvelCompetence);
                    $competenceModele->supprimer($idNouvelCompetence);
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la suppression de la compétence : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "La compétence a bien été supprimée.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
            throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=bibliothequelivrecompetences&recueil=" . urlencode($recueil));
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=bibliothequelivrecompetences&recueil=" . urlencode($recueil));
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequelivrecompetences.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>