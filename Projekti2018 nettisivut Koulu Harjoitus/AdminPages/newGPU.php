
<html lang="en">
<head>
  <title>GPU - Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
   <!-- Latest compiled and minified Bootstrap JavaScript 
   https://www.codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
   -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
function myFunctionName() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInputN");
	filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else 
      {
        tr[i].style.display = "none";
      }
    }   
  }
}

function myFunctionID() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInputI");
	filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else 
      {
        tr[i].style.display = "none";
      }
    }   
  }
}

function checkDelete(str){
    return confirm('Haluatko Varmasti Poistaa ' + str + '?');
}


</script>
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
      <li class="active"><a href="newGPU.php">GPU</a></li>
      <li><a href="newCPU.php">CPU</a></li>
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
            </select>
            </td>
            
          </tr>

         <tr>
            <td>CUDA Stream</td>
            <td><input type='text' name='CUDA' placeholder ='Numero' class='form-control' /></td>

            <td>Vakio kellotaajuus</td>
            <td><input type='text' name='VakKello'placeholder ='Numero' class='form-control' /></td>

            <td>Boost kellotaajuus</td>
            <td><input type='text' name='BoostKello'placeholder ='Numero' class='form-control' /></td>

            <td>Muistin kellotaajuus</td>
            <td><input type='text' name='MuistiKello' placeholder ='Numero' class='form-control' /></td>
        </tr>
        <tr>
            <td>Muistin kapasiteetti</td>
            <td><input type='text' name='MuistiKap' placeholder ='Numero'class='form-control' /></td>

            <td>Muistin tyyppi</td>
            <td><input type='text' name='MuistiTyyp' placeholder ='Numero' class='form-control' /></td>

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
            </select>
            </td>

        </tr>
        <tr>
            <td>Pituus</td>
            <td><input type='text' placeholder ='Numero' name='Pituus' class='form-control' /></td>

            <td>Korkeus</td>
            <td><input type='text' placeholder ='Numero' name='Korkeus' class='form-control' /></td>

            <td>Leveys</td>
            <td><input type='text' placeholder ='Numero' name='Leveys' class='form-control' /></td>

            <td>Maksimi pystyresoluutio</td>
            <td><input type='text' placeholder ='Numero' name='MaxPystRes' class='form-control' /></td>

            <td>Maksimi vaakaresoluutio</td>
            <td><input type='text'placeholder ='Numero' name='MaxVaakRes' class='form-control' /></td>

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
    $lisaysKomento = "INSERT INTO TeknisetGPU SET SarjaID =:Sarja, VirtaliitinID =:Virtaliitin, ValmistajaID =:Valmistaja, MerkkiID =:Merkki, MalliID =:Malli, CUDA_STREAM =:CUDA, 
    GPUKellotaajuusBASE =:VakKello, GPUKellotaajuusBOOST =:BoostKello, GPUMEMKellotaajuus =:MuistiKello, GPUMEMKapasiteetti =:MuistiKap, GDDR =:MuistiTyyp, VaylaID =:Vayla, Pituus =:Pituus, Korkeus =:Korkeus, 
    Leveys =:Leveys, MaxPystyReso =:MaxPystRes, MaxVaakaReso =:MaxVaakRes, GPURating =:Rating";
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
       $sqlLause = "SELECT MAX(GPU_ID) as max_id FROM TeknisetGPU";
       $komento = $yhteys->prepare($sqlLause);
       $komento->execute();
       $rivi = $komento->fetch(PDO::FETCH_ASSOC);
       $max_id = $rivi['max_id'];
       echo "<br> <a href='LisaaKauppa.php?ID={$max_id}&IDN=GPU_ID&Taulu=TeknisetGPU&Is=GPU&Return=newGPU' class='btn btn-primary m-r-1em'>Lisää verkkokauppa linkit</a> </div>";	   
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
  TeknisetGPU.GPU_ID AS GPU_ID, 
  MerkkiNimi , 
  ValmistajaNimi ,    
  SarjaNimi,    
  MalliNimi  
  FROM TeknisetGPU 
  INNER JOIN Merkki ON TeknisetGPU.MerkkiID  = Merkki.MerkkiID
  INNER JOIN Valmistaja ON TeknisetGPU.ValmistajaID  = Valmistaja.ValmistajaID
  INNER JOIN Sarja ON TeknisetGPU.SarjaID  = Sarja.SarjaID
  INNER JOIN Malli ON TeknisetGPU.MalliID = Malli.MalliID";
  
  $komento = $yhteys->prepare($sqlLause);
  $komento->execute();
  
    // palautettujen rivien lukumäärä saadaan näin
    $num = $komento->rowCount();
  
    //check if more than 0 record found
    if($num>0){
  
      echo "<table id='myTable' class='table table-hover table-responsive table-bordered'>";//start table
  
      echo "<tr>";
          echo "<th>ID</th>";
          echo "<th>GPU</th>";
      echo "</tr>";
      
    // haetaan kaikki osastot 
    // fetch() on nopeampi kuin fetchAll()
  

    while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
      // extract muuttaa
      extract($rivi);

      // tehdään jokaisesta osastotaulun rivistä oma rivi tauluun
          echo "<tr>";
          echo "<td>{$GPU_ID}</td>";
          echo "<td>$MerkkiNimi $ValmistajaNimi $SarjaNimi $MalliNimi</td>";
          echo "<td>";
              echo "<a href='GPUYllapito.php?ID={$GPU_ID}&Return=newGPU' class='btn btn-primary m-r-1em'>Ylläpidä osastotietoja</a> &nbsp";
              echo "<a href='Naytonliittimet.php?ID={$GPU_ID}&Return=newGPU' class='btn btn-success m-r-1em'>Liittimet</a> &nbsp";
              echo "<a  href='DeleteGPU.php?poistoLinkkiTID=GPUTuoteID&poistTaulu=TeknisetGPU&Taulu=GPUVerkkokauppalinkit&poistID={$GPU_ID}&poistIDN=GPU_ID&Return=newGPU' onclick='return checkDelete(this.id)' class='btn btn-danger' id='$GPU_ID - $MerkkiNimi $ValmistajaNimi $SarjaNimi $MalliNimi'>Poista osasto</a>  &nbsp";
              echo "<a  href='LisaaKauppa.php?ID={$GPU_ID}&IDN=GPU_ID&Taulu=TeknisetGPU&Is=GPU&Return=newGPU' class='btn btn-warning'>Linkkien Hallinta</a>  &nbsp";

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
