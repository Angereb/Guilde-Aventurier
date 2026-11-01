<?php 
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Competences/ClassementCompetences.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Bibliothèque : Compétences";

$css = ["Bibliotheque/bibliothequecompetences.css"];

$javascript = ["Bibliotheque/bibliothequecompetences.js"];

$roles = $_SESSION["utilisateur"]["roles"] ?? [];

$utilisateurId = null;
if (!in_array(Utilisateur::ROLE_ADMINISTRATEUR, $roles)) {
    $utilisateurId = (int)$_SESSION["utilisateur"]["id"];
}
$classementCompetences = new ClassementCompetences($utilisateurId);
$recueils = $classementCompetences->rechercherRecueils();
$bibliotheques = array_chunk($recueils, 3);
$rangees = array_chunk($bibliotheques, 4);

ob_start();
require __DIR__ . '/../../Vus/Bibliotheque/bibliothequecompetences.php';
$contenu = ob_get_clean();
require __DIR__ . '/../../Vus/calqueprincipale.php';
?>