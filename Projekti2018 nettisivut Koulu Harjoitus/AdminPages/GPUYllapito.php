<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - GPUYlläpito</title>
     
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
   MerkkiNimi , TeknisetGPU.MerkkiID AS MerkkiID,
   ValmistajaNimi ,    TeknisetGPU.ValmistajaID AS ValmistajaID,
   SarjaNimi,  TeknisetGPU.SarjaID AS SarjaID,  
   MalliNimi,  TeknisetGPU.MalliID AS MalliID,
   Virtaliitintyyppi, TeknisetGPU.VirtaliitinID AS VirtaliitinID,
   TeknisetGPU.CUDA_STREAM AS CUDA,
   TeknisetGPU.GPUKellotaajuusBASE AS BASE,
   TeknisetGPU.GPUKellotaajuusBOOST AS BOOST,
   TeknisetGPU.GPUMEMKellotaajuus AS MEMKel,
   TeknisetGPU.GPUMEMKapasiteetti AS MEMKap,
   TeknisetGPU.GDDR AS GDDR,
   Vayla, TeknisetGPU.VaylaID AS VaylaID,
   TeknisetGPU.Pituus AS Pituus,   
   TeknisetGPU.Korkeus AS Korkeus,
   TeknisetGPU.Leveys AS Leveys,
   TeknisetGPU. MaxPystyReso AS PystReso,
   TeknisetGPU.MaxVaakaReso AS VaakReso,
   TeknisetGPU.GPURating AS Rating
   FROM TeknisetGPU 
   INNER JOIN Merkki ON TeknisetGPU.MerkkiID  = Merkki.MerkkiID
   INNER JOIN Valmistaja ON TeknisetGPU.ValmistajaID  = Valmistaja.ValmistajaID
   INNER JOIN Sarja ON TeknisetGPU.SarjaID  = Sarja.SarjaID
   INNER JOIN Malli ON TeknisetGPU.MalliID = Malli.MalliID
   INNER JOIN Virtaliitin ON TeknisetGPU.VirtaliitinID = Virtaliitin.VirtaliitinID
   INNER JOIN Vaylat ON TeknisetGPU.VaylaID = Vaylat.VaylaID
   WHERE GPU_ID = :ID";
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
   $Merkki = $row['MerkkiNimi'];
   $MerkkiID = $row['MerkkiID'];
   $Valmistaja = $row['ValmistajaNimi'];
   $ValmistajaID = $row['ValmistajaID'];
   $Sarja = $row['SarjaNimi'];
   $SarjaID =  $row['SarjaID'];
   $Malli =  $row['MalliNimi'];
   $MalliID =  $row['MalliID'];
   $Virtaliitin =  $row['Virtaliitintyyppi'];
   $VirtaliitinID =  $row['VirtaliitinID'];
   $SarjaID =  $row['SarjaID'];
   $CUDA =  $row['CUDA'];
   $BASE =  $row['BASE'];
   $BOOST =  $row['BOOST'];
   $MEMKel =  $row['MEMKel'];
   $MEMKap =  $row['MEMKap'];
   $GDDR =  $row['GDDR'];
   $Vayla =  $row['Vayla'];
   $VaylaID =  $row['VaylaID'];
   $Pituus =  $row['Pituus'];
   $Korkeus =  $row['Korkeus'];
   $Leveys =  $row['Leveys'];
   $PystReso =  $row['PystReso'];
   $VaakReso =  $row['VaakReso'];
   $Rating =  $row['Rating'];
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
    $lisaysKomento = "UPDATE TeknisetGPU SET SarjaID =:Sarja, VirtaliitinID =:Virtaliitin, ValmistajaID =:Valmistaja, MerkkiID =:Merkki, MalliID =:Malli, CUDA_STREAM =:CUDA, 
    GPUKellotaajuusBASE =:VakKello, GPUKellotaajuusBOOST =:BoostKello, GPUMEMKellotaajuus =:MuistiKello, GPUMEMKapasiteetti =:MuistiKap, GDDR =:MuistiTyyp, VaylaID =:Vayla, Pituus =:Pituus, Korkeus =:Korkeus, 
    Leveys =:Leveys, MaxPystyReso =:MaxPystRes, MaxVaakaReso =:MaxVaakRes, GPURating =:Rating
    WHERE GPU_ID = $ID";

	  $sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
	  $Sarja = htmlspecialchars(strip_tags($_POST["Sarja"])); 	          $Virtaliitin = htmlspecialchars(strip_tags($_POST["Virtaliitin"]));
	  $Valmistaja = htmlspecialchars(strip_tags($_POST["Valmistaja"]));	  $Merkki = htmlspecialchars(strip_tags($_POST["Merkki"]));
	  $Malli = htmlspecialchars(strip_tags($_POST["Malli"]));	            $CUDA = htmlspecialchars(strip_tags($_POST["CUDA"]));
	  $VakKello = htmlspecialchars(strip_tags($_POST["VakKello"]));	      $BoostKello = htmlspecialchars(strip_tags($_POST["BoostKello"]));
	  $MuistiKello = htmlspecialchars(strip_tags($_POST["MuistiKello"]));	$MuistiKap = htmlspecialchars(strip_tags($_POST["MuistiKap"]));
	  $MuistiTyyp = htmlspecialchars(strip_tags($_POST["MuistiTyyp"]));   $Vayla = htmlspecialchars(strip_tags($_POST["Vayla"]));
	  $Pituus = htmlspecialchars(strip_tags($_POST["Pituus"]));	          $Korkeus = htmlspecialchars(strip_tags($_POST["Korkeus"]));
	  $Leveys = htmlspecialchars(strip_tags($_POST["Leveys"]));	          $MaxPystRes = htmlspecialchars(strip_tags($_POST["MaxPystRes"]));
	  $MaxVaakRes = htmlspecialchars(strip_tags($_POST["MaxVaakRes"]));	 	$Rating = htmlspecialchars(strip_tags($_POST["Rating"]));	 



	  // laitetaan käyttäjän antamat tiedot nimettyjen parametrien tilalle
	  $sqlLause->bindParam(':Sarja', $Sarja);	                            $sqlLause->bindParam(':Virtaliitin', $Virtaliitin);
	  $sqlLause->bindParam(':Valmistaja', $Valmistaja);	                  $sqlLause->bindParam(':Merkki', $Merkki);
    $sqlLause->bindParam(':Malli', $Malli);	                            $sqlLause->bindParam(':CUDA', $CUDA);
    $sqlLause->bindParam(':BoostKello', $BoostKello);
	  $sqlLause->bindParam(':VakKello', $VakKello);	                      $sqlLause->bindParam(':MuistiKap', $MuistiKap);
	  $sqlLause->bindParam(':MuistiKello', $MuistiKello);	                $sqlLause->bindParam(':Vayla', $Vayla);
    $sqlLause->bindParam(':MuistiTyyp', $MuistiTyyp);	                  $sqlLause->bindParam(':Korkeus', $Korkeus);
    $sqlLause->bindParam(':Pituus', $Pituus);                           $sqlLause->bindParam(':MaxPystRes', $MaxPystRes);
	  $sqlLause->bindParam(':Leveys', $Leveys);	       	                  $sqlLause->bindParam(':Rating', $Rating);	                                             
	  $sqlLause->bindParam(':MaxVaakRes', $MaxVaakRes);	                  

	  // suorita kysely käyttäjän antamilla tiedoilla
	   if ($sqlLause->execute()){
       echo "<div class='alert alert-success'>Tietue on lisätty.";
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
                <option  value= "<?php echo $SarjaID; ?>" selected hidden> <?php echo $Sarja; ?> </option>
            </select>
            </td>

            <td>Virtaliitin</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT VirtaliitinID, Virtaliitintyyppi FROM Virtaliitin ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Virtaliitin'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['VirtaliitinID'];?>"> <?php echo $row['Virtaliitintyyppi'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $VirtaliitinID; ?>" selected hidden> <?php echo $Virtaliitin; ?> </option>
            </select>
            </td>

            <td>Valmistaja</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT ValmistajaID, ValmistajaNimi FROM Valmistaja ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Valmistaja'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['ValmistajaID'];?>"> <?php echo $row['ValmistajaNimi'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $ValmistajaID; ?>" selected hidden> <?php echo $Valmistaja; ?> </option>

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
                <option  value= "<?php echo $MerkkiID; ?>" selected hidden> <?php echo $Merkki; ?> </option>

            </select>
            </td>


            <td>Malli</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT MalliID, MalliNimi FROM Malli ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Malli'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['MalliID'];?>"> <?php echo $row['MalliNimi'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $MalliID; ?>" selected hidden> <?php echo $Malli; ?> </option>

            </select>
            </td>
            
          </tr>

         <tr>
            <td>CUDA Stream</td>
            <td><input type='text' name='CUDA' value ="<?php echo $CUDA; ?>" class='form-control' /></td>

            <td>Vakio kellotaajuus</td>
            <td><input type='text' name='VakKello'value ="<?php echo $BASE; ?>" class='form-control' /></td>

            <td>Boost kellotaajuus</td>
            <td><input type='text' name='BoostKello' value ="<?php echo $BOOST; ?>"class='form-control' /></td>

            <td>Muistin kellotaajuus</td>
            <td><input type='text' name='MuistiKello' value ="<?php echo $MEMKel; ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Muistin kapasiteetti</td>
            <td><input type='text' name='MuistiKap' value ="<?php echo $MEMKap; ?>" class='form-control' /></td>

            <td>Muistin tyyppi</td>
            <td><input type='text' name='MuistiTyyp' value ="<?php echo $GDDR; ?>" class='form-control' /></td>

            <td>Väylä</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT VaylaID, Vayla FROM Vaylat ";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='Vayla'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['VaylaID'];?>"> <?php echo $row['Vayla'];?> </option>
                <?php } ?>
                <option  value= "<?php echo $VaylaID; ?>" selected hidden> <?php echo $Vayla; ?> </option>
            </select>
            </td>

        </tr>
        <tr>
            <td>Pituus</td>
            <td><input type='text' value ="<?php echo $Pituus; ?>" name='Pituus' class='form-control' /></td>

            <td>Korkeus</td>
            <td><input type='text' value ="<?php echo $Korkeus; ?>" name='Korkeus' class='form-control' /></td>

            <td>Leveys</td>
            <td><input type='text' value ="<?php echo $Leveys; ?>" name='Leveys' class='form-control' /></td>

            <td>Maksimi pystyresoluutio</td>
            <td><input type='text' value ="<?php echo $PystReso; ?>"' name='MaxPystRes' class='form-control' /></td>

            <td>Maksimi vaakaresoluutio</td>
            <td><input type='text' value ="<?php echo $VaakReso; ?>" name='MaxVaakRes' class='form-control' /></td>

            <td>Rating</td>
            <td><input type='text' value ="<?php echo $Rating; ?>" name='Rating' class='form-control' /></td>
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