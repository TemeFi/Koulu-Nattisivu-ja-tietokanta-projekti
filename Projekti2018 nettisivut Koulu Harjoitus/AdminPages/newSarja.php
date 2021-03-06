<html lang="en">
<head>
  <title>Sarja - Admin</title>
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
      <li class="active"><a href="newSarja.php">Sarja</a></li>
      <li><a href="newMalli.php">Malli</a></li>
      <li><a href="newVirtaliitin.php">Virtaliitin</a></li>
      <li><a href="newVayla.php">V??yl??</a></li>
      <li><a href="newLiitin.php">Liitin</a></li>
      <li><a href="newCPU_Kanta.php">CPU kanta</a></li>
      <li><a href="newGPU.php">GPU</a></li>
      <li><a href="newCPU.php">CPU</a></li>
    </ul>
       <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
  </div>  
</nav>
  
<!-- html form - kutsuu itse????n, eli php-koodi on t??ss?? samassa tiedostossa tuossa yl??puolella -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Uusi Sarja</td>
            <td><input type='text' name='tyyppi' class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Lis???? kantaan' class='btn btn-primary' />
                <a href='adminpage.php' class='btn btn-info'>Takaisin etusivulle</a>
                     <!-- painiketyylej??:  https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_button_styles&stacked=h  -->
            </td>
        </tr>
    </table>
</form>

          
 </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript 
https://www.codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<?php

// ensin ehto, joka varmistaa, ett?? k??ytt??j?? n??kee ensin lomakkeen ja vasta sen j??lkeen kun 
// lomakkeelta l??hetet????n tietoa, tapahtuu t??m?? php-koodi

	if($_POST){
        
    // include hakee yhteyden tietokantaan, jossa on osasto-taulu, yhteys-objektille on annettu nimi $yhteys
    include 'logininfo.php';
 
    try{
	  // tehd????n insert eli tietorivin lis????minen tietokantaan
      // insert-kysely muodostetaan k??ytt??en nimettyj?? parametreja
      // lis??tt??vien tietojen sijalla	  
      $lisaysKomento = "INSERT INTO Sarja SET SarjaNimi = :tyyppi ";
	  $sqlLause = $yhteys->prepare($lisaysKomento);
	  
	  // haetaan k??ytt??j??n antamat tiedot ja putsataan ne laittomuuksista
	  $tyyppi = htmlspecialchars(strip_tags($_POST["tyyppi"]));
	  
	  // laitetaan k??ytt??j??n antamat tiedot nimettyjen parametrien tilalle
	  $sqlLause->bindParam(':tyyppi', $tyyppi);
	  
	  // suorita kysely k??ytt??j??n antamilla tiedoilla
	   if ($sqlLause->execute()){
		   echo "<div class='alert alert-success'>Tietue on lis??tty.</div>";
	   } else {
		   echo "<div class='alert alert-success'>Tietuetta EI lis??tty.</div>";
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

    
    $sqlLause = "SELECT SarjaID, SarjaNimi FROM Sarja ";
    $komento = $yhteys->prepare($sqlLause);
    $komento->execute();
    
    // palautettujen rivien lukum????r?? saadaan n??in
    $num = $komento->rowCount();
    
    //check if more than 0 record found
    if($num>0){
    
        echo "<table id='myTable' class='table table-hover table-responsive table-bordered'>";//start table
    
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Sarja</th>";
        echo "</tr>";
        
    // haetaan kaikki osastot 
    // fetch() on nopeampi kuin fetchAll()
    

    while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
        // extract muuttaa
        extract($rivi);


        // tehd????n jokaisesta osastotaulun rivist?? oma rivi tauluun
            echo "<tr>";
            echo "<td>{$SarjaID}</td>";
            echo "<td>{$SarjaNimi}</td>";
            echo "<td>";
                echo "<a href='Yllapito.php?ID={$SarjaID}&IDN=SarjaID&Nimi=SarjaNimi&Taulu=Sarja&Return=Sarja' class='btn btn-primary m-r-1em'>Yll??pid?? osastotietoja</a> &nbsp";
                echo "<a  href='deleteTiedosto.php?poistTaulu=Sarja&poistID={$SarjaID}&poistIDN=SarjaID&Return=newSarja' onclick='return checkDelete(this.id)' class='btn btn-danger' id='$SarjaID - $SarjaNimi'>Poista osasto</a>";
            echo "</td>";
        echo "</tr>";
    }
    }
    
    // jos ei l??ytynyt yht????n
    else{
        echo "<div class='alert alert-danger'>Osastoja ei l??ytynyt yht????n.</div>";
    }
    ?>
 </div>
</body>
</html>