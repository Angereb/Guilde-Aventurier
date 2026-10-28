<?php 
require_once __DIR__ . "/../../Modeles/Equipements/EquipementModele.php";
require_once __DIR__ . "/../../Modeles/Caracteristiques/CaracteristiqueModele.php";
require_once __DIR__ . "/../../Modeles/RequisCaracteristiquesEquipements/RequisCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/Maitrises/MaitriseModele.php";
require_once __DIR__ . "/../../Modeles/RequisMaitrisesEquipements/RequisMaitriseEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifCaracteristiquesEquipements/ModifCaracteristiqueEquipementModele.php";
require_once __DIR__ . "/../../Modeles/ModifMaitrisesEquipements/ModifMaitriseEquipementModele.php";
require_once __DIR__ . '/../../Modeles/Utilisateurs/Utilisateur.php';

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$roles = $_SESSION["utilisateur"]["roles"] ?? [];

$categorie = $_GET["categorie"] ?? "";
if (!in_array($categorie, Equipement::CATEGORIES_VALIDES, true)) {
    header("Location: ?page=bibliothequeequipements");
    exit;
}

$titre = "Bibliothèque : Équipements-" . Equipement::LIBELLES_CATEGORIE[$categorie];

$css = ["Bibliotheque/bibliothequelivre.css"];

$javascript = ["Bibliotheque/bibliothequelivre.js"];
if (in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)) {
    $javascript[] = "Bibliotheque/bibliothequelivremodalemodification.js";
}

$equipementModele = new EquipementModele();
$caracteristiqueModele = new CaracteristiqueModele();
$requisCaracteristiqueEquipementModele = new RequisCaracteristiqueEquipementModele();
$maitriseModele = new MaitriseModele();
$requisMaitriseEquipementModele = new RequisMaitriseEquipementModele();
$modifCaracteristiqueEquipementModele = new ModifCaracteristiqueEquipementModele();
$modifMaitriseEquipementModele = new ModifMaitriseEquipementModele();

$equipements = $equipementModele->rechercherParCategorie($categorie);
$equipementsDetailles = [];
foreach ($equipements as $equipement) {
    $requis = [];
    foreach ($requisCaracteristiqueEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $requisCaracteristique) {
        $requis[] = [
            "cible" => "caracteristique-" . $requisCaracteristique["caracteristiqueId"],
            "nom" => $caracteristiqueModele->rechercherParId((int)$requisCaracteristique["caracteristiqueId"])->getNom(),
            "valeur" => $requisCaracteristique["valeur"]
        ];
    }
    foreach ($requisMaitriseEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $requisMaitrise) {
        $requis[] = [
            "cible" => "maitrise-" . $requisMaitrise["maitriseId"],
            "nom" => $maitriseModele->rechercherParId((int)$requisMaitrise["maitriseId"])->getNom(),
            "valeur" => $requisMaitrise["valeur"]
        ];
    }
    $modificateurs = [];
    foreach ($modifCaracteristiqueEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $modifCaracteristique) {
        $modificateurs[] = [
            "cible" => "caracteristique-" . $modifCaracteristique["caracteristiqueId"],
            "nom" => $caracteristiqueModele->rechercherParId((int)$modifCaracteristique["caracteristiqueId"])->getNom(),
            "valeur" => $modifCaracteristique["valeur"]
        ];
    }
    foreach ($modifMaitriseEquipementModele->rechercherParEquipement($equipement->getEquipementId()) as $modifMaitrise) {
        $modificateurs[] = [
            "cible" => "maitrise-" . $modifMaitrise["maitriseId"],
            "nom" => $maitriseModele->rechercherParId((int)$modifMaitrise["maitriseId"])->getNom(),
            "valeur" => $modifMaitrise["valeur"]
        ];
    }
    $equipementsDetailles[] = [
        "equipement" => $equipement,
        "requis" => $requis,
        "modificateurs" => $modificateurs
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
            case 'equipementEnvoyer':
                $idNouvelEquipement = (int)($_POST["equipementId"] ?? 0);
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
                        $idNouvelEquipement,
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
                    $equipementModele->modifier($nouvelEquipement);
                    $requisCaracteristiqueEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $requisMaitriseEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $modifCaracteristiqueEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $modifMaitriseEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    foreach ($requisNouvelEquipement as $position => $cibleRequis) {
                        if ($cibleRequis === "") {
                            continue;
                        }
                        $valeurRequis = (int)($valeurRequisNouvelEquipement[$position] ?? 0);
                        $partiesCible = explode("-", $cibleRequis);
                        $typeCible = $partiesCible[0];
                        $idCible = (int)($partiesCible[1] ?? 0);
                        if ($typeCible === "caracteristique") {
                            $requisCaracteristiqueEquipementModele->ajouter($idCible, $idNouvelEquipement, $valeurRequis);
                        } elseif ($typeCible === "maitrise") {
                            $requisMaitriseEquipementModele->ajouter($idCible, $idNouvelEquipement, $valeurRequis);
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
                            $modifCaracteristiqueEquipementModele->ajouter($idCible, $idNouvelEquipement, $valeurModificateur);
                        } elseif ($typeCible === "maitrise") {
                            $modifMaitriseEquipementModele->ajouter($idCible, $idNouvelEquipement, $valeurModificateur);
                        } else {
                            throw new Exception("Le type de modificateur n'est pas reconnu.");
                        }
                    }
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la modification de l'équipement : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "L'équipement a bien été modifié.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'equipementSupprimer':
                $idNouvelEquipement = (int)($_POST["equipementId"] ?? 0);
                $pdo = BaseDeDonnees::connexion();
                $pdo->beginTransaction();
                try {
                    $requisCaracteristiqueEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $requisMaitriseEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $modifCaracteristiqueEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $modifMaitriseEquipementModele->supprimerParEquipement($idNouvelEquipement);
                    $equipementModele->supprimer($idNouvelEquipement);
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw new Exception("Une erreur est survenue lors de la suppression de l'équipement : " . $e->getMessage());
                }
                $_SESSION["notificationMessage"] = "L'équipement a bien été supprimé.";
                $_SESSION["typeNotification"] = "succes";
                break;

            default:
            throw new Exception("Action non reconnue.");
        }
        header("Location: ?page=bibliothequelivreequipements&categorie=" . urlencode($categorie));
        exit;
    }
    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=bibliothequelivreequipements&categorie=" . urlencode($categorie));
        exit;
    }
}

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequelivreequipements.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>