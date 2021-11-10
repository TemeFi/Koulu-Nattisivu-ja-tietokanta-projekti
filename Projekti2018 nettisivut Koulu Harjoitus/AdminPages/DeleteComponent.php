<html lang="en">
<head>
  <title>Vertailutyökalu - Admin</title>
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
</head>
<body>

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


<?php
session_start();
require('loginCheck.php');
testaaLogin();

$servername = "mysql.cc.puv.fi";
$username = "e1701247";
$password = "RTySaR9anuqv";
$dbname = "e1701247_vertailu";


if (isset($_GET["poistoLinkkiTID"]) &&isset($_GET["poistTaulu"]) && isset($_GET["Taulu"])&& isset($_GET["poistID"]) && isset($_GET["poistIDN"])&& isset($_GET["Return"]))
{
    $poistoLinkkiTID =  $_GET["poistoLinkkiTID"];
    $poistIDN =  $_GET["poistIDN"];
    $Taulu =  $_GET["Taulu"];
    $poistTaulu= $_GET["poistTaulu"];
    $poistID = $_GET["poistID"];
    $Return = $_GET["Return"];

}
else
{
    die('ERROR: Osastoa ei löydy.');
}



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // sql to delete a record
    $sql = "DELETE FROM $Taulu WHERE $poistoLinkkiTID=$poistID";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "<div class='alert alert-success'> <strong>OK. Linkin</strong> Poisto onnistui</div>";
    }
    catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // sql to delete a record
    $sql = "DELETE FROM $poistTaulu WHERE $poistIDN=$poistID";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "<div class='alert alert-success'> <strong>OK </strong> Poisto onnistui</div>";
    }
    catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;
?> 

<form>
    <table class='table table-hover table-responsive table-bordered'>
            <td>
                <a href="<?php echo $Return;?>.php" class='btn btn-info'>Takaisin Edelliselle Sivulle</a>
            </td>
        </tr>
    </table>
</form>


</body>
</html>