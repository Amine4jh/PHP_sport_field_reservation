<?php
require("../../database.php");

@session_start();
$sportRenameError = "";

function getData() {
    global $connect;
    $sports = [];
    $statement = $connect->query("SELECT id, nom FROM sports");
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
$data = getData();


$id = $_GET["id"];
$currentlySportName = $_GET["nom"];
$newSportName = $_GET["newnom"] ?? "";
$valid = true;

if (!$newSportName) {
    $sportRenameError = "Cannot rename sport, please write a sport name!";
    $valid = false;
}
foreach ($data as $sport) {
    if ($newSportName === $sport->nom) {
        $sportRenameError = "$newSportName is already exist, please try another sport name that doesn't exist!";
        $valid = false;
    }
}

if ($valid) {
    $statement = $connect->prepare("UPDATE sports SET nom='$newSportName' WHERE id=$id");
    $statement->execute();
    header("Location:sports.php");
    $_SESSION["rename-success"] = "$currentlySportName is changed to $newSportName successfully!";

} else {
    header("Location:sports.php");
    $_SESSION["rename-error"] = $sportRenameError;
}
