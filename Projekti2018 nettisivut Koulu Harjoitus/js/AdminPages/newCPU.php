<html lang="en">
<head>
  <title>Vertailutyökalu - Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<?php
session_start();
require('loginCheck.php');
testaaLogin();

?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../etusivu.php"><img class="img-responsive" src="Logo.png" alt="Chania" width="150" height="150"> </a>
    </div>
    <ul class="nav navbar-nav">
    <li><a href="newValmistaja.php">Valmistaja</a></li>
      <li><a href="newMerkki.php">Merkki</a></li>
      <li><a href="newSarja.php">Sarja</a></li>
      <li><a href="newMalli.php">Malli</a></li>
      <li><a href="newVirtaliitin.php">Virtaliitin</a></li>
      <li><a href="newVayla.php">Väylä</a></li>
      <li><a href="newLiitin.php">Liitin</a></li>
      <li><a href="newCPU_Kanta.php">CPU kanta</a></li>
      <li><a href="newGPU.php">GPU</a></li>
      <li class="active"><a href="newCPU.php">CPU</a></li>
    </ul>
       <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
  </div>
</nav>




<div class="container-fluid">
<!-- html form - kutsuu itseään, eli php-koodi on tässä samassa tiedostossa tuossa yläpuolella -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
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
            </select>
            </td>

            <td>Malli</td>
            <td><input type='text' name='Malli' placeholder ='Malli' class='form-control' /></td>

          </tr>
          <tr>

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
            </select>
            </td>


            <td>Ytimet</td>
            <td><input type='text' name='Ytimet' placeholder ='Ytimet' class='form-control' /></td>

            <td>Threadit</td>
            <td><input type='text' name='Threadit' placeholder ='Thread' class='form-control' /></td>
            

            <td>Kellotaajuus</td>
            <td><input type='text' name='Kello'placeholder ='Numero' class='form-control' /></td>

            <td>Max kellotaajuus</td>
            <td><input type='text' name='MaxKello'placeholder ='Numero' class='form-control' /></td>

            <td>Välimuisti</td>
            <td><input type='text' name='Valimuisti' placeholder ='Numero' class='form-control' /></td>
        </tr>
        <tr>
            <td>TDP</td>
            <td><input type='text' name='TDP' placeholder ='TDP'class='form-control' /></td>

            <td>Teknologia</td>
            <td><input type='text' name='Tekno' placeholder ='Teknologia' class='form-control' /></td>


            <td>Rating</td>
            <td><input type='text'placeholder ='Numero' name='Rating' class='form-control' /></td>            
        </tr>
        <tr>
            <td>  <input type='submit' value='Lisää kantaan' class='btn btn-primary' /> </td>
            <td>  <a href='adminpage.php' class='btn btn-info'>Takaisin etusivulle</a> </td>
        </tr>
    </table>
  </form>     
</div> <!-- end .container -->

      
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
    $lisaysKomento = "INSERT INTO TeknisetCPU SET SarjaID =:Sarja, MerkkiID =:Merkki, Malli =:Malli, KantaID =:Kanta, 
    Ytimet =:Ytimet, Threadit =:Threadit, Kellotaajuus =:Kello, MAX_Kellotaajuus =:MaxKello,
    Valimuisti =:Valimuisti, TDP =:TDP, Teknologia =:Tekno, CPURating =:Rating";
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
       echo "<div class='alert alert-success'>Tietue on lisätty.";
       $sqlLause = "SELECT MAX(CPU_ID) as max_id FROM TeknisetCPU";
       $komento = $yhteys->prepare($sqlLause);
       $komento->execute();
       $rivi = $komento->fetch(PDO::FETCH_ASSOC);
       $max_id = $rivi['max_id'];
       echo "<br> <a href='LisaaKauppa.php?ID={$max_id}&IDN=CPU_ID&Taulu=TeknisetCPU&Is=CPU&Return=newCPU' class='btn btn-primary m-r-1em'>Lisää verkkokauppa linkit</a> </div>";	   
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
    <div class="row">
      <div class="col-sm-1"><div class="active-cyan-3 active-cyan-4 mb-4"> <input class="form-control" type="text" id="myInputI" onkeyup="myFunctionID()" placeholder="ID Haku" aria-label="Search"></div></div>
      <div class="col-xs-4"> <div class="active-cyan-3 active-cyan-4 mb-4"> <input class="form-control" type="text" id="myInputN" onkeyup="myFunctionName()" placeholder="Nimi Haku" aria-label="Search"></div></div>
      </div>
  </div>

  <br>
    <div class="container-fluid">

  <?php
  include 'logininfo.php';


  $sqlLause = "SELECT 
  TeknisetCPU.CPU_ID AS CPU_ID, 
  SarjaNimi , 
  MerkkiNimi ,    
  TeknisetCPU.Malli AS Malli  
  FROM TeknisetCPU 
  INNER JOIN Merkki ON TeknisetCPU.MerkkiID  = Merkki.MerkkiID
  INNER JOIN Sarja ON TeknisetCPU.SarjaID  = Sarja.SarjaID";
  
  $komento = $yhteys->prepare($sqlLause);
  $komento->execute();
  
    // palautettujen rivien lukumäärä saadaan näin
    $num = $komento->rowCount();
  
    //check if more than 0 record found
    if($num>0){
  
      echo "<table id='myTable' class='table table-hover table-responsive table-bordered'>";//start table
  
      echo "<tr>";
          echo "<th>ID</th>";
          echo "<th>CPU</th>";
      echo "</tr>";
      
    // haetaan kaikki osastot 
    // fetch() on nopeampi kuin fetchAll()
  

    while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
      // extract muuttaa
      extract($rivi);

      // tehdään jokaisesta osastotaulun rivistä oma rivi tauluun
          echo "<tr>";
          echo "<td>{$CPU_ID}</td>";
          echo "<td>$MerkkiNimi $SarjaNimi $Malli</td>";
          echo "<td>";
              echo "<a href='CPUYllapito.php?ID={$CPU_ID}&Return=newCPU' class='btn btn-primary m-r-1em'>Ylläpidä osastotietoja</a> &nbsp";
              echo "<a  href='DeleteComponent.php?poistoLinkkiTID=CPUTuoteID&poistTaulu=TeknisetCPU&Taulu=CPUVerkkokauppalinkit&poistID={$CPU_ID}&poistIDN=CPU_ID&Return=newCPU' onclick='return checkDelete(this.id)' class='btn btn-danger' id='$GPU_ID - $MerkkiNimi $ValmistajaNimi $SarjaNimi $MalliNimi'>Poista osasto</a>  &nbsp";
              echo "<a  href='LisaaKauppa.php?ID={$CPU_ID}&IDN=CPU_ID&Taulu=TeknisetCPU&Is=CPU&Return=newCPU' class='btn btn-warning'>Linkkien Hallinta</a>";

          echo "</td>";
      echo "</tr>";
  }
  }
  
  // jos ei löytynyt yhtään
  else{
      echo "<div class='alert alert-danger'>Osastoja ei löytynyt yhtään.</div>";
  }
  ?>
</div>

</body>
</html>