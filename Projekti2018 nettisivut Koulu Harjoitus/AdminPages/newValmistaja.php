
<html lang="en">
<head>
  <title>Valmistaja - Admin</title>
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
      <li class="active"><a href="newValmistaja.php">Valmistaja</a></li>
      <li><a href="newMerkki.php">Merkki</a></li>
      <li><a href="newSarja.php">Sarja</a></li>
      <li><a href="newMalli.php">Malli</a></li>
      <li><a href="newVirtaliitin.php">Virtaliitin</a></li>
      <li><a href="newVayla.php">Väylä</a></li>
      <li><a href="newLiitin.php">Liitin</a></li>
      <li><a href="newCPU_Kanta.php">CPU kanta</a></li>
      <li><a href="newGPU.php">GPU</a></li>
      <li><a href="newCPU.php">CPU</a></li>
    </ul>
       <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
  </div>
  
</nav>
  

<!-- html form - kutsuu itseään, eli php-koodi on tässä samassa tiedostossa tuossa yläpuolella -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Uusi valmistaja</td>
            <td><input type='text' name='tyyppi' class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Lisää kantaan' class='btn btn-primary' />
                <a href='adminpage.php' class='btn btn-info'>Takaisin etusivulle</a>
                     <!-- painiketyylejä:  https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_button_styles&stacked=h  -->
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
      $lisaysKomento = "INSERT INTO Valmistaja SET ValmistajaNimi = :tyyppi ";
	  $sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
	  $tyyppi = htmlspecialchars(strip_tags($_POST["tyyppi"]));
	  
	  // laitetaan käyttäjän antamat tiedot nimettyjen parametrien tilalle
	  $sqlLause->bindParam(':tyyppi', $tyyppi);
	  
	  // suorita kysely käyttäjän antamilla tiedoilla
	   if ($sqlLause->execute()){
           echo "<div class='alert alert-success'>Tietue on lisätty.</div>";
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

  
    $sqlLause = "SELECT ValmistajaID, ValmistajaNimi FROM Valmistaja ";
    $komento = $yhteys->prepare($sqlLause);
    $komento->execute();
  
    // palautettujen rivien lukumäärä saadaan näin
    $num = $komento->rowCount();
  
    //check if more than 0 record found
    if($num>0){
  
      echo "<table id='myTable' class='table table-hover table-responsive table-bordered'>";//start table
  
      echo "<tr>";
          echo "<th>ID</th>";
          echo "<th>Valmistajami</th>";
      echo "</tr>";
      
    // haetaan kaikki osastot 
    // fetch() on nopeampi kuin fetchAll()
  

    while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
      // extract muuttaa
      extract($rivi);

      // tehdään jokaisesta osastotaulun rivistä oma rivi tauluun
          echo "<tr>";
          echo "<td>{$ValmistajaID}</td>";
          echo "<td>$ValmistajaNimi</td>";
          echo "<td>";
              echo "<a href='Yllapito.php?ID={$ValmistajaID}&IDN=ValmistajaID&Nimi=ValmistajaNimi&Taulu=Valmistaja&Return=Valmistaja' class='btn btn-primary m-r-1em'>Ylläpidä osastotietoja</a> &nbsp";
              echo "<a  href='deleteTiedosto.php?poistTaulu=Valmistaja&poistID={$ValmistajaID}&poistIDN=ValmistajaID&Return=newValmistaja' onclick='return checkDelete(this.id)' class='btn btn-danger' id='$ValmistajaID - $ValmistajaNimi'>Poista osasto</a>";
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