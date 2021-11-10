<?php

// sivu alkaa
// muodostetaan yhteys tietokantaan
$palvelimenNimi = "---";
$username = "----";
$password = "------";
$yhteys = "";
try {
$yhteys = new PDO("mysql:host=$palvelimenNimi;dbname=-------", $username, $password);
    // set the PDO error mode to exception
    $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch(PDOException $e)
    {
        echo "<div class='alert alert-danger'>
    <strong>Virhe</strong> Palvelimeen ei saada yhteyttä
  </div>";
    }

?>