<html lang="en">
<head>



  <title>Vertailutyökalu - CPU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<!-- hakukentän tyylit -->
<style>
#show_up{
  display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}
#show_up a{
	border-bottom: 1px solid #ddd;
	display: block;
	padding: 5px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}


/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}



</style>
 <!-- Ajax hakukenttä -->
 <script>
$(document).ready(function(e){
	$("#search").keyup(function(){


    var chatinput = document.getElementById("search").value;
if (chatinput.length > 0)
{
  $("#show_up").show();
		var text = $(this).val();
		$.ajax({
			type: 'GET',
			url: 'search.php',
			data: 'txt=' + text,
			success: function(data){
				$("#show_up").html(data);
			}
		});
}
else {
  $("#show_up").hide();
}
	})
});
</script>

</head>
<body>


<?php
session_start();
include('AdminPages/loginCheck.php');
?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="etusivu.php"><img class="img-responsive" src="Logo.png" alt="Chania" width="150" height="150"> </a>
    </div>
    <ul class="nav navbar-nav">
    <li><a href="etusivu.php">Home</a></li>
      <li><a href="cpucomparison.php">Compare CPU's</a></li>
      <li><a href="gpucomparison.php">Compare GPU's</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Listed components <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="listCPU.php">CPU list</a></li>
          <li><a href="listGPU.php">GPU list</a></li>
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left">
      <div class="form-group">
      <input type="text" class="form-control" autocomplete="off" placeholder="Search CPU or GPU" name="names" id="search" />
      </div>
      <div id="show_up"></div>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <?php julkinenTest();?>
    </ul>
  </div>
</nav>


    <div class="container">
  
  <div class="page-header">
  </div>
<?php
include 'AdminPages/logininfo.php';

$key=$_GET['ID'];



$sqlLause = "SELECT CPURating, MerkkiNimi, SarjaNimi, Kanta, Kellotaajuus, MAX_Kellotaajuus, Malli, TDP, Teknologia, Threadit, Valimuisti, Ytimet 

from TeknisetCPU 

INNER JOIN Sarja ON Sarja.SarjaID = TeknisetCPU.SarjaID 
  
INNER JOIN Merkki ON Merkki.MerkkiID = TeknisetCPU.MerkkiID 

INNER JOIN CPU_Kanta ON CPU_Kanta.KantaID = TeknisetCPU.KantaID

WHERE CPU_ID = $key;";



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

// tehdään jokaisesta osastotaulun rivistä oma rivi tauluun

// uusi table

$Kellotaajuus = $Kellotaajuus/1000;
$MAX_Kellotaajuus = $MAX_Kellotaajuus/1000;


echo "<div class='container'>";
echo  "<h2>{$MerkkiNimi} {$SarjaNimi} {$Malli}</h2>";        
echo  "<table class='table'>";
echo    "<thead>";
echo    "<tr>";
echo      "</tr>";
echo    "</thead>";
echo    "<tbody>";
echo      "<tr>";
echo        "<td>Merkki</td>";
echo        "<td>{$MerkkiNimi}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Sarja</td>";
echo        "<td>{$SarjaNimi}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Malli</td>";
echo        "<td>{$Malli}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Kanta</td>";
echo        "<td>{$Kanta}</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Kellotaajuus</td>";
echo        "<td>{$Kellotaajuus} GHz</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>Maksimi kellotaajuus</td>";
echo        "<td>{$MAX_Kellotaajuus} GHz</td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td>TDP</td>";
echo        "<td>{$TDP} W</td>";
echo      "</tr>";
echo        "<td>Teknologia</td>";
echo        "<td>{$Teknologia} nm</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Threadit</td>";
echo        "<td>{$Threadit}</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Valimuisti</td>";
echo        "<td>{$Valimuisti} MB</td>";
echo      "</tr>";
echo      "</tr>";
echo        "<td>Ytimet</td>";
echo        "<td>{$Ytimet}</td>";
echo      "</tr>";
echo    "</tbody>";
echo  "</table>";
echo "</div>";


echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";



//Haetaan hinnat Jimms hinnat

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}


//Haetaan URL osoitteet

$sqlLause = "SELECT Linkki AS JimmsLinkki
FROM CPUVerkkokauppalinkit
WHERE VerkkokauppaID = 600 AND CPUTuoteID = $key;";


$komento = $yhteys->prepare($sqlLause);
$komento->execute();

while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
  // extract muuttaa
  //  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
  extract($rivi);

// Jimms

$html = file_get_contents_curl($JimmsLinkki);


$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

//get and display what you need:
$title = $nodes->item(0)->nodeValue;

$metas = $doc->getElementsByTagName('meta');

for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('property') == 'product:price:amount')
        $hintaJimms = $meta->getAttribute('content');
}
}
}
}




$sqlLause = "SELECT Linkki AS GiganttiLinkki
FROM CPUVerkkokauppalinkit
WHERE VerkkokauppaID = 601 AND CPUTuoteID = $key;";


$komento = $yhteys->prepare($sqlLause);
$komento->execute();

while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
  // extract muuttaa
  //  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
  extract($rivi);



$html = file_get_contents_curl($GiganttiLinkki);

$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

//get and display what you need:
$title = $nodes->item(0)->nodeValue;

$metas = $doc->getElementsByTagName('meta');

for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('itemprop') == 'price')
        $hintaGigantti = $meta->getAttribute('content');
}
 }


 $sqlLause = "SELECT Linkki AS POWERLinkki
 FROM CPUVerkkokauppalinkit
 WHERE VerkkokauppaID = 605 AND CPUTuoteID = $key;";
 
 
 $komento = $yhteys->prepare($sqlLause);
 $komento->execute();
 
 while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
   // extract muuttaa
   //  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
   extract($rivi);
 
 
 
 $html = file_get_contents_curl($POWERLinkki);
 
 $doc = new DOMDocument();
 @$doc->loadHTML($html);
 $nodes = $doc->getElementsByTagName('title');
 
 //get and display what you need:
 $title = $nodes->item(0)->nodeValue;
 
 $metas = $doc->getElementsByTagName('meta');
 
 for ($i = 0; $i < $metas->length; $i++)
 {
     $meta = $metas->item($i);
     if($meta->getAttribute('property') == 'product:price:amount')
         $hintaPOWER = $meta->getAttribute('content');
 }
 }



//Tulostus


echo "<div class='container'>";
echo  "<h2>Hinnat</h2>";        
echo  "<table class='table'>";
echo    "<thead>";
echo    "<tr>";
echo      "</tr>";
echo    "</thead>";
echo    "<tbody>";
echo      "<tr>";
echo        "<td><a href='$JimmsLinkki'><img class='img-responsive' src='JimmsLogo.png' alt='Jimms Logo' width='150' height='150'></a></td>";
echo        "<td><h3>$hintaJimms € <br/><br/></td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><a href='$GiganttiLinkki'><img class='img-responsive' src='GiganttiLogo.png' alt='Gigantti Logo' width='150' height='150'></a></td>";
echo        "<td><h3>$hintaGigantti € <br/><br/></td>";
echo      "</tr>";
echo      "<tr>";
echo        "<td><a href='$POWERLinkki'><img class='img-responsive' src='POWERLogo.png' alt='POWER Logo' width='150' height='150'></a></td>";
echo        "<td><h3>$hintaPOWER € <br/><br/></td>";
echo      "</tr>";
echo    "</tbody>";
echo  "</table>";
echo "</div>";


echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";





$sqlLause = "SELECT CPURating
 FROM TeknisetCPU
 WHERE CPU_ID = $key";
 
 $komento = $yhteys->prepare($sqlLause);
 $komento->execute();
 
 while ($rivi = $komento->fetch(PDO::FETCH_ASSOC)){
   // extract muuttaa
   //  $rivi['osnimi'] taulukosta alkiot vastaaviin muuttujiin $osnimi 
   extract($rivi);
 }
   

?>



<div class="card text-center">
  <div class="card-body">
    <h2 class="card-title">Vote now!</h2>
    <h3 class="card-text">Votes : <?php echo $CPURating; ?></h3>
    <img src="like.png" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">
  </div>
</div>





<div id="id01" class="modal">
  
  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">

    <div class="g-recaptcha" data-sitekey="6Ldg33cUAAAAAGTa76rl2fYd_pM93SQsEfBQ-NRi"></div>
        
    <button type="submit" name="submitvote "class="btn btn-success">Vote!</button>

    </div>
  </form>
</div>




<?php

require_once "AdminPages/reCaptcha.php";

// your secret key
$secret = "----";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
  $response = $reCaptcha->verifyResponse(
      $_SERVER["REMOTE_ADDR"],
      $_POST["g-recaptcha-response"]
  );
}

if ($response != null && $response->success) {


  $lisaysKomento = "UPDATE TeknisetCPU  

  SET CPURating = CPURating + 1  
  
  WHERE CPU_ID = $key"; 

  $sqlLause = $yhteys->prepare($lisaysKomento);
  $sqlLause->execute();


  }


?>




</body>
</html>
