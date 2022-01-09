<?php

$mysqli = new mysqli("localhost", "sql_test3_eht_in", "YMNrj2FCpkD2Dzsa", "sql_test3_eht_in");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la BDD : ' . $mysqli->connect_error);
session_start();

define("Racine", "/");

$contenu='';

require_once("fonctions.php");
?>