<?php

session_start();
require("../../database.php");

$id = $_GET["id"];

$statement = $connect->query("UPDATE reservation SET statut='confirmée' WHERE id=$id");
$statement->execute();

header("Location:reservations.php");
$_SESSION["confirm"] = "Reservation confirmed successfully!";
