<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=api_plane', 'root', '');
    $retour["success"] = true;
    $retour["message"] = "Connexion réussie";
} catch (Exception $e) {
    $retour["success"] = false;
    $retour["message"] = "Connexion à la base de données impossible";
}

if (!empty($_POST["ville_depart"])) {
    $requete = $pdo->prepare("SELECT * FROM `vols` WHERE `ville_depart` LIKE :ville");
    $requete->bindParam(':ville', $_POST["ville_depart"]);
    $requete->execute();
} else {

    $requete = $pdo->prepare("SELECT * FROM `vols`");
    $requete->execute();
}

$resultats = $requete->fetchAll();


$retour["success"] = true;
$retour["message"] = "Voici les vols";
$retour["results"]["nb"] = count($resultats);
$retour["results"]["vols"] = $resultats;

echo json_encode($retour);
