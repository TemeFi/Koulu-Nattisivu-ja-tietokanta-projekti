<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Linkin lisäys</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         

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
 
    <!-- container -->
    <div class="container">
  
    <div class="page-header">
        <h1>Osaston tietojen muutos</h1>
    </div>
</div>

<?php 

if (isset($_GET["ID"]) && isset($_GET["IDN"]) && isset($_GET["Taulu"]) && isset($_GET["Is"]) && isset($_GET["Return"]))
{
     $ID= $_GET["ID"];
     $IDN= $_GET["IDN"];
     $Taulu= $_GET["Taulu"];
     $Is= $_GET["Is"];
     $Return= $_GET["Return"];
}
else
{
    die('ERROR: Osastoa ei löydy.');
}

$Verkkokauppa = $Is . "Verkkokauppalinkit";
$TuoteID =   $Is . "TuoteID";
?>

<div class="container-fluid">
<!-- html form - kutsuu itseään, eli php-koodi on tässä samassa tiedostossa tuossa yläpuolella -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] ."?ID={$ID}&IDN={$IDN}&Taulu={$Taulu}&Is={$Is}&Return=$Return");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
        <td><?php echo $Is . " ID" ?> </td>
            <td><?php echo $ID; ?></td>

            <td>Verkkokaupa</td>
            <?php
              include 'logininfo.php';
              $sql = "SELECT VerkkokauppaID ,Kauppa FROM Verkkokaupat";
              $komento = $yhteys->prepare($sql);
              $komento ->execute();
              $tulos = $komento->fetchAll();
              ?>
            <td><select class='form-control' name='VerkkokauppaID'>
            <?php foreach ($tulos as $row){ ?>
            <option value="<?php echo $row['VerkkokauppaID'];?>"> <?php echo $row['Kauppa'];?> </option>
                <?php } ?>
            </select>
            </td>
         </tr>

         <tr>
            <td>Linkki</td>
            <td><input type='text' name='Linkki' class='form-control' /></td>

            <td>Hinta</td>
            <td><input type='text' name='Hinta' class='form-control' /></td>
        </tr>

        <tr>
        <td>
                <input type='submit' value='Talleta' class='btn btn-primary' />
                <a href="<?php echo $Return;?>.php" class='btn btn-info'>Takaisin</a>
            </td>
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
    $lisaysKomento = "INSERT INTO $Verkkokauppa SET $TuoteID=$ID, VerkkokauppaID=:VerkkokauppaID, Linkki=:Linkki, Hinta=:Hinta";
	$sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
      $VerkkokauppaID = htmlspecialchars(strip_tags($_POST["VerkkokauppaID"]));	
      $Linkki = htmlspecialchars(strip_tags($_POST["Linkki"]));	 	
      $Hinta = htmlspecialchars(strip_tags($_POST["Hinta"]));	 

      $sqlLause->bindParam(':VerkkokauppaID', $VerkkokauppaID);	                                                        
      $sqlLause->bindParam(':Linkki', $Linkki);
      $sqlLause->bindParam(':Hinta', $Hinta);	                           

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
echo $TuoteID;

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

    $sqlLause = "SELECT $Verkkokauppa.$TuoteID as TID,  $Verkkokauppa.VerkkokauppaID, Kauppa, $Verkkokauppa.Linkki, $Verkkokauppa.PaivitysPVM, $Verkkokauppa.Hinta 
    FROM $Verkkokauppa 
    INNER JOIN Verkkokaupat ON $Verkkokauppa.VerkkokauppaID  = Verkkokaupat.VerkkokauppaID 
    WHERE $TuoteID = $ID";
    $komento = $yhteys->prepare($sqlLause);
    $komento->execute();
  

    // palautettujen rivien lukumäärä saadaan näin
    $num = $komento->rowCount();
  
    //check if more than 0 record found
    if($num>0){
  
      echo "<table id='myTable' class='table table-hover table-responsive table-bordered'>";//start table
  
      echo "<tr>";
          echo "<th>TuoteID</th>";
          echo "<th>VerkkokauppaID</th>";
          echo "<th>Linkki</th>";
          echo "<th>Päivitys PVM</th>";
          echo "<th>Hinta</th>";
      echo "</tr>";
      
    // haetaan kaikki osastot 
    // fetch() on nopeampi kuin fetchAll()
  

    while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
      // extract muuttaa
      extract($rivi);
      // tehdään jokaisesta osastotaulun rivistä oma rivi tauluun
          echo "<tr>";
          echo "<td>{$TID}</td>";
          echo "<td>{$Kauppa}</td>";
          echo "<td>{$Linkki}</td>";
          echo "<td>{$PaivitysPVM}</td>";
          echo "<td>{$Hinta}</td>";
          echo "<td>";
             // echo "<a href='GPUYllapito.php?ID={$GPU_ID}&Return=newGPU' class='btn btn-primary m-r-1em'>Ylläpidä osastotietoja</a> &nbsp";
              echo "<a  href='deleteLink.php?gpuID=GPU_ID&poistTaulu=$Verkkokauppa&poistID={$VerkkokauppaID}&poistID2={$TID}&poistIDN=VerkkokauppaID&poistIDN2=$TuoteID&Is={$Is}&Return=LisaaKauppa.php?ID={$ID}&IDN={$IDN}&Taulu={$Taulu}&Return=$Return' onclick='return checkDelete(this.id)' class='btn btn-danger' id='$TID $VerkkokauppaID - $Linkki $Hinta'>Poista osasto</a>";
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
