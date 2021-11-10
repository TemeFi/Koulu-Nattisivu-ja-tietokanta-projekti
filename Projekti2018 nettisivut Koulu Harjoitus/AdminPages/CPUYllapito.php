<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - CPUYlläpito</title>
     
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
</div>

     
        
<?php
// isset() is a PHP funktio, jolla voidaan varmistaa onko muuttujalla arvo vai ei
     
$ID = "";

    if (isset($_GET["ID"]) && isset($_GET["Return"]))
    {
         $ID= $_GET["ID"];
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
   $sqlLause = "SELECT 
   SarjaNimi,  TeknisetCPU.SarjaID AS SarjaID,  
   MerkkiNimi , TeknisetCPU.MerkkiID AS MerkkiID,
   TeknisetCPU.Malli AS Malli,
   Kanta,  TeknisetCPU.KantaID AS KantaID,
   TeknisetCPU.Ytimet AS Ytimet,
   TeknisetCPU.Threadit AS Threadit,
   TeknisetCPU.Kellotaajuus AS Kellotaajuus,
   TeknisetCPU.MAX_Kellotaajuus AS MAX_Kellotaajuus,
   TeknisetCPU.Valimuisti AS Valimuisti,
   TeknisetCPU.TDP AS TDP,
   TeknisetCPU.Teknologia AS Teknologia,
   TeknisetCPU.CPURating AS CPURating
   FROM TeknisetCPU 
   INNER JOIN Merkki ON TeknisetCPU.MerkkiID = Merkki.MerkkiID
   INNER JOIN Sarja ON TeknisetCPU.SarjaID  = Sarja.SarjaID
   INNER JOIN CPU_Kanta ON TeknisetCPU.KantaID  = CPU_Kanta.KantaID
   WHERE CPU_ID = :ID";

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
   $SarjaNimi = $row['SarjaNimi'];
   $SarjaID =  $row['SarjaID'];
   $MerkkiNimi = $row['MerkkiNimi'];
   $MerkkiID = $row['MerkkiID'];
   $Malli =  $row['Malli'];
   $Kanta =  $row['Kanta'];
   $KantaID =  $row['KantaID'];
   $Ytimet =  $row['Ytimet'];
   $Threadit =  $row['Threadit'];
   $Kellotaajuus =  $row['Kellotaajuus'];
   $MAX_Kellotaajuus =  $row['MAX_Kellotaajuus'];
   $Valimuisti =  $row['Valimuisti'];
   $TDP =  $row['TDP'];
   $Teknologia =  $row['Teknologia'];
   $CPURating =  $row['CPURating'];
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

      <?php
// ensin ehto, joka varmistaa, että käyttäjä näkee ensin lomakkeen ja vasta sen jälkeen kun 
// lomakkeelta lähetetään tietoa, tapahtuu tämä php-koodi
	if($_POST){   
    // include hakee yhteyden tietokantaan, jossa on osasto-taulu, yhteys-objektille on annettu nimi $yhteys
    include 'logininfo.php';
    try{
	  // tehdään insert eli tietorivin lisääminen tietokantaan
      // insert-kysely muodostetaan käyttäen nimettyjä parametreja
      // lisättävien tietojen sijalla	  
    $lisaysKomento = "UPDATE TeknisetCPU SET SarjaID =:Sarja, MerkkiID =:Merkki, Malli =:Malli, KantaID =:Kanta, 
    Ytimet =:Ytimet, Threadit =:Threadit, Kellotaajuus =:Kello, MAX_Kellotaajuus =:MaxKello,
    Valimuisti =:Valimuisti, TDP =:TDP, Teknologia =:Tekno, CPURating =:Rating
    WHERE CPU_ID = $ID";

	  $sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
	  $Sarja = htmlspecialchars(strip_tags($_POST["Sarja"])); 	        $Merkki = htmlspecialchars(strip_tags($_POST["Merkki"]));
	  $Malli = htmlspecialchars(strip_tags($_POST["Malli"]));	        $Kanta = htmlspecialchars(strip_tags($_POST["Kanta"]));
	  $Ytimet = htmlspecialchars(strip_tags($_POST["Ytimet"]));	        $Threadit = htmlspecialchars(strip_tags($_POST["Threadit"]));
	  $Kello = htmlspecialchars(strip_tags($_POST["Kello"]));	        $MaxKello = htmlspecialchars(strip_tags($_POST["MaxKello"]));
	  $Valimuisti = htmlspecialchars(strip_tags($_POST["Valimuisti"]));	$TDP = htmlspecialchars(strip_tags($_POST["TDP"]));
	  $Tekno = htmlspecialchars(strip_tags($_POST["Tekno"]));           $Rating = htmlspecialchars(strip_tags($_POST["Rating"]));	 



	  // laitetaan käyttäjän antamat tiedot nimettyjen parametrien tilalle
	$sqlLause->bindParam(':Sarja', $Sarja);	                  $sqlLause->bindParam(':Merkki', $Merkki);
    $sqlLause->bindParam(':Malli', $Malli);	                  $sqlLause->bindParam(':Kanta', $Kanta);
    $sqlLause->bindParam(':Ytimet', $Ytimet);                 $sqlLause->bindParam(':Threadit', $Threadit);
	$sqlLause->bindParam(':Kello', $Kello);	                  $sqlLause->bindParam(':MaxKello', $MaxKello);
	$sqlLause->bindParam(':Valimuisti', $Valimuisti);	      $sqlLause->bindParam(':TDP', $TDP);
    $sqlLause->bindParam(':Tekno', $Tekno);	                  $sqlLause->bindParam(':Rating', $Rating);                 
		                                             

	  // suorita kysely käyttäjän antamilla tiedoilla
	   if ($sqlLause->execute()){
       echo "<div class='alert alert-success'>Muutokset Tehty.";
       } else {
		   echo "<div class='alert alert-success'>Tietuetta EI lisätty.</div>";
	   }
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<div class="container-fluid">

<!--Taulussa osastotieto muutettavaksi -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID={$ID}&Return=$Return");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
        <td>ID</td>
            <td><?php echo $ID;?> </td>
        </tr>
        <tr>
            <td>Sarja</td>
              <?php
              include 'logininfo.php';
              $sql = "SELECT SarjaID, SarjaNimi FROM Sarja";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Sarja'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['SarjaID'];?>"> <?php echo $row['SarjaNimi'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $SarjaID; ?>" selected hidden> <?php echo $SarjaNimi; ?> </option>
            </select>
            </td>

            <td>Merkki</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT MerkkiID, MerkkiNimi FROM Merkki ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Merkki'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['MerkkiID'];?>"> <?php echo $row['MerkkiNimi'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $MerkkiID; ?>" selected hidden> <?php echo $MerkkiNimi; ?> </option>
            </select>
            </td>

            <td>Malli</td>
            <td><input type='text' name='Malli' value ="<?php echo $Malli; ?>" class='form-control' /></td>


            <td>Kanta</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT KantaID, Kanta FROM CPU_Kanta  ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Kanta'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['KantaID'];?>"> <?php echo $row['Kanta'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $KantaID; ?>" selected hidden> <?php echo $Kanta; ?> </option>

            </select>
            </td>

            <td>Ytimet</td>
            <td><input type='text' name='Ytimet' value ="<?php echo $Ytimet; ?>" class='form-control' /></td>
            <td>Threadit</td>
            <td><input type='text' name='Threadit' value ="<?php echo $Threadit; ?>" class='form-control' /></td>

            <td>Kellotaajuus</td>
            <td><input type='text' name='Kello'value ="<?php echo $Kellotaajuus; ?>" class='form-control' /></td>
            <td>Max_Kellotaajuus</td>
            <td><input type='text' name='MaxKello'value ="<?php echo $MAX_Kellotaajuus; ?>" class='form-control' /></td>

            <td>Välimuisti</td>
            <td><input type='text' name='Valimuisti' value ="<?php echo $Valimuisti; ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>TDP</td>
            <td><input type='text' name='TDP' value ="<?php echo $TDP; ?>"class='form-control' /></td>

            <td>Teknologia</td>
            <td><input type='text' name='Tekno' value ="<?php echo $Teknologia; ?>" class='form-control' /></td>


            <td>Rating</td>
            <td><input type='text'value ="<?php echo $CPURating; ?>" name='Rating' class='form-control' /></td>            
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Talleta muutokset' class='btn btn-primary' /> 
                <br>                <br>
                <a href="<?php echo $Return;?>.php" class='btn btn-info'>Takaisin Edelliselle Sivulle</a>
            </td>
        </tr>
    </table>
</form>       
    </div> <!-- end .container -->
</body>
</html>