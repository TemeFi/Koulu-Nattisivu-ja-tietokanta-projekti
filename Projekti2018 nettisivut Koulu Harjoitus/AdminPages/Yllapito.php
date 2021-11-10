<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Ylläpito</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>

<?php
session_start();
require('loginCheck.php');
testaaLogin();
?>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Osaston tietojen muutos</h1>
        </div>
     
        <?php
// isset() is a PHP funktio, jolla voidaan varmistaa onko muuttujalla arvo vai ei
     
$ID = "";
$IDN = "";
$Nimi = "";
$NimiTieto = "";
$Taulu = "";

    if (isset($_GET["ID"]) && isset($_GET["IDN"]) &&  isset($_GET["Nimi"]) && isset($_GET["Taulu"]) && isset($_GET["Return"]))
    {
         $ID= $_GET["ID"];
         $IDN = $_GET["IDN"];
         $Nimi= $_GET["Nimi"];
         $Taulu= $_GET["Taulu"];
         $Return= $_GET["Return"];
    }
    else
    {
        die('ERROR: Osastoa ei löydy.');
    }

include 'logininfo.php';
 
// luetaan muutettavaksi pyydetty
try {
   // prepare select
   $sqlLause = "SELECT $IDN, $Nimi FROM $Taulu WHERE $IDN = :ID ";
   $komento = $yhteys->prepare( $sqlLause );

   // Sidotaan saatu osastotunnus kyselyyn
   $komento->bindParam(':ID', $ID);

   // suorita haku
   $komento->execute();
   $lukumaara = $komento->rowCount();
   if ($lukumaara  === 0)
   {
       die('ERROR: Osastoja löytyy nolla.');
   }
    // osastotieto siirretään rivi-nimiseen assosiatiiviseen muuttujaan
   $row = $komento->fetch(PDO::FETCH_ASSOC);

  // print_r($row);

   // values to fill up our form
   $ID = $row[$IDN];
   $NimiTieto = $row[$Nimi];
  //echo $ID;
  //echo $Nimi;
  //echo $NimiTieto;


}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

<?php
// check if form was submitted
if($_POST){
     
    try{

        // write update query
        // in this case, it seemed like we have so many fields to pass and 
        // it is better to label them and not use question marks
        $sqlLause = "UPDATE $Taulu 
                    SET $Nimi = :NimiTieto
                    WHERE $IDN = :ID";
 
        // prepare query for excecution
        $komento = $yhteys->prepare($sqlLause);
 
        // posted values
        $NimiTieto=htmlspecialchars(strip_tags($_POST['Nimi']));
 
        // bind the parameters
        $komento->bindParam(':ID', $ID);
        $komento->bindParam(':NimiTieto', $NimiTieto);

         
        if($komento->execute()){
            echo "<div class='alert alert-success'>Osastotiedot muutettu.</div>";
        }else{
            echo "<div class='alert alert-danger'>Osastotietoja ei muutettu.</div>";
        }
    }
     
    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!--Taulussa osastotieto muutettavaksi -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID={$ID}&IDN={$IDN}&Nimi={$Nimi}&Taulu={$Taulu}&Return=$Return");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
        <td>ID</td>
            <td><?php echo $ID;?> </td>
        </tr>
        <tr>
            <td>Nimi</td>
            <td><input type='text' name='Nimi' value="<?php echo htmlspecialchars($NimiTieto, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Talleta muutokset' class='btn btn-primary' />
                <a href="new<?php echo $Return;?>.php" class='btn btn-info'>Takaisin Edelliselle Sivulle</a>
            </td>
        </tr>
    </table>
</form>       
    </div> <!-- end .container -->
</body>
</html>