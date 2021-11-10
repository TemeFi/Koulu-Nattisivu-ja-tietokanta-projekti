<html lang="en">
<head>
  <title>Vertailutyökalu - Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      <?php

include 'logininfo.php';

$key1=10000;
$key2=10000;

//HAE CPU määrä

$sqlLause = "SELECT COUNT(CPU_ID) AS CPUkpl
FROM TeknisetCPU;";



$komento = $yhteys->prepare($sqlLause);
$komento->execute();

// palautettujen rivien lukumäärä saadaan näin
$num = $komento->rowCount();

//check if more than 0 record found
if($num>0){

// haetaan kaikki osastot
// fetch() on nopeampi kuin fetchAll()

while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
// extract muuttaa
//  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
extract($rivi);
}
}


//HAE CPU 2

$sqlLause = "SELECT COUNT(GPU_ID) AS GPUkpl
FROM TeknisetGPU;";



$komento = $yhteys->prepare($sqlLause);
$komento->execute();

// palautettujen rivien lukumäärä saadaan näin
$num = $komento->rowCount();

//check if more than 0 record found
if($num>0){

// haetaan kaikki osastot
// fetch() on nopeampi kuin fetchAll()

while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
// extract muuttaa
//  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
extract($rivi);
}
}

      ?>


      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tuote', 'KPL'],
          ['CPU',     <?php echo $CPUkpl; ?>],
          ['GPU',    <?php echo $GPUkpl; ?>]
        ]);

        var options = {
          title: ' Tuotemäärät',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <style>
    .navbar-fixed-left {
  width: 140px;
  position: fixed;
  border-radius: 0;
  height: 100%;
  left: 0px;
}

.navbar-fixed-left .navbar-nav > li {
  float: none;  /* Cancel default li float: left */
  width: 139px;
}

.navbar-fixed-left + .container {
  padding-left: 160px;
}

/* On using dropdown menu (To right shift popuped) */
.navbar-fixed-left .navbar-nav > li > .dropdown-menu {
  margin-top: -50px;
  margin-left: 140px;
}
</style>
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
      <li><a href="newCPU.php">CPU</a></li>
    </ul>
       <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
  </div>
  
</nav>

<div class="container-fluid">
<div class="col-sm-6">

<!-- html form - kutsuu itseään, eli php-koodi on tässä samassa tiedostossa tuossa yläpuolella -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            
            <div class="form-group">
            <label for="username">Otsikko</label>
            <input type="text" autocomplete="off" class="form-control" name="tyyppi"><br>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Teksti</label>
            <textarea class="form-control" name="tyyppi1" id="exampleFormControlTextarea1" rows="3"></textarea>>
        </div>
            <input type='submit' value='Lähetä' class='btn btn-primary' />

</form>
</div>

<div class="col-sm-6">
<div id="donutchart" style="width: 900px; height: 500px;"></div>
</div>
<?php

$user = ($_SESSION['user_id']);

$sqlLause = "SELECT login, AdminID from `Admins` WHERE login = '" .  $user. "' ";



$komento = $yhteys->prepare($sqlLause);
$komento->execute();

// palautettujen rivien lukumäärä saadaan näin
$num = $komento->rowCount();

//check if more than 0 record found
if($num>0){

// haetaan kaikki osastot
// fetch() on nopeampi kuin fetchAll()

while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
// extract muuttaa
//  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
extract($rivi);
}
}


$adminID = $AdminID;




// ensin ehto, joka varmistaa, että käyttäjä näkee ensin lomakkeen ja vasta sen jälkeen kun 
// lomakkeelta lähetetään tietoa, tapahtuu tämä php-koodi

if($_POST){
        
  // include hakee yhteyden tietokantaan, jossa on osasto-taulu, yhteys-objektille on annettu nimi $yhteys
  include 'logininfo.php';

  try{
  // tehdään insert eli tietorivin lisääminen tietokantaan
    // insert-kysely muodostetaan käyttäen nimettyjä parametreja
    // lisättävien tietojen sijalla	  
    $lisaysKomento = "INSERT INTO Blogi SET Otsikko =:tyyppi, Teksti =:tyyppi1, Admin = $adminID;";
  $sqlLause = $yhteys->prepare($lisaysKomento);
  
  // haetaan käyttäjän antamat tiedot ja putsataan ne laittomuuksista
  $tyyppi = htmlspecialchars(strip_tags($_POST["tyyppi"]));
  $tyyppi1 = $_POST["tyyppi1"];
  // laitetaan käyttäjän antamat tiedot nimettyjen parametrien tilalle
  $sqlLause->bindParam(':tyyppi', $tyyppi);
  $sqlLause->bindParam(':tyyppi1', $tyyppi1);
  
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



</body>
</html>